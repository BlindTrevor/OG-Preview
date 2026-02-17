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
            __('OG Preview Settings', 'OG-Preview'),
            __('OG Preview', 'OG-Preview'),
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
            __('General Settings', 'OG-Preview'),
            array($this, 'general_section_callback'),
            'og-preview-settings'
        );
        
        add_settings_field(
            'og_preview_platforms',
            __('Enabled Platforms', 'OG-Preview'),
            array($this, 'platforms_field_callback'),
            'og-preview-settings',
            'og_preview_general'
        );
    }
    
    /**
     * General section callback
     */
    public function general_section_callback() {
        echo '<p>' . esc_html__('Configure which social media platforms to show previews for.', 'OG-Preview') . '</p>';
    }
    
    /**
     * Sanitize platforms setting
     * 
     * @param array $input Input values
     * @return array Sanitized values
     */
    public function sanitize_platforms($input) {
        if (!is_array($input)) {
            return array();
        }
        
        $available_platforms = array('facebook', 'twitter', 'whatsapp', 'linkedin');
        $sanitized = array();
        
        foreach ($input as $platform) {
            if (in_array($platform, $available_platforms)) {
                $sanitized[] = sanitize_text_field($platform);
            }
        }
        
        return $sanitized;
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
            $checked = in_array($key, $platforms) ? 'checked' : '';
            echo '<label style="display: block; margin-bottom: 5px;">';
            echo '<input type="checkbox" name="og_preview_platforms[]" value="' . esc_attr($key) . '" ' . esc_attr($checked) . '> ';
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
                submit_button(__('Save Settings', 'OG-Preview'));
                ?>
            </form>
        </div>
        <?php
    }
}
