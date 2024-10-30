<?php

namespace Sirvelia\CBT\Accordion;


add_action( 'plugins_loaded', __NAMESPACE__ . '\register_accordion' );
/**
 * Register the accordion block.
 *
 * @since 1.2.0
 *
 * @return void
 */
function register_accordion() {

	// Only load if Gutenberg is available.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Hook server side rendering into render callback
	register_block_type( 'custom-blocks-templates/accordion',
		array(
      'heading' => array(
        'type' => 'string'
      ),
			'render_callback' => __NAMESPACE__ . '\render_accordion',
		)
 	);

}

/**
 * Server rendering for /custom-blocks-templates/accordion
 */
function render_accordion($attributes, $content) {
	$heading = isset($attributes['heading']) ? $attributes['heading'] : '';
  $heading_esc = urlencode($heading);
  $id = uniqid($heading_esc) ;
	ob_start();
  ?>
  <div class="wp-block-custom-blocks-templates-accordion">
    <input type="checkbox" id="<?= $id ?>" />
    <label for="<?= $id ?>"><?= $heading ?></label>
    <?= $content ?>
  </div>
  <?php
	return ob_get_clean();
}
