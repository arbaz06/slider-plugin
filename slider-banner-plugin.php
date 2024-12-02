<?php
/*
Plugin Name: Sizh Slider Banner
Description: A dynamic slider banner plugin with multiple banners per slider and unique shortcodes.
Version: 1.5
Author: Sizh Team's
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Define constants for plugin paths
define('SIZH_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SIZH_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once SIZH_PLUGIN_PATH . 'includes/enqueue-scripts.php';
require_once SIZH_PLUGIN_PATH . 'includes/custom-post-type.php';
require_once SIZH_PLUGIN_PATH . 'includes/meta-boxes.php';
require_once SIZH_PLUGIN_PATH . 'includes/shortcodes.php';