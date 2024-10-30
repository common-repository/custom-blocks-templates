<?php

namespace Sirvelia\CBT;

add_action( 'init', __NAMESPACE__ . '\register_cpt' );

/**
 * Registers the custom post types
 *
 * @since    1.0.0
 */

function register_cpt() {
	$labels = array(
        'name'                  => _x( 'Blocks Templates', 'Post type general name', 'custom-blocks-templates' ),
        'singular_name'         => _x( 'Blocks Template', 'Post type singular name', 'custom-blocks-templates' ),
        'menu_name'             => _x( 'Blocks Templates', 'Admin Menu text', 'custom-blocks-templates' ),
        'name_admin_bar'        => _x( 'Blocks Template', 'Add New on Toolbar', 'custom-blocks-templates' ),
        'add_new'               => __( 'Create Template', 'custom-blocks-templates' ),
        'add_new_item'          => __( 'New Blocks Template', 'custom-blocks-templates' ),
        'new_item'              => __( 'New Blocks Template', 'custom-blocks-templates' ),
        'edit_item'             => __( 'Edit Blocks Template', 'custom-blocks-templates' ),
        'view_item'             => __( 'View Blocks Template', 'custom-blocks-templates' ),
        'all_items'             => __( 'Blocks Templates', 'custom-blocks-templates' ),
        'search_items'          => __( 'Search Blocks Templates', 'custom-blocks-templates' ),
        'parent_item_colon'     => __( 'Parent Blocks Templates:', 'custom-blocks-templates' ),
        'not_found'             => __( 'No Blocks Templates found.', 'custom-blocks-templates' ),
        'not_found_in_trash'    => __( 'No Blocks Templates found in Trash.', 'custom-blocks-templates' ),
        'featured_image'        => _x( 'Blocks Template Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'custom-blocks-templates' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'custom-blocks-templates' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'custom-blocks-templates' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'custom-blocks-templates' ),
        'archives'              => _x( 'Blocks Template archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'custom-blocks-templates' ),
        'insert_into_item'      => _x( 'Insert into Blocks Template', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'custom-blocks-templates' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Blocks Template', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'custom-blocks-templates' ),
        'filter_items_list'     => _x( 'Filter Blocks Templates list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'custom-blocks-templates' ),
        'items_list_navigation' => _x( 'Blocks Templates list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'custom-blocks-templates' ),
        'items_list'            => _x( 'Blocks Templates list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'custom-blocks-templates' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
				'menu_icon' => 'data:image/svg+xml;base64,' . base64_encode('<svg
      xmlns="http://www.w3.org/2000/svg"
      width="20"
      height="20"
      x="0"
      y="0"
      enableBackground="new 0 0 100 100"
      viewBox="0 0 100 100"
    >
      <path fill="#a0a5aa" d="M5.2 66.6L48.9 90.2 48.9 62.4 5.2 38.7z"></path>
      <path fill="#a0a5aa" d="M51.5 62.4L51.5 90.2 95.2 66.6 95.2 38.7z"></path>
      <path fill="#a0a5aa" d="M85.2 31.9c.4-.7.6-1.4.6-2.2 0-3.8-5.3-6.8-11.8-6.8-2.3 0-4.5.4-6.4 1.1l-6.1-2.8c.2-.5.3-1 .3-1.5 0-3.8-5.3-6.8-11.8-6.8s-11.8 3-11.8 6.8c0 .5.1 1 .3 1.5l-5.9 2.5c-1.7-.5-3.6-.8-5.6-.8-6.5 0-11.8 3-11.8 6.8 0 .5.1.9.2 1.4l-10 4.3L50 59.8l44.8-23.5-9.6-4.4zM39.8 23c2 2 5.9 3.4 10.2 3.4 4.4 0 8.2-1.4 10.2-3.4 1 1 1.6 2.2 1.6 3.4 0 3.8-5.3 6.8-11.8 6.8-6.5 0-11.8-3.1-11.8-6.8.1-1.2.6-2.4 1.6-3.4zM27 43.2c-6.5 0-11.8-3.1-11.8-6.8 0-1.2.6-2.3 1.5-3.3 2 2.1 5.9 3.4 10.3 3.4s8.2-1.4 10.3-3.4c1 1 1.6 2.2 1.6 3.4 0 3.7-5.3 6.7-11.9 6.7zm23 12c-6.5 0-11.8-3.1-11.8-6.8 0-1.3.6-2.5 1.8-3.5 2 2.1 5.9 3.6 10.4 3.6 4.2 0 8-1.3 10-3.2.9 1 1.4 2.1 1.4 3.3 0 3.6-5.3 6.7-11.8 6.6zm24-11.9c-6.5 0-11.8-3.1-11.8-6.8 0-1.2.6-2.4 1.6-3.4 2.1 2 5.8 3.4 10.2 3.4 4.3 0 8.1-1.3 10.2-3.3 1 1 1.6 2.2 1.6 3.5 0 3.6-5.3 6.7-11.8 6.6z"></path>
    </svg>'),
				'show_in_rest' => true,
        'supports'           => array( 'title', 'editor' ),
    );

    register_post_type( 'block-template', $args );
}
