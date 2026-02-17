# GitHub Actions Workflows

## Version Bump and Release Workflow

This workflow automatically handles version bumping and release creation for the OG Preview WordPress plugin.

### What it does

When code is pushed to the `main` branch, the workflow:

1. **Extracts the current version** from `og-preview.php`
2. **Increments the patch version** (e.g., 1.0.1 → 1.0.2)
3. **Checks for duplicate releases** to prevent creating the same version twice
4. **Updates version numbers** in:
   - `og-preview.php` (plugin header comment)
   - `og-preview.php` (OG_PREVIEW_VERSION constant)
   - `readme.txt` (Stable tag)
5. **Creates a release zip file** containing the plugin files
6. **Stores the zip** in the `Releases/` directory with the format: `OG Preview X.Y.Z.zip`
7. **Commits and pushes** the version changes and release zip back to the repository

### Files included in the release zip

The release zip includes all WordPress plugin files:
- `og-preview.php` (main plugin file)
- `readme.txt` (WordPress plugin readme)
- `includes/` (PHP class files)
- `assets/` (CSS, JavaScript, and screenshots)
- `languages/` (internationalization files)

The following files are excluded from the release:
- `.git/` and `.github/` (version control)
- `Releases/` (to avoid nested releases)
- `.gitignore` (development file)
- `*.md` files (documentation like README.md)
- `tests/` (test files)
- Development artifacts

### Workflow triggers

The workflow runs on:
- **Push to `main` branch**
- Skips execution if the push was made by `github-actions[bot]` to prevent infinite loops

### Preventing infinite loops

The workflow automatically commits version changes back to the repository. To prevent it from triggering itself infinitely, it checks if the commit author is `github-actions[bot]` and skips execution if true.

### Preventing duplicate releases

The workflow checks if a release zip for the new version already exists before creating it. If it exists, the workflow skips the release creation steps.

### Manual version bumping

If you need to bump to a specific version (not just patch):
1. Manually update the version in `og-preview.php` and `readme.txt`
2. Push to `main` branch
3. The workflow will detect the new version and create a release zip
