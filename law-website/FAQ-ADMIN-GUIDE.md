# FAQ Section - WordPress Admin Guide

## 📍 How to Access FAQ Settings

### Step-by-Step Navigation

```
WordPress Dashboard
    ↓
Appearance (in left sidebar)
    ↓
Customize
    ↓
FAQ Section (in the customizer panel)
```

---

## 🖥️ What You'll See

### FAQ Section Panel

When you click "FAQ Section" in the Customizer, you'll see:

#### 1. FAQ Items (Repeater Field)
```
┌─────────────────────────────────────┐
│ FAQ Items                           │
│ Add, edit, or remove FAQ items      │
│                                     │
│ ┌─────────────────────────────────┐ │
│ │ FAQ #1              [Remove]    │ │
│ │                                 │ │
│ │ Question:                       │ │
│ │ [Text input field]              │ │
│ │                                 │ │
│ │ Answer:                         │ │
│ │ [Textarea field]                │ │
│ └─────────────────────────────────┘ │
│                                     │
│ ┌─────────────────────────────────┐ │
│ │ FAQ #2              [Remove]    │ │
│ │ ...                             │ │
│ └─────────────────────────────────┘ │
│                                     │
│ [Add FAQ] button                    │
└─────────────────────────────────────┘
```

#### 2. Statistics Fields
```
┌─────────────────────────────────────┐
│ Cases Won - Number                  │
│ [500]                               │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│ Cases Won - Label                   │
│ [Cases Won]                         │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│ Attorneys - Number                  │
│ [50]                                │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│ Attorneys - Label                   │
│ [Expert Attorneys]                  │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│ Practice Areas - Number             │
│ [25]                                │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│ Practice Areas - Label              │
│ [Practice Areas]                    │
└─────────────────────────────────────┘
```

---

## 📝 Common Tasks

### Task 1: Add a New FAQ

1. Scroll to "FAQ Items" section
2. Click the blue **"Add FAQ"** button at the bottom
3. A new FAQ box will appear
4. Fill in:
   - **Question:** Type your question
   - **Answer:** Type the answer
5. Click **"Publish"** at the top

**Example:**
```
Question: What are your office hours?
Answer: We are open Monday to Friday, 9 AM to 6 PM, and Saturday 9 AM to 2 PM.
```

### Task 2: Edit an Existing FAQ

1. Find the FAQ you want to edit
2. Click in the Question or Answer field
3. Make your changes
4. Click **"Publish"** at the top

### Task 3: Remove an FAQ

1. Find the FAQ you want to delete
2. Click the red **"Remove"** button in the top-right of that FAQ box
3. The FAQ will disappear immediately
4. Click **"Publish"** to save

### Task 4: Reorder FAQs

Currently, FAQs appear in the order they're added. To reorder:

1. Note the content of the FAQ you want to move
2. Remove it using the "Remove" button
3. Add it back in the desired position using "Add FAQ"
4. Enter the content again
5. Click **"Publish"**

*Note: Drag-and-drop reordering can be added in a future update*

### Task 5: Update Statistics

1. Scroll to the statistics fields
2. Update the numbers (e.g., change 500 to 600)
3. Update the labels if needed (e.g., change "Cases Won" to "Successful Cases")
4. Click **"Publish"**

**Important:** 
- Enter numbers without commas (✅ 1000, ❌ 1,000)
- The "+" symbol is added automatically

---

## 🎨 Preview Your Changes

The WordPress Customizer shows a live preview on the right side:

```
┌──────────────┬────────────────────────┐
│              │                        │
│  Settings    │    Live Preview        │
│  Panel       │    of Homepage         │
│              │                        │
│  [FAQ Items] │    ┌────────────────┐  │
│  [Stats]     │    │ Your FAQ       │  │
│              │    │ Section Here   │  │
│  [Publish]   │    └────────────────┘  │
│              │                        │
└──────────────┴────────────────────────┘
```

- Changes appear in real-time in the preview
- Scroll down in the preview to see the FAQ section
- Click "Publish" only when you're happy with the changes

---

## ⚠️ Important Notes

### Before Publishing
- ✅ Review all changes in the preview
- ✅ Check for typos
- ✅ Ensure all questions have answers
- ✅ Verify statistics numbers are correct

### After Publishing
- ✅ Visit your homepage to confirm changes
- ✅ Test the FAQ accordion (click to expand)
- ✅ Check on mobile devices
- ✅ Clear cache if using a caching plugin

### Best Practices
- ✅ Keep questions clear and concise
- ✅ Keep answers informative but brief (2-3 sentences)
- ✅ Use proper grammar and punctuation
- ✅ Update statistics regularly to reflect current data
- ✅ Order FAQs from most to least common questions

---

## 🔍 Troubleshooting

### "I don't see the FAQ Section in Customizer"
**Solution:**
1. Make sure you're using the correct theme
2. Check that `inc/customizer.php` file exists
3. Try refreshing the Customizer page

### "Changes aren't showing on the homepage"
**Solution:**
1. Make sure you clicked "Publish" (not just "Save Draft")
2. Clear your browser cache (Ctrl+F5 or Cmd+Shift+R)
3. If using a caching plugin, clear that cache too
4. Try viewing in an incognito/private browser window

### "FAQ accordion isn't working"
**Solution:**
1. Check browser console for JavaScript errors (F12)
2. Make sure jQuery is loaded
3. Try disabling other plugins temporarily to check for conflicts

### "Statistics counter isn't animating"
**Solution:**
1. Scroll down to the statistics section slowly
2. The animation triggers when the section comes into view
3. Check browser console for errors
4. Try refreshing the page

---

## 📱 Mobile Editing

You can edit FAQ settings from mobile devices:

1. Access WordPress Dashboard on mobile
2. Navigate to Appearance → Customize
3. Tap "FAQ Section"
4. Edit fields (may need to zoom in)
5. Tap "Publish"

**Tip:** For extensive editing, desktop is recommended for easier typing.

---

## 💾 Backup Recommendation

Before making major changes:

1. **Take a screenshot** of your current FAQ settings
2. **Copy the text** of all FAQs to a document
3. **Note down** your current statistics

This way, you can easily restore if needed.

---

## 🎓 Training New Users

To train someone else to edit FAQs:

1. Show them how to access: **Appearance → Customize → FAQ Section**
2. Demonstrate adding a new FAQ
3. Show them how to edit existing FAQs
4. Explain the "Publish" button
5. Show them the live preview feature
6. Give them this guide for reference

---

## 📞 Need More Help?

- **Quick Reference:** See `FAQ-QUICK-START.md`
- **Technical Details:** See `FAQ-SECTION-DOCUMENTATION.md`
- **Implementation Info:** See `FAQ-IMPLEMENTATION-SUMMARY.md`

---

**Last Updated:** March 14, 2026
**For:** Genius Law and Associates WordPress Theme
**Difficulty Level:** Beginner-Friendly ✅
