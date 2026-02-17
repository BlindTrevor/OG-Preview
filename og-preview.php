<?php
/**
 * Plugin Name: OG Preview
 * Plugin URI: https://github.com/BlindTrevor/OG-Preview
 * Description: Preview how your page will look when shared on social media based on Open Graph tags. Includes Elementor integration.
 * Version: 1.0.0
 * Author: BlindTrevor
 * Author URI: https://github.com/BlindTrevor
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: og-preview
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('OG_PREVIEW_VERSION', '1.0.0');
define('OG_PREVIEW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('OG_PREVIEW_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once OG_PREVIEW_PLUGIN_DIR . 'includes/class-og-preview-core.php';
require_once OG_PREVIEW_PLUGIN_DIR . 'includes/class-og-preview-renderer.php';
require_once OG_PREVIEW_PLUGIN_DIR . 'includes/class-og-preview-admin.php';
require_once OG_PREVIEW_PLUGIN_DIR . 'includes/class-og-preview-metabox.php';
require_once OG_PREVIEW_PLUGIN_DIR . 'includes/class-og-preview-elementor.php';

// Initialize the plugin
function og_preview_init() {
    $og_preview_core = new OG_Preview_Core();
    $og_preview_admin = new OG_Preview_Admin();
    $og_preview_metabox = new OG_Preview_Metabox();
    $og_preview_elementor = new OG_Preview_Elementor();
}
add_action('plugins_loaded', 'og_preview_init');

// Activation hook
register_activation_hook(__FILE__, 'og_preview_activate');
function og_preview_activate() {
    // Activation tasks if needed
    flush_rewrite_rules();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'og_preview_deactivate');
function og_preview_deactivate() {
    // Deactivation tasks if needed
    flush_rewrite_rules();
}
