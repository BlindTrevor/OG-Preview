/**
 * OG Preview Admin JavaScript
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Initialize tabs
        initTabs();
        
        // Refresh button click
        $('.og-preview-refresh-btn').on('click', function(e) {
            e.preventDefault();
            refreshPreview();
        });
        
        // Auto-refresh on title/content changes (debounced)
        var refreshTimeout;
        $('#title, #content').on('input', function() {
            clearTimeout(refreshTimeout);
            refreshTimeout = setTimeout(function() {
                refreshPreview();
            }, 2000);
        });
        
        // Watch for featured image changes using MutationObserver
        // This ensures the preview updates when the featured image is actually set/changed
        var featuredImageObserver = null;
        var postImageDiv = document.getElementById('postimagediv');
        
        if (postImageDiv) {
            featuredImageObserver = new MutationObserver(function(mutations) {
                var shouldRefresh = false;
                
                mutations.forEach(function(mutation) {
                    // Check if the thumbnail was added, removed, or changed
                    if (mutation.type === 'childList' || mutation.type === 'attributes') {
                        shouldRefresh = true;
                    }
                });
                
                if (shouldRefresh) {
                    // Add a small delay to ensure the thumbnail ID is saved
                    clearTimeout(refreshTimeout);
                    refreshTimeout = setTimeout(function() {
                        refreshPreview();
                    }, 1000);
                }
            });
            
            // Observe changes to the featured image container
            featuredImageObserver.observe(postImageDiv, {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['class']
            });
        }
    });
    
    /**
     * Initialize tabs
     */
    function initTabs() {
        var $tabs = $('.og-preview-tab');
        var $platforms = $('.og-preview-platform');
        
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
                $('.og-preview-platform[data-platform="' + platform + '"]').addClass('active');
            });
        }
    }
    
    /**
     * Refresh preview via AJAX
     */
    function refreshPreview() {
        var postId = $('#og-preview-post-id').val();
        
        if (!postId) {
            return;
        }
        
        var $container = $('.og-preview-content');
        $container.addClass('og-preview-loading');
        
        $.ajax({
            url: ogPreview.ajax_url,
            type: 'POST',
            data: {
                action: 'og_preview_get_preview',
                post_id: postId,
                nonce: ogPreview.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update each platform preview
                    $.each(response.data, function(platform, html) {
                        $('.og-preview-platform[data-platform="' + platform + '"]').html(html);
                    });
                }
            },
            error: function() {
                // Only log errors when WordPress debug mode is enabled
                if (ogPreview.debug) {
                    console.error('OG Preview: Failed to refresh preview');
                }
            },
            complete: function() {
                $container.removeClass('og-preview-loading');
            }
        });
    }
    
})(jQuery);
