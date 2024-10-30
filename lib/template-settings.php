<?php

namespace Sirvelia\CBT;

add_action( 'admin_menu', __NAMESPACE__ . '\setup_settings_page' );
add_action( 'admin_init', __NAMESPACE__ . '\setup_settings_sections' );


/**
 * Setup Settings menu and page
 *
 * @since    1.0.0
 */

function setup_settings_page() {

	add_submenu_page(
		'edit.php?post_type=block-template',
		__('Assign templates', 'custom-blocks-templates'),
		__('Assign templates', 'custom-blocks-templates'),
		'manage_options',
		'cbt-settings',
		__NAMESPACE__ . '\show_settings_page'
	);

}

/**
 * Show Settings Menu.
 *
 * @since    1.0.0
 */

function show_settings_page() {
	ob_start(); ?>
	<div class="wrap">
		<h1><?php _e('Assign block templates', 'custom-blocks-templates'); ?></h1>
		<form method="post" class="cbt-settings-form" action="options.php">
			<?php
				settings_errors();
				settings_fields( 'cbt-settings' );
				do_settings_sections( 'cbt-settings' );
				submit_button();
			?>
		</form>
	</div>
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	echo $output;
}

/**
 * Setup Settings Menu Sections and Fields.
 *
 * @since    1.0.0
 */
function setup_settings_sections() {

	$post_types = get_post_types( $args=array( 'public'   => true ), $output='names', $operator='and' );

	foreach ($post_types as $post_type) {
		if($post_type != 'attachment') {

			add_settings_section( 'settings-templates_' . $post_type, $post_type, __NAMESPACE__ . '\sections_callback', 'cbt-settings' );

			add_settings_field( 'cbt_template_' . $post_type, __('Template', 'custom-blocks-templates'), __NAMESPACE__ . '\display_templates', 'cbt-settings', 'settings-templates_' . $post_type, 'cbt_template_' . $post_type );
			register_setting( 'cbt-settings', 'cbt_template_' . $post_type ); //Menu - uid

			add_settings_field( 'cbt_editable_' . $post_type, __('Edit', 'custom-blocks-templates'), __NAMESPACE__ . '\display_edit_options', 'cbt-settings', 'settings-templates_' . $post_type, 'cbt_editable_' . $post_type );
			register_setting( 'cbt-settings', 'cbt_editable_' . $post_type ); //Menu - uid

		}
	}

}


/**
 * Displays available templates
 *
 * @since  1.0.0
 * @ignore
 * @access private
 *
 */
function display_templates($field) {
	$args = array(
	  'numberposts' => -1,
	  'post_type'   => 'block-template'
	);
	$templates = get_posts( $args ); ?>
	<select name="<?= $field ?>" id="<?= $field ?>">
		<option value="-1" <?php selected(get_option($field), "-1"); ?>><?= __('No template' , 'custom-blocks-templates') ?></option>
		<?php foreach ($templates as $template): ?>
			<option value="<?= $template->ID ?>" <?php selected(get_option($field), $template->ID); ?>>
				<?= $template->post_title ?>
			</option>
		<?php endforeach; ?>
	</select>
	<?php
}

/**
 * Displays edit options
 *
 * @since  1.0.0
 * @ignore
 * @access private
 *
 */
function display_edit_options($field) {
	?>
	<select name="<?= $field ?>" id="<?= $field ?>">
		<option value="false" <?php selected(get_option($field), "false"); ?>>Editable</option>
	  <option value="all" <?php selected(get_option($field), "all"); ?>>Locked</option>
	  <option value="insert" <?php selected(get_option($field), "insert"); ?>>Orderable</option>
	</select>
	<?php
}



/**
 * Show Settings Sections.
 *
 * @since    1.0.0
 */
function sections_callback( $args ) {

	switch( $args['id'] ) {
		default:
			break;
	}

}
