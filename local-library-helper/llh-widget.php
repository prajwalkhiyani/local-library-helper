<?php
class LLH_Book_Widget extends WP_Widget {

    // Constructor
    public function __construct() {
        parent::__construct(
            'llh_book_widget', // Base ID
            'Book of the Week', // Name in admin
            array('description' => __('Displays the Book of the Week.', 'text_domain'))
        );
    }

    // Frontend display
    public function widget($args, $instance) {
    echo $args['before_widget'];

    $settings = get_option('llh_book_data');
    $title  = esc_html($settings['title'] ?? '');
    $author = esc_html($settings['author'] ?? '');
    $review = esc_html($settings['review'] ?? '');
    $cover  = esc_url($settings['cover'] ?? '');
    $link   = esc_url($settings['link'] ?? '');

    echo '<div class="llh-book-widget-main">';
    echo '<div class="llh-book-widget">';

    if (!empty($cover)) {
        echo '<div class="llh-book-right"><img src="' . esc_url($cover) . '" alt="' . esc_attr($title) . ' cover" /></div>';
    }

    echo '<div class="llh-book-left">';

    if (!empty($title)) {
        echo '<h3>' . esc_html($title) . '</h3>';
    }
    if (!empty($author)) {
        echo '<p><strong>Author:</strong> ' . esc_html($author) . '</p>';
    }
    if (!empty($review)) {
        echo '<p>' . esc_html($review) . '</p>';
    }
    if (!empty($link)) {
        echo '<a class="llh-reserve-button" href="' . esc_url($link) . '" target="_blank">Reserve Now</a>';
    }

    echo '</div>'; // .llh-book-left
    echo '</div>'; // .llh-book-widget
    echo '</div>'; // .llh-book-widget-main

    echo $args['after_widget'];
}


    // Backend form in admin
    public function form($instance) {
        $title  = $instance['title'] ?? '';
        $author = $instance['author'] ?? '';
        $review = $instance['review'] ?? '';
        $cover  = $instance['cover'] ?? '';
        $link   = $instance['link'] ?? '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Book Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('author'); ?>">Author:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('author'); ?>"
                   name="<?php echo $this->get_field_name('author'); ?>" type="text"
                   value="<?php echo esc_attr($author); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('review'); ?>">Review:</label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('review'); ?>"
                      name="<?php echo $this->get_field_name('review'); ?>"><?php echo esc_textarea($review); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cover'); ?>">Cover Image URL:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('cover'); ?>"
                   name="<?php echo $this->get_field_name('cover'); ?>" type="text"
                   value="<?php echo esc_url($cover); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('link'); ?>">Reserve Link:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>"
                   name="<?php echo $this->get_field_name('link'); ?>" type="text"
                   value="<?php echo esc_url($link); ?>" />
        </p>
        <?php
    }

    // Save widget form values
    public function update($new_instance, $old_instance) {
        return array(
            'title'  => sanitize_text_field($new_instance['title']),
            'author' => sanitize_text_field($new_instance['author']),
            'review' => sanitize_text_field($new_instance['review']),
            'cover'  => esc_url_raw($new_instance['cover']),
            'link'   => esc_url_raw($new_instance['link']),
        );
    }
}

// Register the widget
function register_llh_book_widget() {
    register_widget('LLH_Book_Widget');
}
add_action('widgets_init', 'register_llh_book_widget');
?>