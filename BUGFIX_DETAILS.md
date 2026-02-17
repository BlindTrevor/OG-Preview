# Bug Fix: OG Description Showing CSS/JavaScript Code

## Issue Summary

**Problem:** The OG preview description was displaying CSS styles and JavaScript code instead of clean text content.

**Example:**
- **Before:** "The Shindig Sisters... a { text-decoration: none; color: #464feb; } tr th, tr td { border: 1px solid..."
- **After:** "The Shindig Sisters... Get ready for smooth harmonies and soulful vibes..."

## Root Cause

The `get_og_description()` method in `class-og-preview-core.php` was using PHP's `strip_tags()` function to remove HTML tags from post content. However, `strip_tags()` only removes the tag markup itself, not the content within certain tags like `<style>`, `<script>`, and `<head>`.

When a page had inline CSS or JavaScript, the code inside these tags would remain in the text after `strip_tags()` was applied, resulting in CSS/JS appearing in the social media preview description.

## Solution

### Primary Fix
Added a new `clean_content_for_description()` method that uses WordPress's built-in `wp_strip_all_tags()` function, which:
- Properly handles `<style>` and `<script>` tags
- Removes tag contents before stripping HTML
- Is maintained by WordPress core team
- Handles edge cases robustly

### Fallback Implementation
For environments where WordPress functions aren't available, implemented a regex-based fallback that:
- Uses non-greedy regex patterns (`.*?`) to avoid catastrophic backtracking
- Removes `<style>`, `<script>`, and `<head>` tags and their contents
- Strips remaining HTML tags
- Normalizes whitespace

### Code Changes

**File:** `includes/class-og-preview-core.php`

**Method Updated:** `get_og_description()`
- Changed from: `wp_trim_words(strip_tags($post->post_content), 30)`
- Changed to: `wp_trim_words($this->clean_content_for_description($post->post_content), 30)`

**New Method:** `clean_content_for_description()`
```php
private function clean_content_for_description($content) {
    // Use WordPress's wp_strip_all_tags which handles script/style tags properly
    if (function_exists('wp_strip_all_tags')) {
        $content = wp_strip_all_tags($content, true);
    } else {
        // Fallback regex implementation
        $content = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $content);
        $content = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $content);
        $content = preg_replace('/<head[^>]*>.*?<\/head>/is', '', $content);
        $content = strip_tags($content);
    }
    
    // Remove excessive whitespace
    $content = preg_replace('/\s+/', ' ', $content);
    
    return trim($content);
}
```

## Testing

Created two comprehensive test files:

1. **test-description-cleaning.php** - Tests the cleaning logic with various HTML/CSS/JS content
2. **test-problem-statement.php** - Tests the exact problem scenario from the issue

Both tests verify:
- ✓ CSS is removed from descriptions
- ✓ JavaScript is removed from descriptions
- ✓ Head/meta tags are removed
- ✓ Actual content is preserved
- ✓ The issue is completely fixed

## Security Considerations

- Uses WordPress core function `wp_strip_all_tags()` as primary approach (safer, maintained)
- Fallback regex uses non-greedy matching to prevent ReDoS attacks
- No user input directly used in regex patterns
- All output is still properly escaped in templates

## Performance Impact

- Minimal impact: only adds one function call to existing content processing
- `wp_strip_all_tags()` is optimized by WordPress core team
- Fallback regex uses non-greedy patterns for better performance
- Only runs when generating descriptions (not on every page load)

## Backward Compatibility

- No breaking changes
- Works with all existing WordPress installations (5.0+)
- Maintains existing behavior for content without style/script tags
- Enhances behavior for content with embedded CSS/JS

## Verification

Run the test files to verify the fix:
```bash
php tests/test-description-cleaning.php
php tests/test-problem-statement.php
```

Both should output "All tests PASSED!" or "Issue FIXED!"

## References

- WordPress Codex: [wp_strip_all_tags()](https://developer.wordpress.org/reference/functions/wp_strip_all_tags/)
- PHP Manual: [preg_replace()](https://www.php.net/manual/en/function.preg-replace.php)
- Issue: OG Preview showing CSS/JavaScript in descriptions
