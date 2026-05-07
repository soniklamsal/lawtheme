# Pro Bono Page Setup Guide

## Overview
The Pro Bono page template now uses **custom WordPress meta boxes** instead of ACF. No plugins required!

## How to Use

### 1. Create a Pro Bono Page
1. Go to **Pages > Add New** in WordPress admin
2. Give your page a title (e.g., "Pro Bono Services")
3. In the **Page Attributes** box on the right, select **Template: Pro Bono Page**
4. Publish the page

### 2. Edit Pro Bono Content
After selecting the Pro Bono Page template, you'll see **5 new meta boxes** below the content editor:

#### Meta Box 1: Pro Bono - Hero Section
- Badge Text (e.g., "Pro Bono Legal Support")
- Hero Title
- Hero Subtitle
- Background Image URL (optional - enter full URL)
- Primary Button Text & Link
- Secondary Button Text & Link

#### Meta Box 2: Pro Bono - Case Documents
- Section Title
- Section Description
- **Add Document** button to add case documents
  - Case Title
  - File URL (enter full URL to PDF, DOC, etc.)
  - Optional Note
  - Behavior (Both/Open/Download)

#### Meta Box 3: Pro Bono - Intro Section
- Section Title
- Description (WYSIWYG editor)

#### Meta Box 4: Pro Bono - Eligibility Section
- Section Title
- Section Description
- **Add Item** button to add eligibility criteria
  - Title
  - Description

#### Meta Box 5: Pro Bono - FAQ Section
- Section Title
- Section Description
- **Add FAQ** button to add questions
  - Question
  - Answer

### 3. Save Your Changes
Click **Update** or **Publish** to save all your Pro Bono content.

## Features

✅ **No ACF Plugin Required** - Uses native WordPress meta boxes
✅ **Fully Dynamic** - All content editable from dashboard
✅ **Repeater Fields** - Add unlimited documents, eligibility items, and FAQs
✅ **Background Image Support** - Optional hero background image
✅ **Document Management** - Upload and manage legal documents with View/Download options
✅ **Responsive Design** - Mobile-friendly layout
✅ **Fallback Content** - Shows default content if fields are empty

## Document Behavior Options

- **Both (View & Download)** - Shows both buttons (recommended)
- **Open in new tab** - Opens document in browser
- **Download file** - Forces download

## Tips

1. **Background Image**: Enter the full URL (e.g., `https://yoursite.com/wp-content/uploads/2024/image.jpg`)
2. **File URLs**: Upload files to Media Library first, then copy the file URL
3. **Remove Items**: Click the "Remove" button on any document, eligibility item, or FAQ
4. **Reorder**: Items appear in the order you add them

## Files Modified

- `law-website/inc/probono-meta-boxes.php` (NEW - meta box registration)
- `law-website/templates/template-probono.php` (UPDATED - uses custom meta)
- `law-website/functions.php` (UPDATED - includes meta boxes file)

## Support

If meta boxes don't appear:
1. Make sure you've selected "Pro Bono Page" template
2. Save/update the page
3. Refresh the page editor
4. Check that `inc/probono-meta-boxes.php` exists
