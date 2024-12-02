<?php
if (!defined('ABSPATH')) exit;


function slider_banner_register_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Sliders',
            'singular_name' => 'Slider',
            'add_new' => 'Add New Slider',
            'add_new_item' => 'Add New Slider',
            'edit_item' => 'Edit Slider',
            'new_item' => 'New Slider',
            'view_item' => 'View Slider',
            'search_items' => 'Search Sliders',
            'not_found' => 'No sliders found',
            'not_found_in_trash' => 'No sliders found in trash',
            'menu_name' => 'Sizh Slider ',
        ),
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title'),
    );
    register_post_type('slider_banner', $args);
}
add_action('init', 'slider_banner_register_post_type');
