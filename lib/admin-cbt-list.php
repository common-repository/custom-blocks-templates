<?php

namespace Sirvelia\CBT;

/**
 * REMOVE QUICK EDIT
 *
 * @since    1.0.0
 */
add_filter('post_row_actions', function($actions, $post) {
    if ($post->post_type == 'block-template') {
        $post_id = $post->ID;
        $url = admin_url( 'admin.php?page=block-template&post=' . $post_id );
        unset($actions['inline hide-if-no-js']); //Remove quick edit

        //Export button
        $actions = array_merge( $actions, array(
          'export' => sprintf( '<button type="button" class="%1$s" data-id="%2$s" aria-label="%3$s">%3$s</button>',
            'wp-list-blocks-templates__export button-link',
            $post_id,
            __('Export template', 'custom-blocks-templates')
          )
        ) );

        add_thickbox();

        $styles = get_registered_styles();
        $styles = json_decode($styles, true);

        $link_tags = '';
      	if ( $styles ) {
      		$link_tags = '<style>';
      		$i = 1;
      		foreach ( $styles as $style ) {
      			if ( strpos( $style, site_url() ) === 0 ) {
      				$link_tags .= '@import url(\'' . $style . '\');';
      			} else {
      				$link_tags .= '@import url(\'' . site_url( $style ) . '\');';
      			}
      			$i++;
      		}
      		$link_tags .= '</style>';

          ob_start();
          ?>
          <button type="button" class="cbt_show_preview button-link" id="cbt_show_preview_<?php echo $post_id; ?>" data-target="#cbt_preview_modal_<?php echo $post_id; ?>">
      			<?php esc_html_e( 'Preview', 'reusable-blocks-extended' ); ?>
      		</button>
      		<div id="cbt_preview_modal_<?php echo $post_id; ?>" class="cbt_preview_modal" data-title="<?php echo __( 'Template', 'custom-blocks-templates' ) . ' ' . esc_attr( get_the_title( $post_id ) ); ?>">
      			<iframe id="cbt_iframe_<?php echo $post_id; ?>">
      				<?php echo $link_tags; ?>
      				<?php echo apply_filters( 'the_content', get_post_field("post_content", $post_id) ); ?>
      			</iframe>
      		</div>

          <?php $output = ob_get_contents();
        	ob_end_clean();
          $actions = array_merge( $actions, array('preview_cbt' => $output) );
        }
    }
    return $actions;
}, 10, 2);


/**
 * Get Registered Styles
 *
 * @return stylesheets registered
 */
function get_registered_styles() {
  return get_transient('cbt_registered_stylesheets') ? get_transient('cbt_registered_stylesheets') : false;
}



add_action('wp_head',  __NAMESPACE__ . '\urls_of_enqueued_styles');
function urls_of_enqueued_styles( $handles = array() ) {
  $transient = get_transient( 'cbt_registered_stylesheets' );

  if ( false === $transient ) {
    global $wp_styles;
    $results = array();
    foreach( $wp_styles->queue as $style ) {
      $results[] =  $wp_styles->registered[$style]->src;
    }
    set_transient( 'cbt_registered_stylesheets', json_encode( $results ), DAY_IN_SECONDS );
  }

}


/**
 * REMOVE BULK EDIT
 *
 * @since    1.0.0
 */
add_filter('bulk_actions-edit-block-template',  '__return_empty_array');



/**
 * REMOVE SCREEN OPTIONS
 *
 * @since    1.0.0
 */
add_filter('screen_options_show_screen', function($show_screen, $screen) {
	if($screen->id != 'edit-block-template') return $show_screen;
	return false;
}, 10, 2);



/**
 * REMOVE DATE FILTER OPTIONS
 *
 * @since    1.0.0
 */
add_filter('months_dropdown_results', function($show_date_filter, $post_type) {
	if($post_type != 'block-template') return $show_date_filter;
	return array();
}, 10, 2);



/**
 * Sets Block Template CPT column names
 *
 * @since    1.0.0
 */
add_filter('manage_block-template_posts_columns', function($columns) {
  $columns['cbt_used_in'] = __( 'Used in', 'custom-blocks-templates' );
  unset($columns['date']);
  return $columns;
});



/**
 * Adds Block Template CPT column data
 *
 * @since    1.0.0
 */
add_filter('manage_block-template_posts_custom_column', function($column, $post_id) {

  switch ( $column ) {
 		case 'cbt_used_in' :
 			global $wpdb;
      $prefix = $wpdb->prefix;
 			$sql = "SELECT REPLACE(option_name,'cbt_template_', '') AS name, option_value AS value FROM `" . $prefix . "options` WHERE `option_name` LIKE 'cbt_template_%' AND `option_value` = " . $post_id;
 			$results = $wpdb->get_results($sql);

 			if($results):
 		    foreach( $results as $result ):
 	        $post_type = $result->name;
 					$sql2 = "SELECT option_value AS value FROM `" . $prefix . "options` WHERE `option_name` LIKE 'cbt_editable_" . $post_type . "'";
 					$results2 = $wpdb->get_results($sql2); ?>
 					<span class="cbt-label cbt-label-default">
 						<?= ucfirst($post_type) ?>
 						<?php if($results2): ?>
 							<?php switch ($results2[0]->value) {
 								case 'all':
 									echo '(' . __('locked', 'custom-blocks-templates') . ')';
 									break;
 								case 'insert':
 									echo '(' . __('orderable', 'custom-blocks-templates') . ')';
 									break;
 								default:
 									echo '(' . __('editable', 'custom-blocks-templates') . ')';
 									break;
 							} ?>
 						<?php endif; ?>
 					</span>
 		    <?php endforeach; ?>

 			<?php else: ?>
 				<span class="cbt-label cbt-label-unset"><?= __('Not used', 'custom-blocks-templates') ?></span>
 			<?php endif; ?>

      <p>
        <a href="<?= admin_url('edit.php?post_type=block-template&page=cbt-settings') ?>">
          <?= __('Assign to a post type', 'custom-blocks-templates') ?>
        </a>
      </p>


       <?php //add_thickbox(); ?>
       <!-- <div id="cbt-assign" style="display:none;">
         <p>
           <form method="post" class="cbt-settings-form" action="">
       			<style>
       				#TB_title {
       					background: #b534ff;
       					color: white;
       					height: 2rem;
       				}
       			</style>
             <table class="form-table" role="presentation">
               <tbody>
                 <tr>
                   <th scope="row">Post type</th>
                   <td>
                     <?php
                     /*** Fields setup ***/
                   	$args = array(
                   	   'public'   => true,
                   	);

                   	$output = 'names';
                   	$operator = 'and';

                   	$post_types = get_post_types( $args, $output, $operator );
                     ?>

                     <select name="cbt_template_page" id="cbt_template_page">
                       <?php foreach ($post_types as $post_type) {
                         if($post_type != 'attachment') { ?>
                           <option value="-1"><?= $post_type ?></option>
                         <?php }
                       }
                       ?>
                     </select>
                   </td>
                 </tr>
                 <tr>
                   <th scope="row">Edit</th>
                   <td>
                     <select name="cbt_editable_page" id="cbt_editable_page">
                       <option value="false">Editable</option>
                       <option value="all">Locked</option>
                       <option value="insert" selected="selected">Orderable</option>
                     </select>
                   </td>
                 </tr>
               </tbody>
             </table>

             <p class="submit">
               <input type="submit" name="submit" id="submit" class="button button-primary" value="Desa els canvis">
             </p>
       		</form>
         </p>
       </div> -->

       <!-- <a title="Template" href="#TB_inline?width=300&height=250&inlineId=cbt-assign" class="thickbox">
         <?= __('Assign to a post type', 'custom-blocks-templates') ?>
       </a> -->

 		<?php break;
 	}
 }, 10, 2);
