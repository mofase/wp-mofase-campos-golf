<?php
class Mofase_Campos_Golf_Assets {
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    public function enqueue_assets() {
        wp_enqueue_style('golf-courses-styles', plugin_dir_url(__FILE__) . '../assets/css/styles.css');
        wp_enqueue_script('golf-courses-frontend', plugin_dir_url(__FILE__) . '../assets/js/frontend.js', array('jquery'), null, true);
    }

    public function enqueue_admin_assets() {
        wp_enqueue_style('golf-courses-admin-styles', plugin_dir_url(__FILE__) . '../assets/css/admin-styles.css');
        wp_enqueue_script('golf-courses-admin', plugin_dir_url(__FILE__) . '../assets/js/admin.js', array('jquery'), null, true);
    }
}
?>