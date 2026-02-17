# Changelog

All notable changes to the OG Preview plugin will be documented in this file.

## [1.0.1] - 2026-02-17

### Fixed
- Fixed OG description showing CSS styles and JavaScript code instead of clean text content
- Description extraction now properly removes `<style>`, `<script>`, and `<head>` tags and their contents
- Uses WordPress's `wp_strip_all_tags()` function for robust content cleaning
- Fallback regex implementation for non-WordPress environments

### Changed
- Improved `clean_content_for_description()` method to use safer WordPress core functions
- Updated regex patterns to use non-greedy matching to avoid performance issues
- Removed console.error statements from JavaScript for production readiness
- Updated .gitignore to exclude development documentation and test files from production builds

## [1.0.0] - 2026-02-17

### Added
- Initial release of OG Preview plugin
- Social media preview functionality for Facebook, Twitter, WhatsApp, and LinkedIn
- Meta box integration in WordPress post/page editor
- Elementor page builder integration with floating preview button
- Automatic OG tag extraction from multiple sources:
  - Custom meta fields
  - Yoast SEO integration
  - Rank Math SEO integration
  - WordPress native fields (title, excerpt, featured image)
- Admin settings page to enable/disable specific platforms
- Real-time preview refresh functionality
- AJAX-powered preview updates
- Responsive preview cards matching each platform's style
- Smart fallback system for missing OG data
- Complete documentation and usage examples

### Features
- Platform-specific preview rendering
- Tab-based interface for switching between platforms
- Auto-refresh on content changes (debounced)
- Support for all public post types
- Filter hooks for developers to customize OG tags
- Clean, modern UI matching WordPress design guidelines
- Mobile-responsive admin interface
- No external dependencies required

### Technical Details
- WordPress 5.0+ compatible
- PHP 7.0+ compatible
- Follows WordPress coding standards
- Properly sanitized and escaped output
- Uses WordPress AJAX for dynamic updates
- Enqueues assets only where needed
- Minimal performance impact
