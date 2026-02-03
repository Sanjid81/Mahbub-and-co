<!-- # Insights Post Type - Usage Guide

## Overview
This theme now has a fully functional Insights post type with the following features:
- Two default categories: "Insights" and "News and Events"
- Individual insight details pages with author information
- Author-based post filtering
- Custom editable blocks for rich content
- Responsive grid layout for archive/listing pages

---

## Features

### 1. **Two Categories**
When you activate the theme, two default categories are automatically created:
- **Insights**: For thought leadership and articles
- **News and Events**: For news announcements and event updates

You can add more categories in the WordPress admin under **Insights > Categories**.

### 2. **Creating an Insight Post**
1. Go to **All Insights** in the WordPress admin
2. Click **Add New Insight**
3. Fill in:
   - **Title**: Post title
   - **Featured Image**: Cover image for the post (appears on archive and single pages)
   - **Category**: Select "Insights" or "News and Events"
   - **Author**: WordPress will auto-assign to current user
   - **Excerpt**: Short description (appears on archive cards)
   - **Content**: Main article content (can use blocks)

### 3. **Insight Details Page Template**
Each insight has its own dedicated details page at `/insights/{post-slug}/`

The details page includes:
- **Featured Image**: Large hero image at the top
- **Category Badge**: Shows the post category
- **Post Date**: Publication date
- **Title**: Large post title
- **Excerpt**: Highlighted excerpt
- **Author Box**: Author name, avatar, and bio with link to author's posts
- **Main Content**: Full article content with Gutenberg blocks
- **Related Posts**: 3 latest posts from the same author

### 4. **Custom Content Block (Gutenberg)**
The details page can be enhanced with the custom "Insights Content Block" which supports:
- **Rich Text Content**: Main content area
- **Content Sections**: Multiple sections with:
  - Section title
  - Rich text content
  - Optional section image

**How to use:**
1. Edit an Insight post
2. Add the "Insights Content Block" from the Gutenberg block selector
3. Fill in content sections
4. Publish

### 5. **Archive/Listing Page**
Available at `/insights/`

Features:
- **Grid Layout**: Displays posts as cards in a responsive grid
- **Card Components**:
  - Featured image with hover zoom effect
  - Category badge
  - Post title
  - Publication date
  - Author avatar and name (clickable to view author's posts)
  - "Read More" link
- **Pagination**: Automatic pagination for large post lists

### 6. **Author Posts Filtering**
When clicking an author's name (either in the details page or archive card), users are taken to `/insights/?author=X` which shows:
- All posts by that author
- Same card grid layout
- Filtered by author

### 7. **Category Filtering**
Clicking a category badge takes users to `/insights/?insights_category=X` showing:
- All posts in that category
- Same card grid layout
- Filtered by category

---

## File Structure

### PHP Templates
- `single-insights.php` - Main single post template wrapper
- `single-insights-details.php` - Single post details component
- `archive-insights.php` - Archive/listing page template
- `components/insights/insights-grid.php` - Reusable grid component
- `components/insights/insights-content-block.php` - Custom block renderer

### SCSS Styles
- `src/conponents/insights/insights.scss` - All insights styling

### Gutenberg Blocks (in `inc/gutenberg.php`)
- **Insights Content Block** - Custom editable block for details pages

---

## Customization

### Change Default Categories
Edit `inc/insights-post-type.php` - Modify the `create_default_insights_categories()` function:

```php
wp_insert_term('Your Category Name', 'insights_category', array(
    'slug' => 'your-slug',
    'description' => 'Description here'
));
```

### Modify Archive/Listing Page
Edit `archive-insights.php` to change the header or layout.

### Customize Single Post Template
Edit `single-insights-details.php` to modify the author box, related posts section, or layout.

### Change Card Layout
Edit `src/conponents/insights/insights.scss` - Modify `.insights-posts-grid` grid-template-columns for different column counts.

---

## WordPress Dashboard Integration

In the WordPress admin, you'll find:
- **All Insights** - Manage all insight posts
- **Categories** (under Insights) - Manage categories
- **Featured Image Support** - Set cover images
- **Author Support** - Assign authors
- **Excerpt Support** - Add short descriptions
- **Rich Editor** - Full Gutenberg block editor

---

## Template Hierarchy

WordPress looks for templates in this order:
1. `single-insights.php` (for single insight posts)
2. `archive-insights.php` (for `/insights/` page and category archives)
3. `archive-insights.php` (for author archives filtered by post type)

---

## Tips

1. **Always set a featured image** - It's displayed prominently on archive and single pages
2. **Use the excerpt field** - This is shown as a brief description on cards
3. **Assign an author** - Author info appears on single pages and cards
4. **Use categories** - They help organize and filter content
5. **Add author bio** - Go to Users > Edit Profile and fill "Biographical Info" for the author bio
6. **Use the custom block** - For complex multi-section articles, use the "Insights Content Block"

---

## Future Enhancements

Possible additions:
- Search functionality
- Related posts by category
- Comments/discussions
- Share buttons
- Read time estimation
- Tags taxonomy -->
