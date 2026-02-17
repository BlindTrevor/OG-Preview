<?php
/**
 * Elementor integration for OG Preview
 */

if (!defined('ABSPATH')) {
    exit;
}

class OG_Preview_Elementor {
    
    /**
     * Core instance
     * 
     * @var OG_Preview_Core
     */
    private $core;
    
    public function __construct() {
        $this->core = OG_Preview_Core::get_instance();
        
        // Check if Elementor is active
        add_action('elementor/editor/before_enqueue_scripts', array($this, 'enqueue_elementor_scripts'));
        add_action('elementor/editor/footer', array($this, 'add_elementor_panel'));
    }
    
    /**
     * Enqueue scripts for Elementor editor
     */
    public function enqueue_elementor_scripts() {
        wp_enqueue_style(
            'og-preview-elementor',
            OG_PREVIEW_PLUGIN_URL . 'assets/css/elementor.css',
            array(),
            OG_PREVIEW_VERSION
        );
        
        wp_enqueue_script(
            'og-preview-elementor',
            OG_PREVIEW_PLUGIN_URL . 'assets/js/elementor.js',
            array('jquery'),
            OG_PREVIEW_VERSION,
            true
        );
        
        wp_localize_script('og-preview-elementor', 'ogPreview', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('og_preview_nonce'),
            'post_id' => get_the_ID()
        ));
    }
    
    /**
     * Add panel to Elementor editor
     */
    public function add_elementor_panel() {
        $post_id = get_the_ID();
        $og_tags = $this->core->get_og_tags($post_id);
        $platforms = get_option('og_preview_platforms', array('facebook', 'twitter', 'whatsapp', 'linkedin'));
        
        ?>
        <div id="og-preview-elementor-panel" style="display:none;">
            <div class="og-preview-elementor-header">
                <h3><?php _e('Social Media Preview', 'og-preview'); ?></h3>
                <button class="og-preview-close" type="button">&times;</button>
            </div>
            
            <div class="og-preview-tabs">
                <?php foreach ($platforms as $platform): ?>
                    <button type="button" class="og-preview-tab" data-platform="<?php echo esc_attr($platform); ?>">
                        <?php echo esc_html(ucfirst($platform)); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            
            <div class="og-preview-content">
                <?php foreach ($platforms as $platform): ?>
                    <div class="og-preview-platform" data-platform="<?php echo esc_attr($platform); ?>">
                        <?php echo OG_Preview_Renderer::render_platform_preview($platform, $og_tags); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="og-preview-refresh">
                <button type="button" class="button og-preview-refresh-btn">
                    <?php _e('Refresh Preview', 'og-preview'); ?>
                </button>
            </div>
        </div>
        
        <button id="og-preview-elementor-trigger" type="button" title="<?php _e('Social Media Preview', 'og-preview'); ?>">
            <i class="eicon-share" aria-hidden="true"></i>
            <span class="elementor-screen-only"><?php _e('Social Media Preview', 'og-preview'); ?></span>
        </button>
        <?php
    }
}
