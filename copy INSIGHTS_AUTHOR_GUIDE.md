<!-- # Insights Post Type - Author Management Guide

## Overview
You can now easily manage and select authors for Insight posts. The system supports:
- ✅ Selecting which author a post belongs to
- ✅ Editing the author anytime
- ✅ Displaying author information on details pages
- ✅ Filtering posts by author

---

## How to Select/Edit Author

### Method 1: WordPress Native Author Box (Recommended)
When editing an Insight post, you'll see the **Author** box in the right sidebar:

1. Open an Insight post for editing
2. Look for the **Author** section in the right sidebar
3. Click on the author name to see a dropdown list of all users
4. Select the desired author
5. Publish/Update the post

**Note:** This is the standard WordPress author selector and is the primary way to set authors.

### Method 2: Carbon Fields Author Selection (Secondary)
In the editor, you'll also see an **"Insight Details"** meta box with **"Select Author"** field:

1. Open an Insight post for editing
2. Scroll down to find **"Insight Details"** section
3. Click on **"Select Author"** field
4. Search and select the author from the dropdown
5. Publish/Update the post

**Note:** This field is automatically synced with the WordPress author field. When you select an author here, it updates the post's main author.

---

## Where Author Information Appears

### On Insight Details Page
- **Author Box**: Shows author avatar, name, and bio
- **Author Posts Section**: Shows 3 latest posts from this author
- **Clickable Author Link**: Clicking the author name shows all their posts

### On Archive/Listing Page
- **Author Card**: Each insight card shows:
  - Author avatar
  - Author name (clickable)
  - Posts by this author can be filtered by clicking the author name

### Author Archive Page
- URL: `/insights/?author=X`
- Shows all posts by a specific author
- Filterable and paginated

---

## Author Sync Behavior

The system automatically syncs the Carbon Fields author selection with the WordPress post author:

- When you select an author using either method, both fields update
- The post's main author is used for:
  - Author archive pages
  - Author byline display
  - Author filtering
  - Related posts by author

---

## Managing User/Author Information

### Add Author Bio
1. Go to **WordPress Admin > Users**
2. Click on the user to edit
3. Scroll down to **"About the Author"** / **"Biographical Info"**
4. Add a description (this appears on insight details pages)
5. Click **Update Profile**

### User Profile Picture (Avatar)
WordPress uses Gravatar by default. To set a custom avatar:

1. Go to **Plugins** and search for "Custom Avatar" or similar
2. Or use the built-in Gravatar system
3. The avatar appears on insight cards and details pages

---

## Admin Display

### In Insights List
- Go to **All Insights** in WordPress admin
- The **Author** column shows who is assigned to each post
- Click the author name to see all posts by that author

### Quick Edit
1. Hover over an insight in the list
2. Click **Quick Edit**
3. Change the author if needed
4. Click **Update**

---

## Filtering Posts by Author

### In Admin
- Go to **All Insights**
- Use the **Author** filter dropdown at the top

### On Frontend
- Visit `/insights/`
- Click any author name on an insight card
- Shows all posts by that author

---

## Tips & Best Practices

✅ **Do:**
- Always assign an author to every insight post
- Keep author bio information up to date
- Use consistent author names

❌ **Don't:**
- Leave author field empty
- Assign multiple authors (system only supports one per post)
- Delete user accounts with published insights (orphans the posts)

---

## Troubleshooting

### Author Not Saving?
1. Check if you have permission to edit posts (must be Editor or Admin)
2. Try refreshing the page
3. Check browser console for errors (F12 > Console)

### Author Avatar Not Showing?
1. Make sure the user has a Gravatar set up
2. Or install a custom avatar plugin
3. Check that the user profile is complete

### Can't Find Author in Dropdown?
1. Make sure the user account exists in WordPress
2. Go to Users > Add New to create a new user
3. Make sure user has an email address set

---

## Advanced: Accessing Author Data

In templates, author information is accessed via:

```php
// Get post author ID
$author_id = get_the_author_meta('ID');

// Get author name
$author_name = get_the_author_meta('display_name', $author_id);

// Get author bio
$author_bio = get_the_author_meta('description', $author_id);

// Get author avatar
echo get_avatar($author_id, 120);

// Get author posts URL
$author_url = get_author_posts_url($author_id);
```

---

## Related Documentation

- [WordPress Author Support](https://developer.wordpress.org/plugins/users/)
- [Carbon Fields Documentation](https://carbonfields.net/docs/)
- See `INSIGHTS_GUIDE.md` for complete insights system documentation -->
