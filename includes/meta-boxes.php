<?php
if (!defined('ABSPATH')) exit;

// Add Meta Box for Sliders
function slider_banner_add_meta_box() {
    add_meta_box('slider_banners_meta', 'Add Banners', 'slider_banner_meta_box_callback', 'slider_banner', 'normal', 'default');
    add_meta_box('slider_banners_settings', 'Slider Items Style Settings', 'slider_banner_global_settings_callback', 'slider_banner', 'side');
}
add_action('add_meta_boxes', 'slider_banner_add_meta_box');

// Callback for Banners Meta Box
function slider_banner_meta_box_callback($post) {
    $banners = get_post_meta($post->ID, '_slider_banners', true);
    wp_nonce_field('save_slider_banners', 'slider_banners_nonce');
    ?>
    <div id="slider-banner-container" style="margin-top: 20px;">
        <?php if (!empty($banners)) : ?>
            <?php foreach ($banners as $index => $banner) : ?>
     
                <div class="slider-banner-item" style="margin-bottom: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
                    <label style="font-weight: bold; margin-bottom: 5px;">Title:</label>
                    <input type="text" name="slider_banners[<?php echo $index; ?>][title]" 
                           value="<?php echo isset($banner['title']) ? esc_attr($banner['title']) : ''; ?>" 
                           class="widefat" style="padding: 10px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc;">

                    <label style="font-weight: bold; margin-bottom: 5px;">Subtitle:</label>
                    <textarea name="slider_banners[<?php echo $index; ?>][content]" class="widefat" style="padding: 10px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc;"><?php echo isset($banner['content']) ? esc_html($banner['content']) : ''; ?></textarea>

                    <label style="font-weight: bold; margin-bottom: 5px;">Button Text:</label>
                    <input type="text" name="slider_banners[<?php echo $index; ?>][button_text]" 
                           value="<?php echo isset($banner['button_text']) ? esc_attr($banner['button_text']) : ''; ?>" 
                           class="widefat" style="padding: 10px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc;">

                    <label style="font-weight: bold; margin-bottom: 5px;">Button URL:</label>
                    <input type="text" name="slider_banners[<?php echo $index; ?>][button_url]" 
                           value="<?php echo isset($banner['button_url']) ? esc_url($banner['button_url']) : ''; ?>" 
                           class="widefat" style="padding: 10px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc;">

                           <div class="banner-image-container" style="display: flex; align-items: center; margin-bottom: 10px;">
                        <label style="font-weight: bold; margin-right: 10px;">Banner Image:</label>
                        <input type="hidden" name="slider_banners[<?php echo $index; ?>][image_url]" 
                            class="image-url" 
                            value="<?php echo isset($banner['image_url']) ? esc_url($banner['image_url']) : ''; ?>">

                        <img src="<?php echo isset($banner['image_url']) ? esc_url($banner['image_url']) : ''; ?>" 
                            class="preview-image" 
                            style="max-width: 15%; height: auto; display: <?php echo isset($banner['image_url']) ? 'block' : 'none'; ?>;">

                            <button type="button" class="upload-image button" 
                            style="font-size:10px; background-color: #0073aa; color: white; padding: 2px 15px; border-radius: 4px; cursor: pointer; margin-left: 24px;">Update Image</button>
                    </div>

                    <button type="button" id="remove-banner" class="remove-banner button button-link-delete" style="margin-top: 20px; display: flex; align-items: center; color: #e63946; border: none; background: transparent;"> <i class="dashicons dashicons-trash" style="font-size: 20px; color: #e74c3c;"></i></button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <button type="button" id="add-banner" class="button button-primary" style="margin-top: 20px; background-color: #28a745; color: white; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Add slider</button>
    <?php
}



// Callback for Global Settings Meta Box
function slider_banner_global_settings_callback($post) {
    $global_title_color = get_post_meta($post->ID, '_slider_global_title_color', true) ?: '#000000';
    $global_title_font_size = get_post_meta($post->ID, '_slider_global_title_font_size', true) ?: '24px';
    $global_title_tag = get_post_meta($post->ID, '_slider_global_title_tag', true) ?: 'h3';
    $global_content_color = get_post_meta($post->ID, '_slider_global_content_color', true) ?: '#333333';
    $global_content_font_size = get_post_meta($post->ID, '_slider_global_content_font_size', true) ?: '16px';
    $global_button_color = get_post_meta($post->ID, '_slider_global_button_color', true) ?: '#007bff';
    $global_button_hover_color = get_post_meta($post->ID, '_slider_global_button_hover_color', true) ?: '#0056b3';
    $global_button_text_color = get_post_meta($post->ID, '_slider_global_button_text_color', true) ?: '#ffffff';
    $global_alignment = get_post_meta($post->ID, '_slider_global_alignment', true) ?: 'middle-center'; 
    $global_image_height = get_post_meta($post->ID, '_slider_global_image_height', true) ?: '500px'; 
    $global_class = get_post_meta($post->ID, '_slider_global_class', true); // Default class
    $global_nav_type = get_post_meta($post->ID, '_slider_global_nav_type', true) ?: 'arrow'; // Default to 'arrow'
    ?>
    <h1 style="font-size: 16px;">Title style</h1>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Text Color:</label>
        <input type="color" name="slider_global_title_color" value="<?php echo esc_attr($global_title_color); ?>" class="widefat" style="width: 18%; border: none; border-radius: 50%; padding: 0; height: 41px;">
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Font Size:</label>
        <input type="number" name="slider_global_title_font_size" value="<?php echo esc_attr($global_title_font_size); ?>" class="widefat" style="width: 45%;"> /px
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Text Tag:</label>
        <select name="slider_global_title_tag" class="widefat" style="width: 50%;">
            <?php foreach (array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p') as $tag) : ?>
                <option value="<?php echo $tag; ?>" <?php selected($global_title_tag, $tag); ?>><?php echo strtoupper($tag); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <h1 style="font-size: 16px;">Subtitle style</h1>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Text Color:</label>
        <input type="color" name="slider_global_content_color" value="<?php echo esc_attr($global_content_color); ?>" class="widefat" style="width: 18%; border: none; border-radius: 50%; padding: 0; height: 41px;">
    </div>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Font Size:</label>
        <input type="number" name="slider_global_content_font_size" value="<?php echo esc_attr($global_content_font_size); ?>" class="widefat" style="width: 45%;"> /px
    </div>

    <h1 style="font-size: 16px;">Button style</h1>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Background Color:</label>
        <input type="color" name="slider_global_button_color" value="<?php echo esc_attr($global_button_color); ?>" class="widefat" style="width: 18%; border: none; border-radius: 50%; padding: 0; height: 41px;">
    </div>
    <!-- <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Button Hover Color:</label>
        <input type="color" name="slider_global_button_hover_color" value="<?php echo esc_attr($global_button_hover_color); ?>" class="widefat" style="width: 18%; border: none; border-radius: 50%; padding: 0; height: 41px;">
    </div> -->
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Text Color:</label>
        <input type="color" name="slider_global_button_text_color" value="<?php echo esc_attr($global_button_text_color); ?>" class="widefat" style="width: 18%; border: none; border-radius: 50%; padding: 0; height: 41px;">
    </div>

    <h1 style="font-size: 16px;">Item Alignment Style</h1>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Alignment:</label>
        <select name="slider_global_alignment" class="widefat" style="width: 50%;">
            <option value="middle-center" <?php selected($global_alignment, 'middle-center'); ?>> Center</option>
            <option value="middle-left" <?php selected($global_alignment, 'middle-left'); ?>> Left</option>
            <option value="middle-right" <?php selected($global_alignment, 'middle-right'); ?>> Right</option>
        </select>
    </div>

    <h1 style="font-size: 16px;">Image Settings</h1>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Image Height (e.g., 500px or 100%):</label>
        <input type="text" name="slider_global_image_height" value="<?php echo esc_attr($global_image_height); ?>" class="widefat" style="width: 50%;">
    </div>

    <h1 style="font-size: 16px;">Slider Settings</h1>
    <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <label style="width: 150px;">Class:</label>
        <input type="text" name="slider_global_class" value="<?php echo esc_attr($global_class); ?>" class="widefat" style="width: 50%;" placeholder="Enter additional classes">
    </div>

    <h1 style="font-size: 16px;">Slider Navigation Settings</h1>
    <div style="margin-bottom: 10px;">
        <label>Navigation Type:</label><br>
        <input type="radio" name="slider_global_nav_type" value="arrow" <?php checked($global_nav_type, 'arrow'); ?> /> Arrow
        <input type="radio" name="slider_global_nav_type" value="dot" <?php checked($global_nav_type, 'dot'); ?> /> Dot
    </div>
    <br><br>
<?php
}

// Save Meta Box Data

function slider_banner_save_meta_box($post_id) {
    if (!isset($_POST['slider_banners_nonce']) || !wp_verify_nonce($_POST['slider_banners_nonce'], 'save_slider_banners')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    update_post_meta($post_id, '_slider_banners', $_POST['slider_banners'] ?? []);
    update_post_meta($post_id, '_slider_global_title_color', sanitize_hex_color($_POST['slider_global_title_color'] ?? ''));
    update_post_meta($post_id, '_slider_global_title_font_size', sanitize_text_field($_POST['slider_global_title_font_size'] ?? ''));
    update_post_meta($post_id, '_slider_global_title_tag', sanitize_text_field($_POST['slider_global_title_tag'] ?? ''));
    update_post_meta($post_id, '_slider_global_content_color', sanitize_hex_color($_POST['slider_global_content_color'] ?? ''));
    update_post_meta($post_id, '_slider_global_content_font_size', sanitize_text_field($_POST['slider_global_content_font_size'] ?? ''));
    update_post_meta($post_id, '_slider_global_button_color', sanitize_hex_color($_POST['slider_global_button_color'] ?? ''));
    update_post_meta($post_id, '_slider_global_button_hover_color', sanitize_hex_color($_POST['slider_global_button_hover_color'] ?? ''));
    update_post_meta($post_id, '_slider_global_button_text_color', sanitize_hex_color($_POST['slider_global_button_text_color'] ?? ''));
    // Save alignment
    update_post_meta($post_id, '_slider_global_alignment', sanitize_text_field($_POST['slider_global_alignment'] ?? 'middle-center'));
    update_post_meta($post_id, '_slider_global_image_height', sanitize_text_field($_POST['slider_global_image_height'] ?? ''));
    update_post_meta($post_id, '_slider_global_class', sanitize_text_field($_POST['slider_global_class'] ?? 'carousel slide'));
    update_post_meta($post_id, '_slider_global_nav_type', sanitize_text_field($_POST['slider_global_nav_type'] ?? 'arrow'));
}
add_action('save_post', 'slider_banner_save_meta_box');


// Shortcode for Slider

function slider_banner_shortcode($atts) {
    $atts = shortcode_atts(array('id' => ''), $atts, 'slider_banner');
    $post_id = $atts['id'];

    if (empty($post_id)) return 'Invalid Slider ID.';

    $banners = get_post_meta($post_id, '_slider_banners', true);
    if (empty($banners)) return 'No banners found.';

    $global_title_color = get_post_meta($post_id, '_slider_global_title_color', true);
    $global_title_font_size = get_post_meta($post_id, '_slider_global_title_font_size', true);
    $global_title_tag = get_post_meta($post_id, '_slider_global_title_tag', true);
    $global_content_color = get_post_meta($post_id, '_slider_global_content_color', true);
    $global_content_font_size = get_post_meta($post_id, '_slider_global_content_font_size', true);
    $global_button_color = get_post_meta($post_id, '_slider_global_button_color', true);
    $global_button_text_color = get_post_meta($post_id, '_slider_global_button_text_color', true);
    $global_alignment = get_post_meta($post_id, '_slider_global_alignment', true); // Get alignment setting
    $global_image_height = get_post_meta($post_id, '_slider_global_image_height', true);
    $global_class = get_post_meta($post_id, '_slider_global_class', true); // Default class
    $global_nav_type = get_post_meta($post_id, '_slider_global_nav_type', true); // Get navigation type (arrow or dot)

    ob_start();
    ?>
    <div id="slider-<?php echo esc_attr($post_id); ?>" class="carousel slide <?php echo esc_attr($global_class); ?>" data-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($banners as $index => $banner) : ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                   <img src="<?php echo esc_url($banner['image_url']); ?>" class="d-block w-100" alt="" style="height: <?php echo esc_attr($global_image_height); ?>;">
                    <div class="carousel-caption <?php echo esc_attr($global_alignment); ?>"> <!-- Apply alignment class -->
                        <<?php echo esc_attr($global_title_tag); ?> style="color: <?php echo esc_attr($global_title_color); ?>; font-size: <?php echo esc_attr($global_title_font_size); ?>px;">
                            <?php echo esc_html($banner['title']); ?>
                        </<?php echo esc_attr($global_title_tag); ?>>
                        <p style="color: <?php echo esc_attr($global_content_color); ?>; font-size: <?php echo esc_attr($global_content_font_size); ?>px;">
                            <?php echo esc_html($banner['content']); ?>
                        </p>
                        <?php if (!empty($banner['button_text'])) : ?> <!-- Check if button text is not empty -->
                        <a href="<?php echo esc_url($banner['button_url']); ?>" 
                           class="btn btn-primary" 
                           style="background-color: <?php echo esc_attr($global_button_color); ?>; color: <?php echo esc_attr($global_button_text_color); ?>;">
                            <?php echo esc_html($banner['button_text']); ?>
                        </a>
                    <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Navigation based on the saved setting (Arrow or Dot) -->
        <?php if ($global_nav_type === 'arrow') : ?>
            <a class="carousel-control-prev" href="#slider-<?php echo esc_attr($post_id); ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#slider-<?php echo esc_attr($post_id); ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        <?php elseif ($global_nav_type === 'dot') : ?>
            <ol class="carousel-indicators">
                <?php foreach ($banners as $index => $banner) : ?>
                    <li data-target="#slider-<?php echo esc_attr($post_id); ?>" data-slide-to="<?php echo esc_attr($index); ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>"></li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>

    
    <?php
    return ob_get_clean();
}
add_shortcode('slider_banner', 'slider_banner_shortcode');


