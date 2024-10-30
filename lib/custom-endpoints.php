<?php

namespace Sirvelia\CBT;

/**
 * List of registered custom taxonomies
 *
 * @since 1.2.0
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest,  * or null if none.
 */
function get_taxonomy_list( $data ) {
	$args = array(
  'public'   => true,
  '_builtin' => false
	);
	$output = 'objects';
	$operator = 'and';
	$taxonomies = get_taxonomies( $args, $output, $operator );

  if ( empty( $taxonomies ) ) {
    return 'HOLA';
  }

  return $taxonomies;
}

/**
 * List of registered custom taxonomies
 *
 * @since 1.2.0
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest,  * or null if none.
 */
function get_roles( $data ) {
	// if (!function_exists('get_editable_roles')) {
  //  require_once(ABSPATH . '/wp-admin/includes/user.php');
	// }
	// $editable_roles = get_editable_roles();
	// foreach ($editable_roles as $role => $details) {
	// 	$sub['role'] = esc_attr($role);
	// 	$sub['name'] = translate_user_role($details['name']);
	// 	$roles[] = $sub;
	// }
	// return $roles;


	global $wp_roles;

		$roles      = array();
		$user_roles = $wp_roles->roles;

		foreach ( $user_roles as $key => $role ) {
			$roles[] = array(
				'value' => esc_attr($key),
				'label' => translate_user_role($role['name']),
			);
		}

		return $roles;
}

/**
 * Adds API endpoints
 *
 * @since 1.2.0
 *
 */
add_action( 'rest_api_init', function () {

  register_rest_route( 'custom-blocks-templates/v1', 'taxonomies', array(
    'methods' => 'GET',
    'callback' => __NAMESPACE__ . '\get_taxonomy_list',
		'permission_callback' => function () {
			return current_user_can( 'edit_posts' );
		},
  ) );

	register_rest_route( 'custom-blocks-templates/v1', 'roles', array(
    'methods' => 'GET',
    'callback' => __NAMESPACE__ . '\get_roles',
		'permission_callback' => function () {
			return current_user_can( 'edit_posts' );
		},
  ) );

} );
