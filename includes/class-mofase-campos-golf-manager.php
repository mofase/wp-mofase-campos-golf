<?php
class Mofase_Campos_Golf_Manager {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
    }

    public function register_post_type() {
        $labels = array(
            'name' => __('Campos de Golf', 'wp-mofase-campos-golf'),
            'singular_name' => __('Campo de Golf', 'wp-mofase-campos-golf'),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'rewrite' => array('slug' => 'campos_de_golf'),
        );

        register_post_type('campo_de_golf', $args);
    }
}
?>