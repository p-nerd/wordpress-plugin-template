<?php

/**
 * Plugin Name:       WordPress Plugin Template
 * Plugin URI:        https://developershihab.com/projects/wordpress-plugin-template
 * Description:       A wordpress plugin template with latest tooling
 * Version:           1.0.0
 * Requires at least: 6.4.2
 * Requires PHP:      8.1
 * Author:            Shihab Mahamud
 * Author URI:        https://developershihab.com
 * Text Domain:       wordpress-plugin-template
 */
defined("ABSPATH") || exit();

if (file_exists(dirname(__FILE__)."/vendor/autoload.php")) {
    include_once dirname(__FILE__)."/vendor/autoload.php";
}

use Src\Life;

define("SHIHAB_PLUGIN_DIR_URL", substr(plugin_dir_url(__FILE__), 0, -1));
define("SHIHAB_PLUGIN_BASENAME", substr(plugin_basename(__FILE__), 0, -1));
define("SHIHAB_PLUGIN_DIR_PATH", substr(plugin_dir_path(__FILE__), 0, -1));

register_activation_hook(__FILE__, fn () => Life::activate());
register_deactivation_hook(__FILE__, fn () => Life::deactivate());

add_action("init", fn () => Life::register());
