# OG Preview Plugin - Distribution Guide

## Directory Structure

This repository contains both the production-ready plugin and development documentation.

### Production Plugin (`og-preview/`)

The `og-preview/` directory contains **only** the files needed for the WordPress plugin. This directory is ready for distribution and can be:

1. Zipped and uploaded to WordPress
2. Deployed directly to `/wp-content/plugins/`
3. Distributed via WordPress plugin repository

**Contents:**
- Main plugin file (`og-preview.php`)
- PHP classes (`includes/`)
- CSS assets (`assets/css/`)
- JavaScript assets (`assets/js/`)
- User documentation (README, INSTALLATION, QUICKSTART, etc.)

**Total files:** 15 production-ready files

### Development Documentation (Root)

The following files in the repository root are for **development purposes only** and are excluded from the plugin distribution:

- `ARCHITECTURE.md` - Plugin architecture documentation
- `BUGFIX_DETAILS.md` - Bug fix documentation
- `DEVELOPER.md` - Developer guide and API reference
- `PLUGIN_HEADER_UPDATE.md` - Plugin header update notes
- `SUMMARY.md` - Implementation summary
- `VISUAL_FIX_DEMO.md` - Visual demonstration of fixes
- `VISUAL_GUIDE.md` - Visual guide for the plugin
- `tests/` - Test scripts and validation tools

## Distribution Instructions

### For WordPress Installation

1. **Zip the plugin directory:**
   ```bash
   cd og-preview
   zip -r og-preview.zip .
   ```

2. **Upload to WordPress:**
   - Go to WordPress Admin > Plugins > Add New > Upload Plugin
   - Select `og-preview.zip`
   - Click "Install Now" and then "Activate"

### For Manual Installation

1. **Copy the plugin directory:**
   ```bash
   cp -r og-preview /path/to/wordpress/wp-content/plugins/og-preview
   ```

2. **Activate in WordPress:**
   - Go to WordPress Admin > Plugins
   - Find "OG Preview" and click "Activate"

### For WordPress Plugin Repository

The `og-preview/` directory structure is ready for submission to the WordPress plugin repository as-is.

## Files Included in Distribution

### Core Files (6)
- `og-preview.php` - Main plugin file
- `includes/class-og-preview-core.php` - OG tag extraction
- `includes/class-og-preview-renderer.php` - Preview rendering
- `includes/class-og-preview-admin.php` - Admin settings
- `includes/class-og-preview-metabox.php` - Meta box functionality
- `includes/class-og-preview-elementor.php` - Elementor integration

### Assets (4)
- `assets/css/admin.css` - Admin styles
- `assets/css/elementor.css` - Elementor styles
- `assets/js/admin.js` - Admin JavaScript
- `assets/js/elementor.js` - Elementor JavaScript

### Documentation (5)
- `README.md` - Plugin overview and features
- `CHANGELOG.md` - Version history
- `INSTALLATION.md` - Installation instructions
- `QUICKSTART.md` - Quick start guide
- `USAGE_EXAMPLES.md` - Usage examples

## Version Information

- **Current Version:** 1.0.1
- **WordPress Requirement:** 5.0 or higher
- **PHP Requirement:** 7.0 or higher

## Production Readiness

The plugin in `og-preview/` has been validated for production:
- ✅ All PHP files pass syntax validation
- ✅ No debug logging in production (respects WP_DEBUG)
- ✅ Code review passed (0 issues)
- ✅ Security scan passed (0 vulnerabilities)
- ✅ Follows WordPress coding standards
- ✅ Proper sanitization and security checks
- ✅ No development files included

## Support

For development documentation and API reference, see `DEVELOPER.md` in the repository root.

For user documentation, see the files in `og-preview/`.
