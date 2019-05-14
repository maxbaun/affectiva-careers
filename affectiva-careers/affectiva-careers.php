<?php
/**
 * Affectiva Careers
 *
 * This file should only use syntax available in PHP 5.2.4 or later.
 *
 * @package      AffectivaCareers
 * @author       Max Baun
 * @copyright    2018 D3 Applications
 * @license      GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Affectiva Careers
 * Plugin URI:        https://github.com/maxbaun/affectiva-careers
 * Description:       Plugin to parse an XML feed of jobs and render to html
 * Version:           1.0.0
 * Author:            Max Baun
 * Author URI:        https://d3applications.com
 * Text Domain:       affectiva-careers
 * License:           GPL-2.0-or-later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/garyjones/...
 * Requires PHP:      7.1
 * Requires WP:       4.7
 */

require_once 'shortcodes/Jobs.php';

// var_dump(($json_string);
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( version_compare( PHP_VERSION, '7.1', '<' ) ) {
	add_action( 'plugins_loaded', 'affectiva_init_deactivation' );

	/**
	 * Initialise deactivation functions.
	 */
	function affectiva_init_deactivation() {
		if ( current_user_can( 'activate_plugins' ) ) {
			add_action( 'admin_init', 'affectiva_deactivate' );
			add_action( 'admin_notices', 'affectiva_deactivation_notice' );
		}
	}

	/**
	 * Deactivate the plugin.
	 */
	function affectiva_deactivate() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	/**
	 * Show deactivation admin notice.
	 */
	function affectiva_deactivation_notice() {
		$notice = sprintf(
			// Translators: 1: Required PHP version, 2: Current PHP version.
			'<strong>Affectiva Careers</strong> requires PHP %1$s to run. This site uses %2$s, so the plugin has been <strong>deactivated</strong>.',
			'7.1',
			PHP_VERSION
		);
		?>
		<div class="updated"><p><?php echo wp_kses_post( $notice ); ?></p></div>
		<?php
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}

	return false;
}
