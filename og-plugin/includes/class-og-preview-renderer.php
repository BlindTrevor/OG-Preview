<?php
/**
 * Renderer for OG Preview cards
 */

if (!defined('ABSPATH')) {
    exit;
}

class OG_Preview_Renderer {
    
    /**
     * Render platform preview
     * 
     * @param string $platform Platform name
     * @param array $og_tags OG tags array
     * @return string HTML output
     */
    public static function render_platform_preview($platform, $og_tags) {
        $output = '';
        
        switch ($platform) {
            case 'facebook':
                $output = self::render_facebook_preview($og_tags);
                break;
            case 'twitter':
                $output = self::render_twitter_preview($og_tags);
                break;
            case 'whatsapp':
                $output = self::render_whatsapp_preview($og_tags);
                break;
            case 'linkedin':
                $output = self::render_linkedin_preview($og_tags);
                break;
        }
        
        return apply_filters('og_preview_render_platform', $output, $platform, $og_tags);
    }
    
    /**
     * Render Facebook preview
     * 
     * @param array $og_tags OG tags
     * @return string HTML output
     */
    private static function render_facebook_preview($og_tags) {
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
     * 
     * @param array $og_tags OG tags
     * @return string HTML output
     */
    private static function render_twitter_preview($og_tags) {
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
     * 
     * @param array $og_tags OG tags
     * @return string HTML output
     */
    private static function render_whatsapp_preview($og_tags) {
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
     * 
     * @param array $og_tags OG tags
     * @return string HTML output
     */
    private static function render_linkedin_preview($og_tags) {
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
}
