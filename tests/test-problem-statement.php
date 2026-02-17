<?php
/**
 * Test with the exact problem statement example
 */

// Test content that matches the problem description
$test_content = '
The Shindig Sisters Our Amazing Backing Group The Shindig Sisters
<style>
a { text-decoration: none; color: #464feb; }
tr th, tr td { border: 1px solid #e6e6e6; }
tr th { background: #f5f5f5; }
</style>
Get ready for smooth harmonies and soulful vibes with The Shindig Sisters, 
the sensational backing vocalists of The Summer Shindig! Led by the brilliant
Marjory, this talented trio perfectly complements the main act, blending their voices.
';

// Simulate the cleaning process
function clean_content($content) {
    // Remove style tags and their contents
    $content = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $content);
    
    // Remove script tags and their contents
    $content = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $content);
    
    // Remove head tags and their contents
    $content = preg_replace('/<head\b[^>]*>.*?<\/head>/is', '', $content);
    
    // Strip remaining HTML tags
    $content = strip_tags($content);
    
    // Remove excessive whitespace
    $content = preg_replace('/\s+/', ' ', $content);
    
    // Trim
    $content = trim($content);
    
    return $content;
}

// Simulate wp_trim_words (simplified version)
function trim_words($text, $num_words = 30) {
    $words = preg_split('/\s+/', $text);
    if (count($words) > $num_words) {
        $words = array_slice($words, 0, $num_words);
        $text = implode(' ', $words) . '…';
    } else {
        $text = implode(' ', $words);
    }
    return $text;
}

echo "=== Problem Statement Test ===\n\n";

echo "BEFORE fix (strip_tags only):\n";
$before = trim_words(strip_tags($test_content), 30);
echo $before . "\n\n";

echo "AFTER fix (with clean_content):\n";
$after = trim_words(clean_content($test_content), 30);
echo $after . "\n\n";

// Check if the issue is fixed
$has_css_before = strpos($before, 'text-decoration') !== false || strpos($before, '#464feb') !== false;
$has_css_after = strpos($after, 'text-decoration') !== false || strpos($after, '#464feb') !== false;
$has_good_content_after = strpos($after, 'Get ready for smooth harmonies') !== false;

echo "Results:\n";
echo "- CSS in BEFORE version: " . ($has_css_before ? "YES (this is the problem)" : "NO") . "\n";
echo "- CSS in AFTER version: " . ($has_css_after ? "YES (still broken)" : "NO (FIXED!)") . "\n";
echo "- Good content in AFTER: " . ($has_good_content_after ? "YES ✓" : "NO") . "\n";

if (!$has_css_after && $has_good_content_after) {
    echo "\n✓ Issue FIXED! CSS is removed and content is preserved.\n";
} else {
    echo "\n❌ Issue NOT fixed.\n";
}
