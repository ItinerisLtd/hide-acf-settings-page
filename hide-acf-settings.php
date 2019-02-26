<?php
/**
 * Plugin Name:     Hide ACF Settings Page
 * Plugin URI:      https://github.com/itinerisltd/hide-acf-settings-page
 * Description:     Hide ACF settings page on non-development enviroments.
 * Version:         0.1.0
 * Author:          Itineris Limited
 * Author URI:      https://www.itineris.co.uk/
 * Text Domain:     hide-acf-settings-page
 */

declare(strict_types=1);

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

add_filter('acf/settings/show_admin', function (bool $shouldShowAdmin): bool {
    return $shouldShowAdmin && 'development' === WP_ENV;
});
