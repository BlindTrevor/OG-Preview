# Installation Guide - OG Preview WordPress Plugin

## Prerequisites

- WordPress 5.0 or higher
- PHP 7.0 or higher
- Admin access to WordPress installation

## Installation Methods

### Method 1: Manual Installation (Recommended for Development)

1. **Download the Plugin**
   ```bash
   git clone https://github.com/BlindTrevor/OG-Preview.git
   ```

2. **Upload to WordPress**
   - Copy the `OG-Preview` folder to `/wp-content/plugins/` directory
   - Or rename to `og-preview` for cleaner URL structure

3. **Activate the Plugin**
   - Log in to WordPress admin panel
   - Navigate to **Plugins > Installed Plugins**
   - Find "OG Preview" in the list
   - Click "Activate"

### Method 2: ZIP Upload

1. **Create ZIP Archive**
   ```bash
   zip -r og-preview.zip OG-Preview/ -x "*.git*"
   ```

2. **Upload via WordPress**
   - Go to **Plugins > Add New**
   - Click "Upload Plugin"
   - Choose the `og-preview.zip` file
   - Click "Install Now"
   - Click "Activate Plugin"

## Post-Installation Configuration

### 1. Configure Settings

1. Go to **Settings > OG Preview**
2. Select which platforms you want to preview:
   - ☑ Facebook
   - ☑ Twitter
   - ☑ WhatsApp
   - ☑ LinkedIn
3. Click "Save Settings"

### 2. Test the Plugin

#### In Classic Editor:

1. Go to **Posts > Add New** or edit an existing post
2. Look for the "Social Media Preview" meta box in the right sidebar
3. Add a title, content, and featured image
4. Switch between platform tabs to see previews
5. Click "Refresh Preview" to update

#### In Elementor:

1. Edit a page with Elementor
2. Look for the pink floating button in the bottom-right corner
3. Click it to open the preview panel
4. Test different platforms

## Troubleshooting

### Preview Not Showing

**Issue**: Meta box or preview panel not visible

**Solutions**:
- Ensure the plugin is activated
- Check if your user role has permission to edit posts
- Try disabling other plugins to check for conflicts
- Clear browser cache

### Images Not Displaying

**Issue**: Preview shows no image or broken image

**Solutions**:
- Ensure post has a featured image set
- Check image file size (recommended: 1200x630px)
- Verify image URL is accessible
- Check if SEO plugin has OG image configured

### Elementor Button Not Visible

**Issue**: Floating button doesn't appear in Elementor

**Solutions**:
- Ensure Elementor is installed and activated
- Clear Elementor cache: **Elementor > Tools > Regenerate CSS**
- Check browser console for JavaScript errors
- Disable other Elementor add-ons to test for conflicts

### Preview Not Updating

**Issue**: Changes to post don't reflect in preview

**Solutions**:
- Click the "Refresh Preview" button
- Save the post/page and refresh
- Clear WordPress object cache
- Check AJAX functionality is working

## Integration with SEO Plugins

### Yoast SEO

The plugin automatically detects Yoast SEO and uses:
- `_yoast_wpseo_opengraph-title` for OG title
- `_yoast_wpseo_opengraph-description` for OG description
- `_yoast_wpseo_opengraph-image` for OG image

No additional configuration needed.

### Rank Math

The plugin automatically detects Rank Math and uses:
- `rank_math_facebook_title` for OG title
- `rank_math_facebook_description` for OG description
- `rank_math_facebook_image` for OG image

No additional configuration needed.

### Other SEO Plugins

If you use a different SEO plugin, you can use the `og_preview_tags` filter to customize the OG tags:

```php
add_filter('og_preview_tags', function($og_tags, $post_id) {
    // Your custom logic here
    $og_tags['title'] = get_post_meta($post_id, '_your_custom_title', true);
    return $og_tags;
}, 10, 2);
```

## Permissions

The plugin requires:
- `edit_posts` capability to see previews in post editor
- `manage_options` capability to access settings page

## Performance Considerations

- Assets (CSS/JS) only load on relevant admin pages
- No frontend impact (plugin only runs in admin)
- AJAX requests are nonce-protected
- Images are not re-sized or processed (uses existing URLs)

## Uninstallation

1. Deactivate the plugin from **Plugins > Installed Plugins**
2. Click "Delete" to remove all plugin files
3. No database tables are created, so no cleanup needed

## Support

For issues, feature requests, or contributions:
- GitHub: https://github.com/BlindTrevor/OG-Preview
- Issues: https://github.com/BlindTrevor/OG-Preview/issues

## Next Steps

After installation:
1. Read the [Usage Examples](USAGE_EXAMPLES.md)
2. Check the [README](README.md) for features
3. Review the [Changelog](CHANGELOG.md) for updates
4. Start creating content and previewing!
