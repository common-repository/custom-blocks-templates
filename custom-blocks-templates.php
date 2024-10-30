<?php
/**
 * Plugin's bootstrap file to launch the plugin.
 *
 * @package     Sirvelia\CBT
 * @author      Sirvelia
 * @license     GPL-3
 *
 * @wordpress-plugin
 * Plugin Name: Custom Blocks Templates
 * Plugin URI:  https://github.com/Sirvelia/custom-blocks-templates/
 * Description: Create and set Gutenberg blocks templates for any post type.
 * Version:     1.3.2
 * Author:      Sirvelia
 * Author URI:  https://sirvelia.com/
 * Text Domain: custom-blocks-templates
 * Domain Path: /languages
 * License:     GPL-3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Sirvelia\CBT;

//  Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Gets this plugin's absolute directory path.
 *
 * @since  1.0.0
 * @ignore
 * @access private
 *
 * @return string
 */
function _get_plugin_directory() {
	return __DIR__;
}

/**
 * Gets this plugin's URL.
 *
 * @since  1.0.0
 * @ignore
 * @access private
 *
 * @return string
 */
function _get_plugin_url() {
	static $plugin_url;

	if ( empty( $plugin_url ) ) {
		$plugin_url = plugins_url( null, __FILE__ );
	}

	return $plugin_url;
}


include __DIR__ . '/lib/custom-posts.php'; // Register custom posts
include __DIR__ . '/lib/admin-cbt-list.php'; // Modify Admin Columns and remove extra info/actions for cbt list
include __DIR__ . '/lib/admin-cbt-edit.php'; // Modify Admin Edit experience for block-template CPT
include __DIR__ . '/lib/custom-endpoints.php'; // API Endpoints
include __DIR__ . '/lib/enqueue-scripts.php'; // Enqueue JS and CSS
include __DIR__ . '/lib/create-block-category.php'; // Register Blocks Category
include __DIR__ . '/lib/template-settings.php'; // Plugin settings
include __DIR__ . '/lib/block-templates.php'; // Block Templates


/*************
BLOCK SPECIFIC PHP
*************/

include __DIR__ . '/blocks/private-block/index.php';
include __DIR__ . '/blocks/csv-tables/index.php';
include __DIR__ . '/blocks/social-share-item/index.php';
include __DIR__ . '/blocks/accordion/index.php';
//include __DIR__ . '/blocks/countdown/index.php';
