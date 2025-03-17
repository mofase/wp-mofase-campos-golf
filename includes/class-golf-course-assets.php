<?php

class Golf_Course_Assets {
    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
    }

    public function enqueue_admin_assets($hook_suffix) {
        if ('post.php' !== $hook_suffix && 'post-new.php' !== $hook_suffix && 'edit-tags.php' !== $hook_suffix && 'term.php' !== $hook_suffix) {
            return;
        }
        wp_enqueue_media();
        wp_enqueue_script('golf_course_gallery', plugin_dir_url(__FILE__) . '../assets/js/gallery.js', array('jquery'), null, true);
        wp_enqueue_script('leaflet_js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), null, true);
        wp_enqueue_style('leaflet_css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
        wp_enqueue_script('taxonomy_image', plugin_dir_url(__FILE__) . '../assets/js/taxonomy-image.js', array('jquery'), null, true);
    }

    public function enqueue_frontend_assets() {
        if (is_singular('campo_de_golf') || is_post_type_archive('campo_de_golf')) {
            wp_enqueue_script('leaflet_js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), null, true);
            wp_enqueue_style('leaflet_css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
            wp_enqueue_script('lightbox_js', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js', array('jquery'), null, true);
            wp_enqueue_style('lightbox_css', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css');
            wp_enqueue_script('golf_course_ranking', plugin_dir_url(__FILE__) . '../assets/js/ranking.js', array('jquery'), null, true);
            wp_localize_script('golf_course_ranking', 'golfCourseRanking', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'post_id' => get_the_ID()
            ));
        }
    }
}