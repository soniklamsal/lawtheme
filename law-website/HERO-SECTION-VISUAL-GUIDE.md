# Hero Section Restructure - Visual Guide

## 📊 Customizer Structure

### BEFORE
```
WordPress Customizer
├── Site Identity
│   ├── Logo
│   ├── Site Title
│   └── Logo Size Controls
├── Hero Section ← Standalone
│   ├── Hero Title
│   ├── Hero Subtitle
│   ├── Button Text
│   └── Button URL
├── Contact Information
│   ├── Phone
│   ├── Email
│   └── Address
└── FAQ Section ← Standalone
    ├── FAQ Items
    └── Statistics
```

### AFTER
```
WordPress Customizer
├── Site Identity
│   ├── Logo
│   ├── Site Title
│   └── Logo Size Controls
├── Homepage Sections ← NEW PANEL
│   ├── Hero Section ← Moved here
│   │   ├── Hero Title
│   │   ├── Hero Subtitle
│   │   ├── Button Text
│   │   └── Button URL
│   └── FAQ Section ← Moved here
│       ├── FAQ Items
│       └── Statistics
└── Contact Information
    ├── Phone
    ├── Email
    └── Address
```

## 🏠 Homepage Layout

### BEFORE
```
┌─────────────────────────────────┐
│      1. HERO SECTION            │ ← Was here
│   "Find Your Legal Expert"      │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   2. Browse by Practice Area    │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   3. Featured Services          │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   4. Popular Services           │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   5. AMC Packages               │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   6. Testimonials               │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   7. FAQ Section                │
└─────────────────────────────────┘
```

### AFTER
```
┌─────────────────────────────────┐
│   1. Browse by Practice Area    │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   2. Featured Services          │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   3. Popular Services           │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│      4. HERO SECTION            │ ← Now here
│   "Find Your Legal Expert"      │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   5. AMC Packages               │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   6. Testimonials               │
└─────────────────────────────────┘
┌─────────────────────────────────┐
│   7. FAQ Section                │
└─────────────────────────────────┘
```

## 🔄 User Journey

### BEFORE
```
User lands → Hero CTA → Browse services
```

### AFTER
```
User lands → Browse services → See options → Hero CTA
```

**Benefit:** Users see what's available before being prompted to act

## 📱 Navigation Path

### To Edit Hero Section

```
WordPress Dashboard
    ↓
Appearance
    ↓
Customize
    ↓
Homepage Sections (Panel)
    ↓
Hero Section
    ↓
Edit Settings
    ↓
Publish
```

## 🎨 What Stayed the Same

```
Hero Section Template
├── HTML Structure ✅ Same
├── TailwindCSS Classes ✅ Same
├── Background Image ✅ Same
├── Text Styling ✅ Same
├── Button Design ✅ Same
└── Responsive Behavior ✅ Same
```

## 💾 Data Flow

```
WordPress Options Table
    ↓
theme_mod('hero_title')
theme_mod('hero_subtitle')
theme_mod('hero_button_text')
theme_mod('hero_button_url')
    ↓
Template: home-hero.php
    ↓
Display on Homepage (Position 4)
```

**Note:** All data storage remains unchanged

---

**Visual Guide Version:** 1.0
**Last Updated:** March 14, 2026
