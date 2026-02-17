# OG Preview - WordPress Plugin

A WordPress plugin that provides a live preview of how your pages and posts will look when shared on social media platforms, based on Open Graph (OG) tags. Includes seamless integration with Elementor page builder.

## Features

- **Real-time Social Media Previews**: See how your content will appear on:
  - Facebook
  - Twitter
  - WhatsApp
  - LinkedIn

- **Smart OG Tag Detection**: Automatically extracts Open Graph data from:
  - Custom OG meta fields
  - Yoast SEO plugin
  - Rank Math SEO plugin
  - WordPress native featured images and excerpts
  - Post title and content

- **Elementor Integration**: Access social media previews directly from the Elementor editor with a convenient floating button

- **Meta Box in Post Editor**: View previews in the sidebar of the classic WordPress editor

- **Customizable Settings**: Choose which social platforms to preview in the admin settings

## Installation

1. Download the plugin files
2. Upload the `og-preview` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure settings at Settings > OG Preview

## Usage

### In Classic WordPress Editor

1. Create or edit a post/page
2. Look for the "Social Media Preview" meta box in the sidebar (usually on the right)
3. Click through different platform tabs to see how your content will appear
4. Click "Refresh Preview" to update the preview after making changes

### In Elementor Editor

1. Open a page in Elementor editor
2. Look for the floating share icon button in the bottom-right corner
3. Click the button to open the preview panel
4. Navigate between different platforms using the tabs
5. Click "Refresh Preview" to update after making changes

### Settings

Navigate to **Settings > OG Preview** in the WordPress admin to:
- Enable/disable preview for specific social platforms
- Configure plugin behavior

## How It Works

The plugin intelligently extracts Open Graph metadata in the following priority order:

1. **Custom OG meta fields** (if set)
2. **Yoast SEO** OG fields (if Yoast is installed)
3. **Rank Math** OG fields (if Rank Math is installed)
4. **WordPress defaults**:
   - Featured image for OG image
   - Post title for OG title
   - Post excerpt or trimmed content for OG description
   - Site logo as fallback for OG image

## Compatibility

- WordPress 5.0 or higher
- Works with Gutenberg editor
- Works with Classic editor
- Elementor page builder integration
- Compatible with popular SEO plugins (Yoast SEO, Rank Math)

## Screenshots

### Preview in Classic Editor
The meta box appears in the sidebar showing real-time previews for each platform.

### Preview in Elementor
A floating button provides easy access to the preview panel without leaving the Elementor interface.

## Development

### File Structure

```
og-preview/
├── og-preview.php                 # Main plugin file
├── includes/
│   ├── class-og-preview-core.php      # Core OG tag extraction
│   ├── class-og-preview-admin.php     # Admin settings
│   ├── class-og-preview-metabox.php   # Meta box functionality
│   └── class-og-preview-elementor.php # Elementor integration
├── assets/
│   ├── css/
│   │   ├── admin.css              # Admin styles
│   │   └── elementor.css          # Elementor styles
│   └── js/
│       ├── admin.js               # Admin JavaScript
│       └── elementor.js           # Elementor JavaScript
└── README.md
```

## Filters

### `og_preview_tags`

Modify OG tags before rendering:

```php
add_filter('og_preview_tags', function($og_tags, $post_id) {
    // Customize OG tags
    $og_tags['title'] = 'Custom Title';
    return $og_tags;
}, 10, 2);
```

## License

GPL v2 or later

## Author

BlindTrevor

## Support

For issues and feature requests, please visit the [GitHub repository](https://github.com/BlindTrevor/OG-Preview).