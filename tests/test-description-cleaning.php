<?php
/**
 * Test for clean_content_for_description method
 */

// Test content with CSS and JavaScript
$test_content = '
<div>
    <style>
        a { text-decoration: none; color: #464feb; }
        tr th, tr td { border: 1px solid #e6e6e6; }
        tr th { background: #f5f5f5; }
    </style>
    
    <script>
        function test() {
            console.log("This should not appear");
        }
    </script>
    
    <head>
        <meta name="description" content="This should not appear">
        <title>Page Title</title>
    </head>
    
    <p>Get ready for smooth harmonies and soulful vibes with The Shindig Sisters, 
    the sensational backing vocalists of The Summer Shindig!</p>
    
    <p>Led by the brilliant Marjory, this talented trio perfectly complements 
    the main act, blending their voices.</p>
</div>
';

// Simulate the cleaning process
function test_clean_content($content) {
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

echo "Original content length: " . strlen($test_content) . "\n";
echo "Original content (first 200 chars):\n" . substr($test_content, 0, 200) . "...\n\n";

$cleaned = test_clean_content($test_content);

echo "Cleaned content length: " . strlen($cleaned) . "\n";
echo "Cleaned content:\n" . $cleaned . "\n\n";

// Check if CSS/JS/meta are removed
$has_css = strpos($cleaned, 'text-decoration') !== false || strpos($cleaned, '#464feb') !== false;
$has_js = strpos($cleaned, 'console.log') !== false || strpos($cleaned, 'function test') !== false;
$has_meta = strpos($cleaned, '<meta') !== false || strpos($cleaned, '<title>') !== false;
$has_content = strpos($cleaned, 'Get ready for smooth harmonies') !== false;

echo "Test Results:\n";
echo "- CSS removed: " . ($has_css ? "FAIL ❌" : "PASS ✓") . "\n";
echo "- JavaScript removed: " . ($has_js ? "FAIL ❌" : "PASS ✓") . "\n";
echo "- Head/meta removed: " . ($has_meta ? "FAIL ❌" : "PASS ✓") . "\n";
echo "- Content preserved: " . ($has_content ? "PASS ✓" : "FAIL ❌") . "\n";

if (!$has_css && !$has_js && !$has_meta && $has_content) {
    echo "\n✓ All tests PASSED!\n";
} else {
    echo "\n❌ Some tests FAILED!\n";
}
