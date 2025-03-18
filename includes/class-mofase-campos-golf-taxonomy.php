<?php
class Mofase_Campos_Golf_Taxonomy {
    public function __construct() {
        add_action('init', array($this, 'register_taxonomies'));
    }

    public function register_taxonomies() {
        // Register Autonomias taxonomy
        $labels = array(
            'name' => __('Autonomías', 'wp-mofase-campos-golf'),
            'singular_name' => __('Autonomía', 'wp-mofase-campos-golf'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'rewrite' => array('slug' => 'autonomias'),
        );

        register_taxonomy('autonomia', 'golf_course', $args);

        // Register Provincias taxonomy
        $labels = array(
            'name' => __('Provincias', 'wp-mofase-campos-golf'),
            'singular_name' => __('Provincia', 'wp-mofase-campos-golf'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'rewrite' => array('slug' => 'provincias'),
        );

        register_taxonomy('provincia', 'golf_course', $args);
    }
}
?>