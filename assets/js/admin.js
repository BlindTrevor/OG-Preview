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
        
        // Auto-refresh when featured image changes
        $(document).on('click', '#set-post-thumbnail', function() {
            setTimeout(function() {
                refreshPreview();
            }, 500);
        });
        
        // Auto-refresh when featured image is removed
        $(document).on('click', '#remove-post-thumbnail', function() {
            setTimeout(function() {
                refreshPreview();
            }, 500);
        });
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
                console.error('Failed to refresh OG preview');
            },
            complete: function() {
                $container.removeClass('og-preview-loading');
            }
        });
    }
    
})(jQuery);
