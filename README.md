# OG Preview

![WordPress Plugin](https://img.shields.io/badge/WordPress-Plugin-blue)
![Version](https://img.shields.io/badge/version-1.0.1-green)
![License](https://img.shields.io/badge/license-GPL%20v2%2B-blue)

A WordPress plugin that provides a live preview of how your pages and posts will look when shared on social media platforms, based on Open Graph (OG) tags. Includes seamless integration with Elementor page builder.

## 📋 Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Screenshots](#screenshots)
- [How It Works](#how-it-works)
- [Compatibility](#compatibility)
- [Development](#development)
- [Filters](#filters)
- [License](#license)
- [Support](#support)

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

### From GitHub

1. Download the latest release from the [GitHub repository](https://github.com/BlindTrevor/OG-Preview)
2. Extract the ZIP file
3. Upload the `og-preview` folder to the `/wp-content/plugins/` directory
4. Activate the plugin through the 'Plugins' menu in WordPress
5. Configure settings at **Settings > OG Preview**

### From WordPress Plugin Directory (when available)

1. Navigate to **Plugins > Add New** in your WordPress admin
2. Search for "OG Preview"
3. Click **Install Now** and then **Activate**
4. Configure settings at **Settings > OG Preview**

### Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- (Optional) Elementor page builder for Elementor integration
- (Optional) Yoast SEO or Rank Math for enhanced SEO integration

## Usage

### Getting Started

After installation and activation:

1. Navigate to **Settings > OG Preview** in your WordPress admin
2. Enable the social media platforms you want to preview (Facebook, Twitter, WhatsApp, LinkedIn)
3. Save your settings

### In Classic WordPress Editor

1. Create or edit a post/page
2. Look for the **"Social Media Preview"** meta box in the sidebar (usually on the right)
3. Click through different platform tabs to see how your content will appear on each platform
4. Click **"Refresh Preview"** to update the preview after making changes to your content
5. The preview automatically updates when you change the featured image

**Tip:** If you don't see the meta box, click **Screen Options** at the top of the page and ensure "Social Media Preview" is checked.

### In Elementor Editor

1. Open a page in Elementor editor
2. Look for the **floating share icon button** in the bottom-right corner of the screen
3. Click the button to open the preview panel
4. Navigate between different platforms using the tabs
5. Click **"Refresh Preview"** to update after making changes to your page

**Tip:** The preview panel slides out from the right side and can be closed by clicking the button again.

### In Gutenberg (Block) Editor

1. Create or edit a post/page in the Gutenberg editor
2. Look for the **"Social Media Preview"** panel in the right sidebar
3. Click through different platform tabs to preview your content
4. Click **"Refresh Preview"** after making changes

### Settings

Navigate to **Settings > OG Preview** in the WordPress admin to:

- **Enable/disable specific social platforms**: Choose which platforms (Facebook, Twitter, WhatsApp, LinkedIn) to show in the preview
- **Control preview display**: Configure where and how previews appear in your WordPress admin

All settings are saved automatically when you click **Save Changes**.

## How It Works

The plugin intelligently extracts Open Graph metadata in the following priority order:

1. **Custom OG meta fields** (if set using `_og_preview_*` meta keys)
2. **Yoast SEO** OG fields (if Yoast SEO plugin is installed and configured)
3. **Rank Math** OG fields (if Rank Math SEO plugin is installed and configured)
4. **WordPress defaults**:
   - Featured image for OG image
   - Post title for OG title
   - Post excerpt (or trimmed content) for OG description
   - Site logo as fallback for OG image

The preview shows you exactly how your content will appear when shared on social media, including:

- **Title**: The headline that appears in the social media card
- **Description**: The text snippet shown below the title
- **Image**: The visual thumbnail displayed with your link
- **URL**: The link that will be shared

Each platform has a slightly different card design, which the preview accurately reflects.

## Compatibility

- **WordPress**: 5.0 or higher
- **PHP**: 7.0 or higher
- **Editors**:
  - ✅ Gutenberg (Block Editor)
  - ✅ Classic Editor
  - ✅ Elementor Page Builder
- **SEO Plugins**:
  - ✅ Yoast SEO
  - ✅ Rank Math SEO
  - ✅ Works without any SEO plugin (uses WordPress defaults)

### Tested With

- WordPress 6.9
- Elementor 3.x
- Yoast SEO 22.x
- Rank Math 1.x

## Screenshots

### Preview in Classic Editor

The meta box appears in the sidebar of the WordPress post/page editor, showing real-time social media previews for each platform.

<img width="258" height="615" alt="image" src="https://github.com/user-attachments/assets/507c0c0d-7de7-421c-924a-56ecb9bcc7cd" />

### Preview in Elementor

A floating button provides easy access to the preview panel without leaving the Elementor interface.

<img width="74" height="104" alt="image" src="https://github.com/user-attachments/assets/e6856eeb-5532-4041-859a-122eeceae0f6" />

### Settings Page

Configure which social media platforms to preview from the WordPress admin.

<img width="388" height="540" alt="image" src="https://github.com/user-attachments/assets/1a4f7a4a-572b-4045-853b-04aad5d8a913" />

## Frequently Asked Questions

### Does this plugin modify my actual Open Graph tags?

No, the plugin only provides a visual preview. It reads existing OG tags from your SEO plugins or WordPress defaults. If you want to customize the actual OG tags that appear in your page source, use a SEO plugin like Yoast SEO or Rank Math.

### Do I need a SEO plugin to use this?

No! The plugin works without any SEO plugin by using WordPress defaults (featured image, post title, excerpt). However, it works great alongside Yoast SEO or Rank Math if you want more control over your OG tags.

### Which social media platforms are supported?

Currently, the plugin supports previews for:
- Facebook
- Twitter
- WhatsApp
- LinkedIn

### Does this work with custom post types?

Yes! The plugin works with all public post types, including custom post types.

### Will this slow down my site?

No, the previews only load in the WordPress admin area when editing posts/pages. They don't affect your front-end site performance at all.

### Can I customize the preview appearance?

Yes, developers can use the `og_preview_tags` filter to modify the OG tags before they're displayed in the preview. See the [Filters](#filters) section below.

## Development

### File Structure

```
og-preview/
├── og-preview.php                     # Main plugin file
├── readme.txt                         # WordPress.org readme
├── includes/
│   ├── class-og-preview-core.php      # Core OG tag extraction logic
│   ├── class-og-preview-renderer.php  # Render preview HTML
│   ├── class-og-preview-admin.php     # Admin settings page
│   ├── class-og-preview-metabox.php   # Meta box for post editor
│   └── class-og-preview-elementor.php # Elementor integration
├── assets/
│   ├── css/
│   │   ├── admin.css                  # Meta box styles
│   │   └── elementor.css              # Elementor panel styles
│   ├── js/
│   │   ├── admin.js                   # Meta box JavaScript
│   │   └── elementor.js               # Elementor integration JavaScript
│   └── screenshots/                   # Plugin screenshots
├── languages/
│   └── index.php                      # Directory protection
└── README.md                          # This file
```

### For Developers

The plugin is built with WordPress best practices:

- **Object-oriented architecture**: Each component is a separate class
- **WordPress coding standards**: Follows WordPress PHP coding standards
- **Proper sanitization**: All user input is sanitized and validated
- **Internationalization ready**: All strings are translatable
- **Hooks and filters**: Extend functionality without modifying core files

### Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

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

**BlindTrevor**  
Sweet Pea Software  
[https://www.sweetpeasoftware.co.uk](https://www.sweetpeasoftware.co.uk)

## Support

For issues, questions, and feature requests:

- 🐛 [Report an issue](https://github.com/BlindTrevor/OG-Preview/issues)
- 💡 [Request a feature](https://github.com/BlindTrevor/OG-Preview/issues/new)
- 📖 [View documentation](https://github.com/BlindTrevor/OG-Preview)
- ⭐ [Star this repo](https://github.com/BlindTrevor/OG-Preview) if you find it useful!

## Changelog

### 1.0.1
- Fixed WordPress coding standards compliance
- Fixed text domain consistency
- Fixed escaping and sanitization issues
- Added proper validation for superglobal arrays
- Replaced deprecated functions with WordPress alternatives

### 1.0.0
- Initial release
- Facebook, Twitter, WhatsApp, and LinkedIn preview support
- Integration with Yoast SEO and Rank Math
- Elementor page builder integration
- Meta box for Classic and Gutenberg editors
