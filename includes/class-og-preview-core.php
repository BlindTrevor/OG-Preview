<?php
/**
 * Core functionality for OG Preview
 */

if (!defined('ABSPATH')) {
    exit;
}

class OG_Preview_Core {
    
    /**
     * Single instance of the class
     */
    private static $instance = null;
    
    /**
     * Get singleton instance
     * 
     * @return OG_Preview_Core
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct() {
        // Private constructor for singleton
    }
    
    /**
     * Get Open Graph tags for a post
     * 
     * @param int $post_id Post ID
     * @return array Array of OG tags
     */
    public function get_og_tags($post_id) {
        $post = get_post($post_id);
        
        if (!$post) {
            return array();
        }
        
        $og_tags = array();
        
        // Get OG title
        $og_tags['title'] = $this->get_og_title($post);
        
        // Get OG description
        $og_tags['description'] = $this->get_og_description($post);
        
        // Get OG image
        $og_tags['image'] = $this->get_og_image($post);
        
        // Get OG URL
        $og_tags['url'] = get_permalink($post_id);
        
        // Get site name
        $og_tags['site_name'] = get_bloginfo('name');
        
        // Get type
        $og_tags['type'] = is_front_page() ? 'website' : 'article';
        
        return apply_filters('og_preview_tags', $og_tags, $post_id);
    }
    
    /**
     * Get OG title for a post
     * 
     * @param WP_Post $post Post object
     * @return string OG title
     */
    private function get_og_title($post) {
        // Check for custom OG title from meta
        $custom_title = get_post_meta($post->ID, '_og_preview_title', true);
        if (!empty($custom_title)) {
            return $custom_title;
        }
        
        // Check for Yoast SEO
        if (class_exists('WPSEO_Meta')) {
            $yoast_title = get_post_meta($post->ID, '_yoast_wpseo_opengraph-title', true);
            if (!empty($yoast_title)) {
                return $yoast_title;
            }
        }
        
        // Check for Rank Math
        if (class_exists('RankMath')) {
            $rankmath_title = get_post_meta($post->ID, 'rank_math_facebook_title', true);
            if (!empty($rankmath_title)) {
                return $rankmath_title;
            }
        }
        
        // Fallback to post title
        return get_the_title($post->ID);
    }
    
    /**
     * Get OG description for a post
     * 
     * @param WP_Post $post Post object
     * @return string OG description
     */
    private function get_og_description($post) {
        // Check for custom OG description from meta
        $custom_desc = get_post_meta($post->ID, '_og_preview_description', true);
        if (!empty($custom_desc)) {
            return $custom_desc;
        }
        
        // Check for Yoast SEO
        if (class_exists('WPSEO_Meta')) {
            $yoast_desc = get_post_meta($post->ID, '_yoast_wpseo_opengraph-description', true);
            if (!empty($yoast_desc)) {
                return $yoast_desc;
            }
        }
        
        // Check for Rank Math
        if (class_exists('RankMath')) {
            $rankmath_desc = get_post_meta($post->ID, 'rank_math_facebook_description', true);
            if (!empty($rankmath_desc)) {
                return $rankmath_desc;
            }
        }
        
        // Check for excerpt
        if (!empty($post->post_excerpt)) {
            return wp_trim_words($post->post_excerpt, 30);
        }
        
        // Fallback to trimmed content
        return wp_trim_words(strip_tags($post->post_content), 30);
    }
    
    /**
     * Get OG image for a post
     * 
     * @param WP_Post $post Post object
     * @return string OG image URL
     */
    private function get_og_image($post) {
        // Check for custom OG image from meta
        $custom_image = get_post_meta($post->ID, '_og_preview_image', true);
        if (!empty($custom_image)) {
            return $custom_image;
        }
        
        // Check for Yoast SEO
        if (class_exists('WPSEO_Meta')) {
            $yoast_image = get_post_meta($post->ID, '_yoast_wpseo_opengraph-image', true);
            if (!empty($yoast_image)) {
                return $yoast_image;
            }
        }
        
        // Check for Rank Math
        if (class_exists('RankMath')) {
            $rankmath_image = get_post_meta($post->ID, 'rank_math_facebook_image', true);
            if (!empty($rankmath_image)) {
                return $rankmath_image;
            }
        }
        
        // Check for featured image
        if (has_post_thumbnail($post->ID)) {
            $thumbnail_id = get_post_thumbnail_id($post->ID);
            $image = wp_get_attachment_image_src($thumbnail_id, 'large');
            if ($image) {
                return $image[0];
            }
        }
        
        // Fallback to site logo or default
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if ($logo) {
                return $logo[0];
            }
        }
        
        return '';
    }
}
