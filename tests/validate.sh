#!/bin/bash
# OG Preview Plugin - Basic Validation Tests

echo "======================================"
echo "OG Preview Plugin - Validation Tests"
echo "======================================"
echo ""

# Change to plugin root directory
cd "$(dirname "$0")/.."

# Test 1: Check PHP syntax
echo "Test 1: Checking PHP syntax..."
php_errors=0
for file in $(find . -name "*.php" -type f ! -path "./.git/*"); do
    if ! php -l "$file" > /dev/null 2>&1; then
        echo "  ❌ Syntax error in: $file"
        php_errors=$((php_errors + 1))
    fi
done

if [ $php_errors -eq 0 ]; then
    echo "  ✓ All PHP files have valid syntax"
else
    echo "  ❌ Found $php_errors file(s) with syntax errors"
fi
echo ""

# Test 2: Check required files exist
echo "Test 2: Checking required files..."
required_files=(
    "og-preview.php"
    "includes/class-og-preview-core.php"
    "includes/class-og-preview-admin.php"
    "includes/class-og-preview-metabox.php"
    "includes/class-og-preview-elementor.php"
    "assets/css/admin.css"
    "assets/css/elementor.css"
    "assets/js/admin.js"
    "assets/js/elementor.js"
    "README.md"
)

missing_files=0
for file in "${required_files[@]}"; do
    if [ ! -f "$file" ]; then
        echo "  ❌ Missing required file: $file"
        missing_files=$((missing_files + 1))
    fi
done

if [ $missing_files -eq 0 ]; then
    echo "  ✓ All required files present"
else
    echo "  ❌ Missing $missing_files required file(s)"
fi
echo ""

# Test 3: Check for plugin header
echo "Test 3: Checking plugin header..."
if grep -q "Plugin Name:" og-preview.php; then
    echo "  ✓ Plugin header found"
else
    echo "  ❌ Plugin header not found"
fi
echo ""

# Test 4: Check for class definitions
echo "Test 4: Checking class definitions..."
classes=(
    "OG_Preview_Core"
    "OG_Preview_Admin"
    "OG_Preview_Metabox"
    "OG_Preview_Elementor"
)

missing_classes=0
for class in "${classes[@]}"; do
    if ! grep -rq "class $class" includes/; then
        echo "  ❌ Class not found: $class"
        missing_classes=$((missing_classes + 1))
    fi
done

if [ $missing_classes -eq 0 ]; then
    echo "  ✓ All required classes defined"
else
    echo "  ❌ Missing $missing_classes class(es)"
fi
echo ""

# Test 5: Check for WordPress hooks
echo "Test 5: Checking WordPress hooks..."
hooks=(
    "add_action"
    "add_filter"
    "add_meta_box"
)

missing_hooks=0
for hook in "${hooks[@]}"; do
    if ! grep -rq "$hook" . --include="*.php"; then
        echo "  ❌ Hook not found: $hook"
        missing_hooks=$((missing_hooks + 1))
    fi
done

if [ $missing_hooks -eq 0 ]; then
    echo "  ✓ WordPress hooks properly used"
else
    echo "  ❌ Missing $missing_hooks hook(s)"
fi
echo ""

# Test 6: Check for security best practices
echo "Test 6: Checking security best practices..."
security_checks=(
    "ABSPATH"
    "esc_html"
    "esc_url"
    "esc_attr"
)

missing_security=0
for check in "${security_checks[@]}"; do
    if ! grep -rq "$check" . --include="*.php"; then
        echo "  ⚠ Security function not used: $check"
        missing_security=$((missing_security + 1))
    fi
done

if [ $missing_security -eq 0 ]; then
    echo "  ✓ Security best practices followed"
else
    echo "  ⚠ Some security functions not found (this may be ok)"
fi
echo ""

# Summary
echo "======================================"
echo "Summary:"
echo "======================================"
total_errors=$((php_errors + missing_files + missing_classes + missing_hooks))

if [ $total_errors -eq 0 ]; then
    echo "✓ All validation tests passed!"
    echo "The plugin appears to be correctly structured."
else
    echo "❌ Found $total_errors issue(s)"
    echo "Please review the errors above."
fi
echo ""
