jQuery(document).ready(function($) {
    // Open the WordPress media uploader when the 'Upload Image' button is clicked
    $(document).on('click', '.upload-image', function(e) {
        e.preventDefault();

        var button = $(this);
        var sectionId = button.closest('.slider-banner-item').attr('data-section-id'); // Get section ID

        var custom_uploader = wp.media({
            title: 'Select or Upload Image',
            button: {
                text: 'Use this image'
            },
            multiple: false // Only allow one image to be selected
        })
        .on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            button.siblings('.image-url').val(attachment.url); // Store the image URL in the hidden input field
            button.siblings('.preview-image').attr('src', attachment.url).show(); // Show the image preview
        })
        .open();
    });

    $(document).on('click', '#remove-banner, #remove-banner-icon', function(e) {
        e.preventDefault();
        $(this).closest('.slider-banner-item').remove();
    });

    // Add new banner item dynamically
    $('#add-banner').on('click', function(e) {
        e.preventDefault();

        var newIndex = $('#slider-banner-container .slider-banner-item').length;
        var newBannerHTML = `
            <div class="slider-banner-item" data-section-id="${newIndex}" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; background-color: #f9f9f9; position: relative; border-radius: 8px;">
                <label>Title:</label>
                <input type="text" name="slider_banners[${newIndex}][title]" class="widefat" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 10px;">
                <label>Subtitle:</label>
                <textarea name="slider_banners[${newIndex}][content]" class="widefat" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 10px;"></textarea>
                <label>Button Text:</label>
                <input type="text" name="slider_banners[${newIndex}][button_text]" class="widefat" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 10px;">
                <label>Button URL:</label>
                <input type="text" name="slider_banners[${newIndex}][button_url]" class="widefat" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 10px;">
             <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                    <label style="font-weight: bold;">Banner Image:</label>
                    <input type="hidden" name="slider_banners[${newIndex}][image_url]" class="image-url">
                    <button type="button" class="upload-image button" 
                            style="font-size: 10px; background-color: #0073aa; color: #fff; border: none; 
                                padding: 2px 15px; border-radius: 4px; cursor: pointer;">Upload Image</button>
                    <img class="preview-image" 
                        style="max-width: 15%; height: auto; display: none; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <button type="button" id="remove-banner-icon" class="remove-banner-icon" style="position: absolute; top: 10px; right: 10px; display: flex; align-items: center; color: #e63946; border: none; background: transparent; cursor: pointer;">
                    <i class="dashicons dashicons-trash" style="font-size: 20px; color: #e74c3c;"></i>
                </button>
            </div>
        `;
        $('#slider-banner-container').append(newBannerHTML); // Append the new banner item
    });
});
