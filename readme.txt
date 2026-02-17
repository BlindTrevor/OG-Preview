=== OG Preview ===
Contributors: blindtrevor
Tags: social media, open graph, preview, facebook, twitter
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.0.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Preview how your page will look when shared on social media based on Open Graph tags. Includes Elementor integration.

== Description ==

A WordPress plugin that provides a live preview of how your pages and posts will look when shared on social media platforms, based on Open Graph (OG) tags. Includes seamless integration with Elementor page builder.

= Features =

* **Real-time Social Media Previews**: See how your content will appear on:
  * Facebook
  * Twitter
  * WhatsApp
  * LinkedIn

* **Smart OG Tag Detection**: Automatically extracts Open Graph data from:
  * Custom OG meta fields
  * Yoast SEO plugin
  * Rank Math SEO plugin
  * WordPress native featured images and excerpts
  * Post title and content

* **Elementor Integration**: Access social media previews directly from the Elementor editor with a convenient floating button

* **Meta Box in Post Editor**: View previews in the sidebar of the classic WordPress editor

* **Customizable Settings**: Choose which social platforms to preview in the admin settings

== Installation ==

1. Download the plugin files
2. Upload the `og-preview` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure settings at Settings > OG Preview

== Frequently Asked Questions ==

= How does the plugin detect Open Graph tags? =

The plugin intelligently extracts Open Graph metadata in the following priority order:
1. Custom OG meta fields (if set)
2. Yoast SEO OG fields (if Yoast is installed)
3. Rank Math OG fields (if Rank Math is installed)
4. WordPress defaults (featured image, post title, post excerpt)

= Does it work with Elementor? =

Yes! The plugin includes seamless Elementor integration with a floating button in the editor.

= Which social platforms are supported? =

Currently supports Facebook, Twitter, WhatsApp, and LinkedIn previews.

== Screenshots ==

1. Preview in Classic Editor - The meta box appears in the sidebar showing real-time previews
2. Preview in Elementor - A floating button provides easy access to the preview panel

== Changelog ==

= 1.0.1 =
* Fixed WordPress Plugin Check issues
* Updated text domain to OG-Preview
* Added proper escaping for all output
* Added sanitization for settings
* Replaced deprecated functions with WordPress alternatives

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.1 =
Security improvements and WordPress coding standards compliance.
