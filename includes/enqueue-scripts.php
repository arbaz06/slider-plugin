<?php
if (!defined('ABSPATH')) exit;

function slider_banner_enqueue_scripts($hook_suffix) {
    wp_enqueue_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_style('slider-banner-custom-css', SIZH_PLUGIN_URL . 'assets/custom.css', array(), null, 'all');
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);

    if ('post.php' === $hook_suffix || 'post-new.php' === $hook_suffix) {
        wp_enqueue_media();
        wp_enqueue_script('slider-banner-admin', SIZH_PLUGIN_URL . 'assets/admin.js', array('jquery'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'slider_banner_enqueue_scripts');
add_action('admin_enqueue_scripts', 'slider_banner_enqueue_scripts');
