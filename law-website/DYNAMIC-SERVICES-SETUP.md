# Dynamic Featured & Popular Services - Complete Setup

## ✅ What Was Implemented

### 1. **Checkbox Custom Fields**
**File:** `inc/custom-post-types.php`

Added two checkbox fields in a new "Display Options" meta box (sidebar):
- ✅ **Featured Legal Service** - Display in Featured section
- ✅ **Popular Legal Service** - Display in Popular section

**Location:** Right sidebar when editing a Legal Service post

### 2. **Dynamic Featured Services Template**
**File:** `template-parts/home-featured-services.php`

- Queries all Legal Services with `is_featured_service = 1`
- Uses WP_Query with meta_query
- Identical card design to category pages
- Horizontal scroll with left/right buttons
- Auto-hides if no featured services exist

### 3. **Dynamic Popular Services Template**
**File:** `template-parts/home-popular-services.php`

- Queries all Legal Services with `is_popular_service = 1`
- Uses WP_Query with meta_query
- Identical card design to category pages
- Horizontal scroll with left/right buttons
- Auto-hides if no popular services exist

## 📋 How to Use

### Step 1: Edit a Legal Service
1. Go to **Dashboard → Legal Services**
2. Click on any service or create a new one

### Step 2: Set Display Options
In the right sidebar, you'll see **"Display Options"** meta box:

```
☐ Featured Legal Service
  Display in Featured Legal Services section on homepage

☐ Popular Legal Service
  Display in Popular Legal Services section on homepage
```

### Step 3: Check the Boxes
- ✅ Check **Featured Legal Service** to show in Featured section
- ✅ Check **Popular Legal Service** to show in Popular section
- You can check both, one, or neither

### Step 4: Publish/Update
Click **Publish** or **Update** button

### Step 5: View Homepage
The service will automatically appear in the respective section(s)!

## 🎨 Card Design Features

Each card displays:
- ✅ Service Featured Image (or default)
- ✅ Service Title
- ✅ Provider Name with verification badge
- ✅ Star Rating
- ✅ Review Count
- ✅ Service Excerpt (description)
- ✅ Hover effects (image zoom, title color change)
- ✅ Responsive layout
- ✅ Links to single service page

## 🔄 Automatic Updates

The sections update automatically when:
- ✅ You check/uncheck the Featured checkbox
- ✅ You check/uncheck the Popular checkbox
- ✅ You add a new Legal Service with checkboxes
- ✅ You delete a Legal Service
- ✅ You change service details (title, image, rating, etc.)

## 📊 Query Details

### Featured Services Query:
```php
'post_type'      => 'legal_service',
'posts_per_page' => -1,
'meta_query'     => array(
    array(
        'key'     => 'is_featured_service',
        'value'   => '1',
        'compare' => '='
    )
)
```

### Popular Services Query:
```php
'post_type'      => 'legal_service',
'posts_per_page' => -1,
'meta_query'     => array(
    array(
        'key'     => 'is_popular_service',
        'value'   => '1',
        'compare' => '='
    )
)
```

## 🎯 Section Behavior

- **If NO services are marked as Featured:** Featured section won't display
- **If NO services are marked as Popular:** Popular section won't display
- **If services exist:** Section displays with horizontal scroll
- **Scroll buttons:** Appear on desktop (hidden on mobile)

## 🔧 Technical Details

### Meta Keys:
- `is_featured_service` - Stores '1' if checked, deleted if unchecked
- `is_popular_service` - Stores '1' if checked, deleted if unchecked

### Service Meta Fields (existing):
- `provider_name` - Default: 'Genius Law'
- `service_rating` - Default: '4.9'
- `review_count` - Default: '0'

### Fallback Image:
If no featured image: `https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=400`

## 📁 Files Modified/Created

### Modified:
- `inc/custom-post-types.php` - Added checkbox fields and save logic

### Created:
- `template-parts/home-featured-services.php` - Dynamic featured section
- `template-parts/home-popular-services.php` - Dynamic popular section

### Not Modified:
- All other homepage sections remain untouched
- No CSS changes
- No JavaScript changes (uses existing scroll functionality)

## ✨ Features

- ✅ No ACF plugin required (uses native WordPress meta fields)
- ✅ Fully dynamic from WordPress dashboard
- ✅ Identical card design to category pages
- ✅ Proper sanitization (esc_html, esc_url, esc_attr)
- ✅ WordPress best practices (WP_Query, wp_reset_postdata)
- ✅ Responsive design
- ✅ Horizontal scroll with buttons
- ✅ Auto-hide when empty
- ✅ Clean, modular code

## 🚀 Next Steps

1. **Add Services:** Create Legal Service posts
2. **Set Featured Image:** Upload an image for each service
3. **Fill Service Details:** Provider, Rating, Reviews
4. **Check Display Options:** Mark as Featured and/or Popular
5. **View Homepage:** See your services appear automatically!

## 💡 Tips

- A service can be both Featured AND Popular
- Services appear in order of publication date (newest first)
- Change `'posts_per_page' => -1` to a number to limit display
- Uncheck boxes to remove from sections instantly
- No need to clear cache - updates are immediate

---

**System is ready to use!** Just check the boxes in the Legal Service editor sidebar.
