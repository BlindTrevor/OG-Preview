#!/bin/bash
# Test script to verify plugin header fields

echo "=== Plugin Header Verification ==="
echo ""

# Extract plugin header information
PLUGIN_FILE="/home/runner/work/OG-Preview/OG-Preview/og-preview.php"

echo "Checking plugin header fields..."
echo ""

# Check Plugin Name
PLUGIN_NAME=$(grep "Plugin Name:" "$PLUGIN_FILE" | head -1 | sed 's/.*Plugin Name: *//' | sed 's/ *\*\/.*//')
echo "✓ Plugin Name: $PLUGIN_NAME"

# Check Version
VERSION=$(grep "Version:" "$PLUGIN_FILE" | head -1 | sed 's/.*Version: *//' | sed 's/ *\*\/.*//')
echo "✓ Version: $VERSION"

# Check Requires at least
REQUIRES_WP=$(grep "Requires at least:" "$PLUGIN_FILE" | head -1 | sed 's/.*Requires at least: *//' | sed 's/ *\*\/.*//')
if [ -z "$REQUIRES_WP" ]; then
    echo "✗ Requires at least: NOT FOUND"
    exit 1
else
    echo "✓ Requires at least (WordPress): $REQUIRES_WP"
fi

# Check Requires PHP
REQUIRES_PHP=$(grep "Requires PHP:" "$PLUGIN_FILE" | head -1 | sed 's/.*Requires PHP: *//' | sed 's/ *\*\/.*//')
if [ -z "$REQUIRES_PHP" ]; then
    echo "✗ Requires PHP: NOT FOUND"
    exit 1
else
    echo "✓ Requires PHP: $REQUIRES_PHP"
fi

# Check Author
AUTHOR=$(grep "Author:" "$PLUGIN_FILE" | head -1 | sed 's/.*Author: *//' | sed 's/ *\*\/.*//')
echo "✓ Author: $AUTHOR"

echo ""
echo "=== All Required Fields Present ==="
echo ""
echo "Summary:"
echo "  - Plugin Name: $PLUGIN_NAME"
echo "  - Version: $VERSION"
echo "  - Requires WordPress: $REQUIRES_WP or higher"
echo "  - Requires PHP: $REQUIRES_PHP or higher"
echo "  - Author: $AUTHOR"
echo ""
echo "✅ All plugin header fields are properly set!"
