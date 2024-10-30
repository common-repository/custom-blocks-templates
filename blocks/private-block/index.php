<?php

namespace Sirvelia\CBT\PrivateBlock;

add_action( 'admin_post_check_block_password', __NAMESPACE__ . '\check_block_password' );
/**
 * Password protected block check. Creates cookie if needed.
 *
 * @since 1.0.0
 *
 * @return void
 */
function check_block_password() {
	if ( isset( $_POST['submit'] ) ) {

		$post_id = intval( $_POST['post_id'] );
		$block_id = sanitize_text_field( $_POST['block_id'] );
		$password = sanitize_text_field( $_POST['block_password'] );

		if( $block_id && is_int($post_id) ) {

			$post = get_post($post_id);

			if ( has_blocks( $post->post_content ) ) {
		    $blocks = parse_blocks( $post->post_content );
				foreach ($blocks as $block) {
					if( $block['blockName'] === 'custom-blocks-templates/private-blocks' ) {
						if( isset($block['attrs']) ) {
							$atts = $block['attrs'];
							if( isset($atts['blockId']) && $atts['blockId'] == $block_id ) {
								if( isset($atts['passwordControl']) && $atts['passwordControl'] == $password ) {
									//CORRECT PASSWORD => SAVE COOKIE
									$cookie_name = 'pw' . $post_id  . '_'  . $block_id;
									$cookie_value = password_hash($password, PASSWORD_DEFAULT);
									setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
									header( "Location: " . get_permalink($post_id) );
							    die();
								}
								break;
							}
						}
					}
				}
			}

		}

		header( "Location: " . get_permalink($post_id) . '?wrong_password' );
		die('WRONG PASSWORD');

	}

}


add_action( 'plugins_loaded', __NAMESPACE__ . '\register_private_block' );
/**
 * Register the private block.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_private_block() {

	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback
	register_block_type( 'custom-blocks-templates/private-blocks',
		array(
			'attributes' => array(
				'blockId' => array(
	      	'type' => 'string'
	      ),
	      'passwordControl' => array(
	      	'type' => 'string',
					'default' => ''
	      ),
				'blockAlignment' => array(
			    'type' => 'string'
			  ),
			  'checkboxSingleControl' => array(
			    'type' => 'boolean',
			    'default' => true
			  ),
			  'checkboxArchiveControl' => array(
			    'type' => 'boolean',
			    'default' => true
			  ),
			  'toggleLoggedControl' => array(
			    'type' => 'boolean',
					'default' => false
			  ),
			  'selectRolesControl' => array(
			    'type' => 'array',
					//'default' => array(),
					'items'   => array('type' => 'object')
			  )
      ),
			'render_callback' => __NAMESPACE__ . '\render_private_block',
		)
 	);

}

/**
 * Server rendering for /custom-blocks-templates/private-blocks
 */
function render_private_block($attributes, $content) {
	$password = $attributes['passwordControl'];
	$loggedOnly = $attributes['toggleLoggedControl'];
	$showOnSingle = $attributes['checkboxSingleControl'];
	$showOnArchive = $attributes['checkboxArchiveControl'];
	$blockId = $attributes['blockId'];
	$forbiddenRoles = isset($attributes['selectRolesControl']) ? $attributes['selectRolesControl'] : array();
	$post_id = get_the_ID();
	ob_start(); ?>

	<?php
	if( !is_page() ):
		if ( is_archive() ):
			if ( !$showOnArchive ):
				return;// 'PROTECTED CONTENT ARCHIVE';  //TODO: Remove debug msg
			endif;
		elseif( !$showOnSingle ):
			return; //'PROTECTED CONTENT SINGLE';  //TODO: Remove debug msg
		endif;
	endif;
	?>

	<?php if($loggedOnly || $forbiddenRoles):
		if ( !get_current_user_id() ) return wp_login_form(); //TODO: Show log-in form?
		elseif($forbiddenRoles) {
			$user = wp_get_current_user();
    	$roles = ( array ) $user->roles;
			$allowed = false;
			$forbidden = array_column($forbiddenRoles, 'value');
			foreach ($roles as $role): //If one of the user's roles is allowed to see the content, show
				if( !in_array($role, $forbidden) ):
					$allowed = true;
					break;
				endif;
			endforeach;
			if(!$allowed) return; // 'USER NOT ALLOWED'; //TODO: Remove debug msg
		}
	endif; ?>

	<?php if($password): ?>
		<?php $cookie_name = 'pw' . $post_id  . '_'  . $blockId; ?>
		<?php $cookie_set = isset($_COOKIE[$cookie_name]); ?>
		<?php if( !$cookie_set || ( $cookie_set && !password_verify($password, $_COOKIE[$cookie_name]) ) ): ?>
			<form class="post-password-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
				<input type="hidden" name="action" value="check_block_password">
				<input type="hidden" name="block_id" value="<?= $blockId ?>">
				<input type="hidden" name="post_id" value="<?= $post_id ?>">
				<p>
					<?= __('This block is password-protected. To see it\'s contents enter the correct password in the following form:', 'custom-blocks-templates') ?>
				</p>
				<p>
					<label for="pwbox-1">
						<?= __('Password:', 'custom-blocks-templates') ?>
						<input name="block_password" id="pwbox-1" type="password" size="20">
					</label>
					<input type="submit" name="submit" value="<?= __('Enter', 'custom-blocks-templates') ?>">
				</p>
			</form>
			<?php return ob_get_clean(); ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php echo $content;
	return ob_get_clean();
}
