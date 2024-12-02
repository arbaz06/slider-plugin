
<?php
if (!defined('ABSPATH')) exit;


// Admin Table for Shortcodes
function slider_banner_admin_table() {
    $args = array(
        'post_type' => 'slider_banner',
        'posts_per_page' => -1,
    );
    $sliders = new WP_Query($args);

    echo '<h1>Slider Shortcodes</h1>';
    echo '<table class="widefat fixed" cellspacing="0">';
    echo '<thead><tr><th>Slider Title</th><th>Shortcode</th></tr></thead>';
    echo '<tbody>';
    while ($sliders->have_posts()) : $sliders->the_post();
        echo '<tr>';
        echo '<td>' . get_the_title() . '</td>';
        echo '<td>[slider_banner id="' . get_the_ID() . '"]</td>';
        echo '</tr>';
    endwhile;
    echo '</tbody>';
    echo '</table>';
    wp_reset_postdata();
}

// Add Admin Menu Page
function slider_banner_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=slider_banner',
        'Slider Shortcodes',
        'Shortcodes',
        'manage_options',
        'slider_shortcodes',
        'slider_banner_admin_table'
    );
}
add_action('admin_menu', 'slider_banner_admin_menu');  

// Display Shortcode in Custom Column
function slider_banner_column_content($column, $post_id) {
  
    if ($column == 'shortcode') {
       
        $shortcode = '[slider_banner id="' . $post_id . '"]';
       
        echo '<strong>Shortcode:</strong> ' . esc_html($shortcode);
    }
}
add_action('manage_slider_banner_posts_custom_column', 'slider_banner_column_content', 10, 2);


function slider_banner_columns($columns) {

    $columns['shortcode'] = 'Shortcode';
    return $columns;
}
add_filter('manage_slider_banner_posts_columns', 'slider_banner_columns');
