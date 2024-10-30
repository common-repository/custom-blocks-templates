<?php

namespace Sirvelia\CBT;

/**
 * Enqueue block editor only JavaScript and CSS.
 *
 * @since    1.0.0
 */

add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_assets' );
function enqueue_block_editor_assets() {
	$block_path = '/assets/js/editor.blocks.js';
	$style_path = '/assets/css/blocks.editor.css';

	// Enqueue the bundled block JS file
	wp_enqueue_script(
		'custom-blocks-templates-js',
		_get_plugin_url() . $block_path,
		[ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-block-editor', 'wp-primitives', 'lodash', 'jquery' ],
		filemtime( _get_plugin_directory() . $block_path )
	);

	// Enqueue optional editor only styles
	wp_enqueue_style(
		'custom-blocks-templates-editor-css',
		_get_plugin_url() . $style_path,
		[ ],
		filemtime( _get_plugin_directory() . $style_path )
	);
}

/**
 * Enqueue front end and editor JavaScript and CSS assets.
 *
 * @since    1.0.0
 */
add_action( 'enqueue_block_assets', __NAMESPACE__ . '\enqueue_assets' );
function enqueue_assets() {
	$style_path = '/assets/css/blocks.style.css';
	wp_enqueue_style(
		'custom-blocks-templates',
		_get_plugin_url() . $style_path,
		null,
		filemtime( _get_plugin_directory() . $style_path )
	);
}



/**
 * Enqueue frontend JavaScript and CSS assets.
 *
 * @since    1.0.0
 */
add_action( 'enqueue_block_assets', __NAMESPACE__ . '\enqueue_frontend_assets' );
function enqueue_frontend_assets() {

	// If in the backend, bail out.
	if ( is_admin() ) return;

	$block_path = '/assets/js/frontend.blocks.js';
	wp_enqueue_script(
		'custom-blocks-templates-frontend',
		_get_plugin_url() . $block_path,
		['jquery'],
		filemtime( _get_plugin_directory() . $block_path )
	);


	$datatables_css_path = '/external/css/datatables.min.css';
	wp_register_style(
		'datatables-css',
		_get_plugin_url() . $datatables_css_path,
		[],
		filemtime( _get_plugin_directory() . $datatables_css_path ),
		'all'
	);

	$datatables_js_path = '/external/js/datatables.min.js';
	wp_register_script(
		'datatables-js',
		_get_plugin_url() . $datatables_js_path,
		array( 'jquery' ),
		filemtime( _get_plugin_directory() . $datatables_js_path ),
		false
	);

}



/**
 * Enqueue admin scripts and styles
 *
 * @since    1.0.1
 */
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_admin_scripts' );
function enqueue_admin_scripts() {

	wp_enqueue_script( 'wp-embed' );
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );

	$admin_js_path = '/assets/js/admin.utils.js';
	wp_enqueue_script(
		'custom-blocks-templates-admin-js',
		_get_plugin_url() . $admin_js_path,
		[ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-block-editor', 'lodash', 'wp-api-fetch', 'wp-plugins', 'wp-edit-post', 'wp-data', 'wp-primitives' ],
		filemtime( _get_plugin_directory() . $admin_js_path )
	);

	$admin_css_path = '/assets/css/admin.style.css';
	wp_enqueue_style(
		'custom-blocks-templates-admin-css',
		_get_plugin_url() . $admin_css_path,
		null,
		filemtime( _get_plugin_directory() . $admin_css_path )
	);
}


/**
 * Enqueue scripts and styles
 *
 * @since    1.3
 */
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_scripts' );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_scripts' );
function enqueue_scripts() {

	/* FONT AWESOME */
	$fa_css_path = '/external/css/fa.min.css';
	wp_enqueue_style(
		'fa5-css',
		_get_plugin_url() . $fa_css_path,
		null,
		filemtime( _get_plugin_directory() . $fa_css_path )
	);

}
