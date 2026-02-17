<?php
/**
 * Meta box functionality for OG Preview
 */

if (!defined('ABSPATH')) {
    exit;
}

class OG_Preview_Metabox {
    
    private $core;
    
    public function __construct() {
        $this->core = new OG_Preview_Core();
        
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_og_preview_get_preview', array($this, 'ajax_get_preview'));
    }
    
    /**
     * Add meta box
     */
    public function add_meta_box() {
        $post_types = get_post_types(array('public' => true));
        
        foreach ($post_types as $post_type) {
            add_meta_box(
                'og-preview-metabox',
                __('Social Media Preview', 'og-preview'),
                array($this, 'render_meta_box'),
                $post_type,
                'side',
                'high'
            );
        }
    }
    
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts($hook) {
        if ('post.php' !== $hook && 'post-new.php' !== $hook) {
            return;
        }
        
        wp_enqueue_style(
            'og-preview-admin',
            OG_PREVIEW_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            OG_PREVIEW_VERSION
        );
        
        wp_enqueue_script(
            'og-preview-admin',
            OG_PREVIEW_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            OG_PREVIEW_VERSION,
            true
        );
        
        wp_localize_script('og-preview-admin', 'ogPreview', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('og_preview_nonce')
        ));
    }
    
    /**
     * Render meta box
     */
    public function render_meta_box($post) {
        $og_tags = $this->core->get_og_tags($post->ID);
        $platforms = get_option('og_preview_platforms', array('facebook', 'twitter', 'whatsapp', 'linkedin'));
        
        ?>
        <div id="og-preview-container">
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
                        <?php echo $this->render_platform_preview($platform, $og_tags); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="og-preview-refresh">
                <button type="button" class="button og-preview-refresh-btn">
                    <?php _e('Refresh Preview', 'og-preview'); ?>
                </button>
            </div>
        </div>
        
        <input type="hidden" id="og-preview-post-id" value="<?php echo esc_attr($post->ID); ?>">
        <?php
    }
    
    /**
     * Render platform preview
     */
    private function render_platform_preview($platform, $og_tags) {
        $output = '';
        
        switch ($platform) {
            case 'facebook':
                $output = $this->render_facebook_preview($og_tags);
                break;
            case 'twitter':
                $output = $this->render_twitter_preview($og_tags);
                break;
            case 'whatsapp':
                $output = $this->render_whatsapp_preview($og_tags);
                break;
            case 'linkedin':
                $output = $this->render_linkedin_preview($og_tags);
                break;
        }
        
        return $output;
    }
    
    /**
     * Render Facebook preview
     */
    private function render_facebook_preview($og_tags) {
        ob_start();
        ?>
        <div class="og-preview-card og-preview-facebook">
            <?php if (!empty($og_tags['image'])): ?>
                <div class="og-preview-image">
                    <img src="<?php echo esc_url($og_tags['image']); ?>" alt="">
                </div>
            <?php endif; ?>
            <div class="og-preview-details">
                <div class="og-preview-domain"><?php echo esc_html(parse_url($og_tags['url'], PHP_URL_HOST)); ?></div>
                <div class="og-preview-title"><?php echo esc_html($og_tags['title']); ?></div>
                <div class="og-preview-description"><?php echo esc_html($og_tags['description']); ?></div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render Twitter preview
     */
    private function render_twitter_preview($og_tags) {
        ob_start();
        ?>
        <div class="og-preview-card og-preview-twitter">
            <?php if (!empty($og_tags['image'])): ?>
                <div class="og-preview-image">
                    <img src="<?php echo esc_url($og_tags['image']); ?>" alt="">
                </div>
            <?php endif; ?>
            <div class="og-preview-details">
                <div class="og-preview-title"><?php echo esc_html($og_tags['title']); ?></div>
                <div class="og-preview-description"><?php echo esc_html($og_tags['description']); ?></div>
                <div class="og-preview-domain"><?php echo esc_html(parse_url($og_tags['url'], PHP_URL_HOST)); ?></div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render WhatsApp preview
     */
    private function render_whatsapp_preview($og_tags) {
        ob_start();
        ?>
        <div class="og-preview-card og-preview-whatsapp">
            <div class="og-preview-details">
                <div class="og-preview-site"><?php echo esc_html($og_tags['site_name']); ?></div>
                <div class="og-preview-title"><?php echo esc_html($og_tags['title']); ?></div>
            </div>
            <?php if (!empty($og_tags['image'])): ?>
                <div class="og-preview-image">
                    <img src="<?php echo esc_url($og_tags['image']); ?>" alt="">
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Render LinkedIn preview
     */
    private function render_linkedin_preview($og_tags) {
        ob_start();
        ?>
        <div class="og-preview-card og-preview-linkedin">
            <?php if (!empty($og_tags['image'])): ?>
                <div class="og-preview-image">
                    <img src="<?php echo esc_url($og_tags['image']); ?>" alt="">
                </div>
            <?php endif; ?>
            <div class="og-preview-details">
                <div class="og-preview-title"><?php echo esc_html($og_tags['title']); ?></div>
                <div class="og-preview-domain"><?php echo esc_html(parse_url($og_tags['url'], PHP_URL_HOST)); ?></div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * AJAX handler to get preview
     */
    public function ajax_get_preview() {
        check_ajax_referer('og_preview_nonce', 'nonce');
        
        $post_id = intval($_POST['post_id']);
        
        if (!$post_id) {
            wp_send_json_error('Invalid post ID');
        }
        
        $og_tags = $this->core->get_og_tags($post_id);
        $platforms = get_option('og_preview_platforms', array('facebook', 'twitter', 'whatsapp', 'linkedin'));
        
        $previews = array();
        foreach ($platforms as $platform) {
            $previews[$platform] = $this->render_platform_preview($platform, $og_tags);
        }
        
        wp_send_json_success($previews);
    }
}
