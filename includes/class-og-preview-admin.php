<?php
/**
 * Admin functionality for OG Preview
 */

if (!defined('ABSPATH')) {
    exit;
}

class OG_Preview_Admin {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('OG Preview Settings', 'og-preview'),
            __('OG Preview', 'og-preview'),
            'manage_options',
            'og-preview-settings',
            array($this, 'settings_page')
        );
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('og_preview_settings', 'og_preview_platforms', array(
            'sanitize_callback' => array($this, 'sanitize_platforms')
        ));
        
        add_settings_section(
            'og_preview_general',
            __('General Settings', 'og-preview'),
            array($this, 'general_section_callback'),
            'og-preview-settings'
        );
        
        add_settings_field(
            'og_preview_platforms',
            __('Enabled Platforms', 'og-preview'),
            array($this, 'platforms_field_callback'),
            'og-preview-settings',
            'og_preview_general'
        );
    }
    
    /**
     * General section callback
     */
    public function general_section_callback() {
        echo '<p>' . esc_html__('Configure which social media platforms to show previews for.', 'og-preview') . '</p>';
    }
    
    /**
     * Platforms field callback
     */
    public function platforms_field_callback() {
        $platforms = get_option('og_preview_platforms', array('facebook', 'twitter', 'whatsapp', 'linkedin'));
        $available_platforms = array(
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'whatsapp' => 'WhatsApp',
            'linkedin' => 'LinkedIn'
        );
        
        foreach ($available_platforms as $key => $label) {
            echo '<label style="display: block; margin-bottom: 5px;">';
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- checked() returns escaped HTML
            echo '<input type="checkbox" name="og_preview_platforms[]" value="' . esc_attr($key) . '" ' . checked(true, in_array($key, $platforms), false) . '> ';
            echo esc_html($label);
            echo '</label>';
        }
    }
    
    /**
     * Settings page
     */
    public function settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('og_preview_settings');
                do_settings_sections('og-preview-settings');
                submit_button(__('Save Settings', 'og-preview'));
                ?>
            </form>
        </div>
        <?php
    }
    
    /**
     * Sanitize platforms setting
     * 
     * @param array $input Input value
     * @return array Sanitized value
     */
    public function sanitize_platforms($input) {
        if (!is_array($input)) {
            return array();
        }
        
        $valid_platforms = array('facebook', 'twitter', 'whatsapp', 'linkedin');
        $sanitized = array();
        
        foreach ($input as $platform) {
            if (in_array($platform, $valid_platforms)) {
                $sanitized[] = sanitize_text_field($platform);
            }
        }
        
        return $sanitized;
    }
}
