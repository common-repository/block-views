<?php

/**
 * Plugin Name: Block Views
 * Description: As a "Post View" and "Post Meta" block for creating custom post loops.
 * Version: 1.0.0
 */

// Require PHP v5.6+
if (version_compare(PHP_VERSION, '5.6', '<')) {
    return include plugin_dir_path(__FILE__) . 'php_version_notice.php';
}

require_once plugin_dir_path( __FILE__ ) . 'blocks/src/init.php';
require_once plugin_dir_path( __FILE__ ) . 'shortcodes/init.php';
