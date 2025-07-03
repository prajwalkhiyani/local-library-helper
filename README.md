# Project Title

Local Library Helper

## Description

A custom WordPress plugin for small-town library to showcase a "Book of the Week" using a widget or shortcode — with a admin panel, media uploader, and responsive design.

## Dependencies

* WordPress 5.0+
* PHP 7.4 or higher
* Theme that supports widgets and shortcodes(used Twenty Twenty-One Version: 2.5)
* Local Library Helper Shortcode plugin require Local Library Helper plugin to work

## Installing

* Download or clone the plugin
* Upload the folders to:
  1. wp-content/plugins/local-library-helper
  2. wp-content/plugins/local-library-helper-shortcode
* Activate the plugin from WordPress Dashboard → Plugins

## How to Use

### Add via Widget

* Go to Appearance → Widgets
* Add the "Book of the Week" widget to any sidebar
* Content is automatically pulled from the global settings panel(Settings -> Local Library Helper)


### Add via Shortcode

* Use this shortcode in any page, post, or block:  [book_of_the_week]

### Update Book Details
* Go to **Settings → Local Library Helper**
* Fill in:
   - Book Title
   - Author
   - Short Review
   - Cover Image (select from Media Library)
   - Reserve Link (optional)
* Click **Save Changes**

Changes reflect instantly across both widget and shortcode displays.


##  Customization

Edit `wp-content\plugins\local-library-helper\llh-widget.php` to adjust colors, fonts, layout, or spacing for widgets,
Edit `wp-content\plugins\local-library-helper-shortcode\assets\llh-shortcode-style.css` to adjust colors, fonts, layout, or spacing for shortcode.

## Folder Structure
Widget

* **local-library-helper/**
* ├── assets/
* │ ├── llh-style.css
* │ └── llh-admin-media.js
* ├── llh-widget.php
* ├── local-library-helper.php

Shortcode
* local-library-helper-shortcode/
* ├── assets/
* │   └── llh-shortcode-style.css      
* ├── local-library-helper-shortcode.php  

by Prajwal Khiyani

## Version History
* 1.0
    * Initial Release

## License
This plugin is licensed under the GPL.

