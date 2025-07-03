<?php
/*
Plugin Name: Local Library Helper
Description: A widget that displays the Book of the Week for the local library.
Version: 1.0
Author: Prajwal Khiyani
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
// Add Work Sans Web Font
function llh_enqueue_google_fonts() {
    wp_enqueue_style(
        'llh-google-fonts',
        'https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'llh_enqueue_google_fonts');


// CSS to the frontend only when needed old
// function llh_enqueue_frontend_styles() {
//     global $post;

//     $should_enqueue = false;

//     if (is_active_widget(false, false, 'llh_book_widget', true)) {
//         $should_enqueue = true;
//     }

//     if (!$should_enqueue && is_singular() && isset($post) && has_shortcode($post->post_content, 'book_of_the_week')) {
//         $should_enqueue = true;
//     }

//     if ($should_enqueue) {
//         wp_enqueue_style(
//             'llh-style',
//             plugin_dir_url(__FILE__) . 'assets/llh-style.css',
//             array(),
//             filemtime(plugin_dir_path(__FILE__) . 'assets/llh-style.css')
//         );
//     }
// }
// add_action('wp_enqueue_scripts', 'llh_enqueue_frontend_styles');


// CSS to the frontend only when needed (new)
function llh_enqueue_frontend_styles() {
    global $post;

    $should_enqueue = false;

    if (is_active_widget(false, false, 'llh_book_widget', true)) {
        $should_enqueue = true;
    }

    if (!$should_enqueue && is_singular() && isset($post) && has_shortcode($post->post_content, 'book_of_the_week')) {
        $should_enqueue = true;
    }

    if ($should_enqueue) {
        wp_enqueue_style(
            'llh-style',
            plugin_dir_url(__FILE__) . 'assets/llh-style.css',
            array(),
            filemtime(plugin_dir_path(__FILE__) . 'assets/llh-style.css')
        );
    }
}
add_action('wp_enqueue_scripts', 'llh_enqueue_frontend_styles');



// Include the widget code/custom widget 
require_once plugin_dir_path(__FILE__) . 'llh-widget.php';


// Enqueue widget CSS
// function llh_enqueue_widget_styles_conditional() {
//     if ( is_active_widget(false, false, 'llh_book_widget', true) ) {
//         wp_enqueue_style(
//             'llh-widget-style',
//             plugin_dir_url(__FILE__) . 'assets/llh-style.css',
//             array(),
//             filemtime(plugin_dir_path(__FILE__) . 'assets/llh-style.css')
//         );
//     }
// }
// add_action('wp_enqueue_scripts', 'llh_enqueue_widget_styles_conditional');


// Add settings page to admin menu
// Add menu option under Settings in the WordPress admin dashboard

function llh_add_admin_menu() {
    add_options_page(
        'Local Library Helper',
        'Local Library Helper',
        'manage_options',
        'llh-settings',
        'llh_settings_page_html'
    );
}
add_action('admin_menu', 'llh_add_admin_menu');


// Register our settings
function llh_settings_init() {
    register_setting('llh_settings_group', 'llh_book_data');

    add_settings_section(
        'llh_settings_section',
        'Book of the Week Details',
        null,
        'llh-settings'
    );

    // Fields
    add_settings_field('llh_title', 'Book Title', 'llh_field_title', 'llh-settings', 'llh_settings_section');
    add_settings_field('llh_author', 'Author', 'llh_field_author', 'llh-settings', 'llh_settings_section');
    add_settings_field('llh_review', 'Review', 'llh_field_review', 'llh-settings', 'llh_settings_section');
    add_settings_field('llh_cover', 'Cover Image URL', 'llh_field_cover', 'llh-settings', 'llh_settings_section');
    add_settings_field('llh_link', 'Reserve Link', 'llh_field_link', 'llh-settings', 'llh_settings_section');
}
add_action('admin_init', 'llh_settings_init');
 
function llh_field_title() {
    $options = get_option('llh_book_data');
    ?>
    <input type="text" name="llh_book_data[title]" value="<?php echo esc_attr($options['title'] ?? ''); ?>" class="regular-text" />
    <?php
}

function llh_field_author() {
    $options = get_option('llh_book_data');
    ?>
    <input type="text" name="llh_book_data[author]" value="<?php echo esc_attr($options['author'] ?? ''); ?>" class="regular-text" />
    <?php
}

function llh_field_review() {
    $options = get_option('llh_book_data');
    ?>
    <textarea name="llh_book_data[review]" rows="5" cols="50"><?php echo esc_textarea($options['review'] ?? ''); ?></textarea>
    <?php
}

// function llh_field_cover() {
//     $options = get_option('llh_book_data');
//     
//     <input type="text" name="llh_book_data[cover]" value="<?php echo esc_url($options['cover'] ?? ''); " class="regular-text" />


function llh_field_cover() {
    $options = get_option('llh_book_data');
    $cover = esc_url($options['cover'] ?? '');
    ?>
    <input type="text" id="llh_cover" name="llh_book_data[cover]" value="<?php echo $cover; ?>" class="regular-text" />
    <button type="button" class="button" id="llh-cover-upload">Select Image</button><br><br>
    <img id="llh-cover-preview" src="<?php echo $cover; ?>" style="max-width:150px; display: <?php echo $cover ? 'block' : 'none'; ?>;" />
    <?php
}


function llh_field_link() {
    $options = get_option('llh_book_data');
    ?>
    <input type="url" name="llh_book_data[link]" value="<?php echo esc_url($options['link'] ?? ''); ?>" class="regular-text" />
    <?php
}

function llh_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>Local Library Helper Settings</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('llh_settings_group');
            do_settings_sections('llh-settings');
            submit_button('Save Book Info');
            ?>
        </form>
        <br>
        <p> Use shortcode [book_of_the_week] to embed in pages</p>
        <p> Note: Put Local Library Helper Shortcode first</p>
    </div>
    <?php
}
// media upload js
function llh_enqueue_admin_scripts($hook) {
    // Only load on our plugin settings page
    if ($hook === 'settings_page_llh-settings') {
        wp_enqueue_media();
        wp_enqueue_script(
            'llh-admin-media',
            plugin_dir_url(__FILE__) . 'assets/llh-admin-media.js',
            array('jquery'),
            '1.0',
            true
        );
    }
}
add_action('admin_enqueue_scripts', 'llh_enqueue_admin_scripts');


// SHORTCODE FUNCTION
function llh_book_shortcode_output() {
    $settings = get_option('llh_book_data');
    if (!$settings || empty($settings['title'])) {
        return '';
    }
    
// Start buffering
    ob_start(); ?>
    <div class="llh-book-widget-main">
        <div class="llh-book-widget">
            <?php if (!empty($settings['cover'])): ?>
                <div class="llh-book-right">
                    <img src="<?php echo esc_url($settings['cover']); ?>" alt="<?php echo esc_attr($settings['title']); ?>" />
                </div>
            <?php endif; ?>
            <div class="llh-book-left">
                <h3><?php echo esc_html($settings['title']); ?></h3>
                <p><strong>Author:</strong> <?php echo esc_html($settings['author']); ?></p>
                <p><?php echo esc_html($settings['review']); ?></p>
                <?php if (!empty($settings['link'])): ?>
                    <a href="<?php echo esc_url($settings['link']); ?>" class="llh-reserve-button" target="_blank">Reserve Now</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('book_of_the_week', 'llh_book_shortcode_output');




?>