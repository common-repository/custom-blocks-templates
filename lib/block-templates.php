<?php

namespace Sirvelia\CBT;

require 'simple_html_dom.php';

/**
 * Adds Default Content to the Post Types with a template assigned
 *
 * @since    1.0.0
 */
add_filter( 'default_content',  __NAMESPACE__ . '\display_default_content', 10, 2 );
function display_default_content( $content, $post ) {

	$post_type = $post->post_type;
	if($post_type == 'block-template') return $content;

	$template = get_option('cbt_template_' . $post_type);
	if($template && $template != -1) {
		$content_post = get_post($template);
		if($content_post) $content = $content_post->post_content;
	}

  return $content;
}

/**
 * Adds Dynamic text values
 *
 * @since    1.2.0
 */
add_filter( 'the_content',  __NAMESPACE__ . '\filter_the_content_in_the_main_loop' );
function filter_the_content_in_the_main_loop( $content ) {

	if ( in_the_loop() ):

		//DYNAMIC FIELDS
		$html = str_get_html($content);
		if($html):
			$dynamic_fields = $html->find('.cbt-dynamic');
			if($dynamic_fields):
				foreach ($dynamic_fields as $dynamic_field):
					switch ($dynamic_field->{'data-type'}) {
						case 'cbt-author':
							$current_user = wp_get_current_user();
							$dynamic_field->innertext = esc_html( $current_user->display_name );
							break;
						case 'cbt-title':
							$dynamic_field->innertext = esc_html( get_the_title() );
							break;
						case 'cbt-date':
							$dynamic_field->innertext = esc_html( get_the_date() );
							break;
						case 'cbt-tax':
							$taxonomy = $dynamic_field->{'data-tax'};
							$terms = get_the_terms( get_the_ID(), $taxonomy );
							$term_list = '';
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
									$count = count( $terms );
									$i = 0;
									$term_list = '<span class="cbt-terms-list">';
									foreach ( $terms as $term ) {
											$i++;
											$term_list .= '<a href="' . esc_url( get_term_link( $term ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts filed under %s', 'custom-blocks-templates' ), $term->name ) ) . '">' . $term->name . '</a>';
											if ( $count != $i ) {
													$term_list .= ' &middot; ';
											}
											else {
													$term_list .= '</span>';
											}
									}
							}
							$dynamic_field->innertext = $term_list;
							break;
						case 'cbt-theme-option':
							//$dynamic_field->innertext = esc_html( get_the_date() );
							break;
						case 'cbt-acf-field':
							//$dynamic_field->innertext = esc_html( get_the_date() );
							break;
						case 'cbt-website':
							//$dynamic_field->innertext = esc_html( get_the_date() );
							break;

						default:
							// code...
							break;
					}
				endforeach;

				return $html;
			endif;

		endif;

	endif;

  return $content;
}

/**
 * Adds Block Templates
 *
 * @since    1.0.0
 */
add_filter( 'register_post_type_args', __NAMESPACE__ . '\add_template_to_post_type', 20, 2 );
function add_template_to_post_type( $args, $post_type ) {

	if($post_type == 'block-template') return $args;

	//TEMPLATE
	$template = get_option('cbt_template_' . $post_type);
	if($template && $template != -1) {
		//LOCK
		$lock = get_option('cbt_editable_' . $post_type);
		if(!$lock || $lock == 'false') $lock = false;
		$args['template_lock'] = $lock;

		$content_post = get_post($template);
		$blocks = parse_blocks($content_post->post_content);
		$args['template'] = array();

		foreach ($blocks as $block) {

			$block_name = $block['blockName'];
			$block_args = $block['attrs'];
			if($block_name) $args['template'][] = innerBlocks($block);
		}

	}

	return $args;
}


/**
 * Block + Inner Blocks to Array (recursive)
 *
 * @since    1.0.0
 */
function innerBlocks($block) {
	$block_name = $block['blockName'];
	$block_args = $block['attrs'];
	if($block_name && $block_name != '') {
		$innerBlocks = $block['innerBlocks'];
		if( !$innerBlocks ) return array($block_name, $block_args);
		$innerArray = array();
		foreach ($innerBlocks as $innerBlock) $innerArray[] = innerBlocks($innerBlock);
		return array($block_name, $block_args, $innerArray);
	}
	return;
}
