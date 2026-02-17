/**
 * OG Preview Elementor JavaScript
 */

(function($) {
    'use strict';
    
    $(window).on('elementor:init', function() {
        // Wait for Elementor to be ready
        elementor.on('preview:loaded', function() {
            initElementorPreview();
        });
    });
    
    /**
     * Initialize Elementor preview functionality
     */
    function initElementorPreview() {
        var $trigger = $('#og-preview-elementor-trigger');
        var $panel = $('#og-preview-elementor-panel');
        var $close = $('.og-preview-close');
        
        // Trigger button click
        $trigger.on('click', function(e) {
            e.preventDefault();
            $panel.addClass('show');
        });
        
        // Close button click
        $close.on('click', function(e) {
            e.preventDefault();
            $panel.removeClass('show');
        });
        
        // Close on outside click
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#og-preview-elementor-panel, #og-preview-elementor-trigger').length) {
                $panel.removeClass('show');
            }
        });
        
        // Initialize tabs
        initTabs();
        
        // Refresh button click
        $('.og-preview-refresh-btn').on('click', function(e) {
            e.preventDefault();
            refreshPreview();
        });
        
        // Watch for featured image changes using MutationObserver
        // This ensures the preview updates when the featured image is actually set/changed
        var featuredImageObserver = null;
        var postImageDiv = document.getElementById('postimagediv');
        var refreshTimeout;
        
        if (postImageDiv) {
            featuredImageObserver = new MutationObserver(function(mutations) {
                // Add a small delay to ensure the thumbnail ID is saved
                clearTimeout(refreshTimeout);
                refreshTimeout = setTimeout(function() {
                    refreshPreview();
                }, 1000);
            });
            
            // Observe changes to the featured image container
            featuredImageObserver.observe(postImageDiv, {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['class']
            });
        }
    }
    
    /**
     * Initialize tabs
     */
    function initTabs() {
        var $tabs = $('#og-preview-elementor-panel .og-preview-tab');
        var $platforms = $('#og-preview-elementor-panel .og-preview-platform');
        
        if ($tabs.length > 0) {
            // Activate first tab by default
            $tabs.first().addClass('active');
            $platforms.first().addClass('active');
            
            // Tab click handler
            $tabs.on('click', function() {
                var platform = $(this).data('platform');
                
                $tabs.removeClass('active');
                $(this).addClass('active');
                
                $platforms.removeClass('active');
                $('#og-preview-elementor-panel .og-preview-platform[data-platform="' + platform + '"]').addClass('active');
            });
        }
    }
    
    /**
     * Refresh preview via AJAX
     */
    function refreshPreview() {
        if (!ogPreview || !ogPreview.post_id) {
            return;
        }
        
        var $container = $('#og-preview-elementor-panel .og-preview-content');
        
        $.ajax({
            url: ogPreview.ajax_url,
            type: 'POST',
            data: {
                action: 'og_preview_get_preview',
                post_id: ogPreview.post_id,
                nonce: ogPreview.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update each platform preview
                    $.each(response.data, function(platform, html) {
                        $('#og-preview-elementor-panel .og-preview-platform[data-platform="' + platform + '"]').html(html);
                    });
                }
            },
            error: function() {
                // Only log errors when WordPress debug mode is enabled
                if (ogPreview.debug) {
                    console.error('OG Preview: Failed to refresh preview');
                }
            }
        });
    }
    
})(jQuery);
