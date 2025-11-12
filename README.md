# WPSoft Library WordPress Theme

This repository contains the **WPSoft Library** theme, a custom WordPress theme inspired by [xu5.cc](http://www.xu5.cc). The theme is tailored for building a software library + tutorial + resource navigation website.

## Features

- Custom `software` post type with platform and software category taxonomies.
- Meta fields for software version, tutorial URL, and multiple download links.
- Responsive front page highlighting top-level software categories and versions.
- Software detail pages with download buttons grouped by platform and tutorial links.
- Enhanced search experience covering software meta fields, with instant suggestions powered by a REST endpoint.
- Breadcrumb navigation, SEO-friendly titles, and footer links to sitemap resources.
- Ready-to-style layout components that mirror the xu5.cc aesthetic.

## Getting Started

1. Copy the `wpsoft-theme` directory into your WordPress installation’s `wp-content/themes/` folder.
2. Activate **WPSoft Library** from the WordPress admin appearance panel.
3. Visit **Settings → Permalinks** and click “Save Changes” to register the custom post type routes.
4. Add platform terms (Windows, Mac, Android) under **Software → Platforms** and create software categories.
5. Create software posts, filling in version information, tutorial links, and download endpoints.
6. Set the Front page to use a static page assigned to the “Front Page” template (or leave as default to use the theme’s front-page template).

## Development Notes

- Download links in the editor accept the format `Label|https://example.com`. Each entry renders as a button.
- Search suggestions fetch results from `/wp-json/wpsoft/v1/search?q=keyword`.
- Styles live in `assets/css/main.css`, and JavaScript enhancements in `assets/js/main.js`.

Feel free to extend the theme with additional templates or integrate with plugins for analytics, caching, or SEO.
