<?php
/*
Plugin Name: Local Library Helper Shortcode
Description: Displays Book of the Week via shortcode [book_of_the_week]
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit;
}

// Enqueue styles
function llh_enqueue_shortcode_styles_v2() {
 {
    wp_enqueue_style(
        'llh-shortcode-style',
        plugin_dir_url(__FILE__) . 'assets/llh-shortcode-style.css'
    );
}
}
add_action('wp_enqueue_scripts', 'llh_enqueue_shortcode_styles_v2');

// Shortcode function
function llh_book_shortcode_output() {
    $settings = get_option('llh_book_data');
    if (!$settings || empty($settings['title'])) {
        return ''; // Don’t show anything if not filled
    }

    ob_start(); ?>
<div class = 'llh-book-widget-main'>
    <div class="llh-book-widget">
        <div class="llh-book-left">
            <h3 ><?php echo esc_html($settings['title']); ?></h3>
            <?php if (!empty($settings['author'])): ?>
                <p><strong>Author:</strong> <?php echo esc_html($settings['author']); ?></p>
            <?php endif; ?>
            <?php if (!empty($settings['review'])): ?>
                <p><?php echo esc_html($settings['review']); ?></p>
            <?php endif; ?>
            <?php if (!empty($settings['link'])): ?>
                <a href="<?php echo esc_url($settings['link']); ?>" class="llh-reserve-button" target="_blank">Send Me a Sample!</a>
            <?php endif; ?>
        </div>
        <div class="llh-book-right">
            <?php if (!empty($settings['cover'])): ?>
                <img src="<?php echo esc_url($settings['cover']); ?>" alt="<?php echo esc_attr($settings['title']); ?>" />
            <?php endif; ?>
        </div>
    </div>
</div>
    <?php
    return ob_get_clean();
}
add_shortcode('book_of_the_week', 'llh_book_shortcode_output');

