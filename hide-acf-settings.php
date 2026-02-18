<?php
/**
 * Plugin Name:     Hide ACF Settings Page
 * Plugin URI:      https://github.com/itinerisltd/hide-acf-settings-page
 * Description:     Hide ACF settings page on non-development enviroments.
 * Version:         0.3.0
 * Author:          Itineris Limited
 * Author URI:      https://www.itineris.co.uk/
 * Text Domain:     hide-acf-settings-page
 */

declare(strict_types=1);

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Determine if ACF admin should be hidden based on environment type.
 *
 * This filter hides the ACF admin interface on production and staging environments
 * while showing it on development and local environments.
 *
 * For backwards compatibility with Vanilla WordPress installations (where WP_ENVIRONMENT_TYPE
 * is not defined), the plugin falls back to checking the legacy WP_ENV constant. If neither
 * is defined, ACF admin is hidden by default for security.
 *
 * @param bool $shouldShowAdmin Whether ACF admin should be shown.
 *
 * @return bool Whether ACF admin should be shown based on environment.
 */
add_filter('acf/settings/show_admin', function (bool $shouldShowAdmin): bool {
    // If already set to false by another filter, respect that.
    if (! $shouldShowAdmin) {
        return false;
    }

    // WordPress 5.5+ with WP_ENVIRONMENT_TYPE constant.
    if (function_exists('wp_get_environment_type')) {
        $environmentType = wp_get_environment_type();
        return in_array($environmentType, ['development', 'local'], true);
    }

    // Bedrock-style WP_ENV constant (legacy support).
    if (defined('WP_ENV')) {
        return 'development' === WP_ENV;
    }

    // Vanilla WordPress without environment configuration - hide by default for security.
    return false;
});
