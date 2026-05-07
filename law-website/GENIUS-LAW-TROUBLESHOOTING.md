# Genius Law Section - Troubleshooting Guide

## Section Not Showing After Saving?

Try these steps in order:

### 1. Clear WordPress Cache
If you're using a caching plugin (WP Super Cache, W3 Total Cache, etc.):
- Go to the plugin settings
- Click "Clear All Cache" or "Purge Cache"
- Refresh your homepage

### 2. Clear Browser Cache
- **Chrome/Edge**: Press `Ctrl + Shift + Delete` (Windows) or `Cmd + Shift + Delete` (Mac)
- **Or**: Press `Ctrl + F5` (Windows) or `Cmd + Shift + R` (Mac) to hard refresh
- **Or**: Open homepage in Incognito/Private window

### 3. Check if Section is Active
1. Go to Dashboard → **Genius Law**
2. Make sure the checkbox **"Show this section on the homepage"** is CHECKED
3. Click **"Save Genius Law Section"**
4. Refresh homepage

### 4. Verify Content is Saved
1. Go to Dashboard → **Genius Law**
2. Check if your content is still there in the fields
3. If fields are empty, re-enter your content
4. Click **"Save Genius Law Section"**

### 5. Check Page Template
1. Go to **Pages** → **Home** (or your front page)
2. Make sure the page template is set correctly
3. Or check **Settings** → **Reading** → Make sure "Front page displays" is set to show your homepage

### 6. Disable Other Plugins Temporarily
Sometimes plugins conflict:
1. Go to **Plugins**
2. Deactivate all plugins except essential ones
3. Check if section appears
4. Reactivate plugins one by one to find the conflict

### 7. Check Theme
1. Make sure you're using the **LawFirm Pro** theme
2. Go to **Appearance** → **Themes**
3. Verify the active theme

### 8. View Page Source
1. Visit your homepage
2. Right-click → **View Page Source**
3. Search for "About Genius Law" or "geniuslaw"
4. If you find it, the section is loading but might have CSS issues
5. If you don't find it, there's a PHP issue

## Still Not Working?

### Enable Debug Mode
Add these lines to your `wp-config.php` file (before "That's all, stop editing!"):

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

Then check the debug log at: `wp-content/debug.log`

### Check File Permissions
Make sure these files exist and are readable:
- `law-website/template-parts/home-about-geniuslaw.php`
- `law-website/functions.php`
- `law-website/front-page.php`

### Manual Check
Add this temporary code to your `front-page.php` right after the Featured Services line:

```php
<!-- Featured Services Section -->
<?php get_template_part( 'template-parts/home', 'featured-services' ); ?>

<!-- DEBUG: Check if template file exists -->
<?php 
$template_file = get_template_directory() . '/template-parts/home-about-geniuslaw.php';
if ( file_exists( $template_file ) ) {
    echo '<!-- Genius Law template file exists -->';
} else {
    echo '<!-- ERROR: Genius Law template file NOT FOUND -->';
}
?>

<!-- About Genius Law Section (Dynamic) -->
<?php get_template_part( 'template-parts/home', 'about-geniuslaw' ); ?>
```

Then view page source and look for the debug comment.

## Common Issues

### Issue: "Show this section" is unchecked
**Solution**: Check the box and save

### Issue: Title field is empty
**Solution**: Enter a title (required field)

### Issue: Using a child theme
**Solution**: Copy the template file to your child theme's `template-parts` folder

### Issue: Caching plugin is aggressive
**Solution**: Exclude the homepage from caching or clear cache after every change

### Issue: Theme not activated
**Solution**: Go to Appearance → Themes and activate LawFirm Pro

## Quick Test

To quickly test if the system is working, try this:

1. Go to Dashboard → **Genius Law**
2. Change the title to: **"TEST - About Genius Law"**
3. Click **"Save Genius Law Section"**
4. Open homepage in Incognito window
5. If you see "TEST - About Genius Law", it's working!
6. Change title back to normal

## Need More Help?

If none of these work:
1. Check the WordPress error log
2. Contact your hosting provider
3. Reach out to your developer
4. Check if there are any PHP errors in the browser console (F12)
