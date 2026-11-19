<?php
/**
 * Plugin Name:       Where
 * Description:       Display your WordPress site's environment type in the admin bar.
 * Version:           1.0.2
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Brad Parbs
 * Author URI:        https://bradparbs.com/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       where
 *
 * @package where
 */

namespace Where;

defined( 'ABSPATH' ) || exit;

add_action( 'init', __NAMESPACE__ . '\\init' );

/**
 * Hook everything up if the current user should see the environment type.
 */
function init() {
	if ( ! apply_filters( 'where_env_should_add_env_type', should_display() ) ) {
		return;
	}

	add_action( 'admin_bar_menu', __NAMESPACE__ . '\\add_to_admin_bar' );
	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\add_styles' );
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\add_styles' );
}

/**
 * If the admin bar isn't showing, or if the user isn't an admin, then we shouldn't display.
 *
 * @return bool True if we should display the item.
 */
function should_display() {
	return is_user_logged_in()
		&& is_admin_bar_showing()
		&& current_user_can( 'manage_options' );
}

/**
 * Grab the environment type.
 *
 * @return string The environment type.
 */
function get_env() {
	return (string) apply_filters( 'where_env_environment_type', wp_get_environment_type() );
}

/**
 * Add the environment type to the admin bar.
 *
 * @param \WP_Admin_Bar $bar The admin bar object.
 */
function add_to_admin_bar( $bar ) {
	// This is a replacement for the "Display Environment Type" plugin,
	// so we remove it to not have duplicate info.
	$bar->remove_node( 'det_env_type' );

	$bar->add_node(
		[
			'id'     => 'where',
			'parent' => 'top-secondary',
			'title'  => esc_html( ucwords( get_env() ) ),
			'meta'   => [ 'title' => esc_attr__( 'Environment Type', 'where' ) ],
		]
	);
}

/**
 * Add in the inline styles so we don't need to enqueue an entire stylesheet,
 * and we can easily change colors and all that.
 */
function add_styles() {
	wp_add_inline_style(
		'admin-bar',
		sprintf(
			'#wpadminbar li#wp-admin-bar-where {
				pointer-events: none;
				background-color: %1$s;
			}

			#wpadminbar #wp-admin-bar-top-secondary {
				position: fixed;
				right: 0
			}

			#wp-admin-bar-where .ab-item::before {
				top: 3px;
				content: "%2$s";
			}',
			get_env_style_value( 'color' ),
			get_env_style_value( 'icon' )
		)
	);
}

/**
 * Helper to check if a property of the environment styles is set, otherwise
 * return the default value if it's set.
 *
 * @param string $prop Property, e.g. 'color' or 'icon'.
 *
 * @return string The value of the property.
 */
function get_env_style_value( $prop ) {
	$styles = get_styles();
	$env    = get_env();

	if ( isset( $styles[ $env ][ $prop ] ) ) {
		return $styles[ $env ][ $prop ];
	}

	if ( isset( $styles['default'][ $prop ] ) ) {
		return $styles['default'][ $prop ];
	}

	return '';
}

/**
 * Get the styles for the admin bar.
 *
 * @return array The styles as an array.
 */
function get_styles() {
	return apply_filters(
		'where_env_styles',
		[
			'default'     => [
				'icon'  => '\f339', // dashicons-lightbulb.
				'color' => 'rgba(0, 135, 177, 0.8)',
			],
			'production'  => [
				'icon'  => '\f319', // dashicons-admin-site.
				'color' => 'rgba(185, 42, 42, 0.8)',
			],
			'staging'     => [
				'icon'  => '\f111', // dashicons-admin-generic.
				'color' => 'rgba(215, 157, 0, 0.8)',
			],
			'development' => [
				'icon'  => '\f107', // dashicons-admin-tools.
				'color' => 'rgba(59, 152, 67, 0.8)',
			],
		]
	);
}
