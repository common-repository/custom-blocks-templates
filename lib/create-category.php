<?php

namespace Sirvelia\CBT;

add_filter( 'block_categories', __NAMESPACE__ . '\create_sirvelia_blocks_category', 10, 2);

/**
 * Create CBT Blocks category
 *
 * @since    1.0.0
 */
function create_sirvelia_blocks_category( $categories ) {
	$category_slugs = wp_list_pluck( $categories, 'slug' );
  return in_array( 'custom-blocks-templates', $category_slugs, true ) ? $categories : array_merge(
    $categories,
    array(
        array(
            'slug'  => 'custom-blocks-templates',
            'title' => __( 'CBT Blocks', 'custom-blocks-templates' ),
            'icon'  => null,
        ),
    )
	);
}
