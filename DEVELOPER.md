# Developer Guide - OG Preview Plugin

## For Plugin Developers

This guide is for developers who want to extend or integrate with the OG Preview plugin.

## Available Hooks

### Filters

#### `og_preview_tags`

Modify the OG tags before they are displayed in the preview.

**Parameters:**
- `$og_tags` (array) - Array of OG tag data
- `$post_id` (int) - The post ID

**Example:**

```php
add_filter('og_preview_tags', function($og_tags, $post_id) {
    // Add custom OG tag
    $og_tags['custom_field'] = get_post_meta($post_id, '_my_custom_field', true);
    
    // Override title
    if (has_term('featured', 'category', $post_id)) {
        $og_tags['title'] = '⭐ ' . $og_tags['title'];
    }
    
    // Modify description
    $og_tags['description'] = strtoupper($og_tags['description']);
    
    // Change image based on post type
    if (get_post_type($post_id) === 'product') {
        $og_tags['image'] = get_the_post_thumbnail_url($post_id, 'product-large');
    }
    
    return $og_tags;
}, 10, 2);
```

## Custom Meta Fields

### Adding Custom OG Fields

The plugin supports custom OG meta fields. You can set these via code:

```php
// Set custom OG title
update_post_meta($post_id, '_og_preview_title', 'My Custom Title');

// Set custom OG description
update_post_meta($post_id, '_og_preview_description', 'My custom description');

// Set custom OG image
update_post_meta($post_id, '_og_preview_image', 'https://example.com/image.jpg');
```

### Adding Meta Boxes for Custom Fields

```php
add_action('add_meta_boxes', function() {
    add_meta_box(
        'custom-og-fields',
        'Custom OG Tags',
        'render_custom_og_metabox',
        'post',
        'normal',
        'high'
    );
});

function render_custom_og_metabox($post) {
    wp_nonce_field('custom_og_nonce', 'custom_og_nonce');
    
    $title = get_post_meta($post->ID, '_og_preview_title', true);
    $description = get_post_meta($post->ID, '_og_preview_description', true);
    $image = get_post_meta($post->ID, '_og_preview_image', true);
    
    ?>
    <p>
        <label>OG Title:</label><br>
        <input type="text" name="og_preview_title" value="<?php echo esc_attr($title); ?>" style="width:100%">
    </p>
    <p>
        <label>OG Description:</label><br>
        <textarea name="og_preview_description" style="width:100%" rows="3"><?php echo esc_textarea($description); ?></textarea>
    </p>
    <p>
        <label>OG Image URL:</label><br>
        <input type="text" name="og_preview_image" value="<?php echo esc_attr($image); ?>" style="width:100%">
    </p>
    <?php
}

add_action('save_post', function($post_id) {
    if (!isset($_POST['custom_og_nonce']) || !wp_verify_nonce($_POST['custom_og_nonce'], 'custom_og_nonce')) {
        return;
    }
    
    if (isset($_POST['og_preview_title'])) {
        update_post_meta($post_id, '_og_preview_title', sanitize_text_field($_POST['og_preview_title']));
    }
    
    if (isset($_POST['og_preview_description'])) {
        update_post_meta($post_id, '_og_preview_description', sanitize_textarea_field($_POST['og_preview_description']));
    }
    
    if (isset($_POST['og_preview_image'])) {
        update_post_meta($post_id, '_og_preview_image', esc_url_raw($_POST['og_preview_image']));
    }
});
```

## Integration with Other Plugins

### Custom SEO Plugin Integration

If you have a custom SEO plugin, you can integrate it with OG Preview:

```php
add_filter('og_preview_tags', function($og_tags, $post_id) {
    // Get data from your SEO plugin
    $custom_seo_data = YourSEOPlugin::get_meta($post_id);
    
    if (!empty($custom_seo_data['og_title'])) {
        $og_tags['title'] = $custom_seo_data['og_title'];
    }
    
    if (!empty($custom_seo_data['og_description'])) {
        $og_tags['description'] = $custom_seo_data['og_description'];
    }
    
    if (!empty($custom_seo_data['og_image'])) {
        $og_tags['image'] = $custom_seo_data['og_image'];
    }
    
    return $og_tags;
}, 5, 2); // Priority 5 to run before default priority 10
```

### WooCommerce Integration Example

```php
add_filter('og_preview_tags', function($og_tags, $post_id) {
    if (get_post_type($post_id) !== 'product') {
        return $og_tags;
    }
    
    $product = wc_get_product($post_id);
    
    if (!$product) {
        return $og_tags;
    }
    
    // Use product short description
    $og_tags['description'] = $product->get_short_description();
    
    // Add price to title
    $og_tags['title'] = $product->get_name() . ' - ' . $product->get_price_html();
    
    // Use product gallery first image if available
    $gallery_ids = $product->get_gallery_image_ids();
    if (!empty($gallery_ids)) {
        $og_tags['image'] = wp_get_attachment_url($gallery_ids[0]);
    }
    
    // Set type to product
    $og_tags['type'] = 'product';
    
    return $og_tags;
}, 10, 2);
```

## Extending Preview Platforms

### Adding a New Platform

To add support for a new social platform:

1. **Add to Settings**

```php
add_filter('og_preview_available_platforms', function($platforms) {
    $platforms['pinterest'] = 'Pinterest';
    return $platforms;
});
```

2. **Create Preview Template**

```php
add_filter('og_preview_render_platform', function($html, $platform, $og_tags) {
    if ($platform !== 'pinterest') {
        return $html;
    }
    
    ob_start();
    ?>
    <div class="og-preview-card og-preview-pinterest">
        <?php if (!empty($og_tags['image'])): ?>
            <div class="og-preview-image">
                <img src="<?php echo esc_url($og_tags['image']); ?>" alt="">
            </div>
        <?php endif; ?>
        <div class="og-preview-details">
            <div class="og-preview-title"><?php echo esc_html($og_tags['title']); ?></div>
            <div class="og-preview-domain"><?php echo esc_html(parse_url($og_tags['url'], PHP_URL_HOST)); ?></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}, 10, 3);
```

3. **Add Styles**

```php
add_action('admin_enqueue_scripts', function() {
    wp_add_inline_style('og-preview-admin', '
        .og-preview-pinterest .og-preview-image {
            border-radius: 16px;
            overflow: hidden;
        }
        .og-preview-pinterest .og-preview-title {
            font-weight: 600;
            font-size: 14px;
        }
    ');
});
```

## JavaScript API

### Programmatically Refresh Preview

```javascript
// Trigger preview refresh
jQuery(document).trigger('og-preview-refresh');

// Listen for preview updates
jQuery(document).on('og-preview-updated', function(event, data) {
    console.log('Preview updated', data);
});
```

### Custom AJAX Handler

```javascript
// Add custom data to AJAX request
jQuery(document).on('og-preview-ajax-data', function(event, data) {
    data.custom_field = jQuery('#my-custom-field').val();
});
```

## CSS Customization

### Override Styles

```php
add_action('admin_enqueue_scripts', function() {
    wp_add_inline_style('og-preview-admin', '
        .og-preview-facebook .og-preview-title {
            color: #1877f2;
            font-size: 18px;
        }
        
        .og-preview-card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    ');
});
```

## REST API Integration

### Create Custom Endpoint

```php
add_action('rest_api_init', function() {
    register_rest_route('og-preview/v1', '/preview/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function($request) {
            $post_id = $request['id'];
            $core = new OG_Preview_Core();
            $og_tags = $core->get_og_tags($post_id);
            
            return rest_ensure_response($og_tags);
        },
        'permission_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
});
```

**Usage:**
```javascript
fetch('/wp-json/og-preview/v1/preview/123')
    .then(response => response.json())
    .then(data => console.log(data));
```

## Testing

### Unit Test Example

```php
class OG_Preview_Test extends WP_UnitTestCase {
    
    public function test_get_og_tags() {
        $post_id = $this->factory->post->create(array(
            'post_title' => 'Test Post',
            'post_content' => 'Test content',
            'post_excerpt' => 'Test excerpt'
        ));
        
        $core = new OG_Preview_Core();
        $og_tags = $core->get_og_tags($post_id);
        
        $this->assertEquals('Test Post', $og_tags['title']);
        $this->assertContains('Test excerpt', $og_tags['description']);
    }
    
    public function test_filter_hook() {
        add_filter('og_preview_tags', function($og_tags) {
            $og_tags['title'] = 'Modified';
            return $og_tags;
        });
        
        $post_id = $this->factory->post->create();
        $core = new OG_Preview_Core();
        $og_tags = $core->get_og_tags($post_id);
        
        $this->assertEquals('Modified', $og_tags['title']);
    }
}
```

## Performance Optimization

### Cache OG Tags

```php
add_filter('og_preview_tags', function($og_tags, $post_id) {
    // Cache OG tags for 1 hour
    $cache_key = 'og_tags_' . $post_id;
    $cached = get_transient($cache_key);
    
    if ($cached !== false) {
        return $cached;
    }
    
    // Your expensive operations here
    
    set_transient($cache_key, $og_tags, HOUR_IN_SECONDS);
    
    return $og_tags;
}, 10, 2);

// Clear cache on post update
add_action('save_post', function($post_id) {
    delete_transient('og_tags_' . $post_id);
});
```

## Security Considerations

### Nonce Verification

The plugin uses nonces for all AJAX requests. If you're adding custom AJAX handlers:

```php
add_action('wp_ajax_my_custom_preview', function() {
    check_ajax_referer('og_preview_nonce', 'nonce');
    
    // Your code here
    
    wp_send_json_success($data);
});
```

### Sanitization

Always sanitize output:

```php
echo esc_html($og_tags['title']);
echo esc_url($og_tags['image']);
echo esc_attr($platform);
```

## Debugging

### Enable Debug Mode

```php
add_filter('og_preview_debug', '__return_true');
```

Then check the browser console for debug information.

### Log OG Tags

```php
add_action('og_preview_tags', function($og_tags, $post_id) {
    error_log('OG Tags for post ' . $post_id . ': ' . print_r($og_tags, true));
    return $og_tags;
}, 10, 2);
```

## Contributing

To contribute to the plugin:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Write tests if applicable
5. Submit a pull request

## Support

For developer support:
- GitHub Issues: https://github.com/BlindTrevor/OG-Preview/issues
- Documentation: See README.md and other documentation files
