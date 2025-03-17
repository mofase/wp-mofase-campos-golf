<?php

class Golf_Course_Manager {
    public function __construct() {
        add_action('init', [$this, 'create_golf_course_post_type']);
    }

    public function create_golf_course_post_type() {
        register_post_type('campo_de_golf',
            array(
                'labels' => array(
                    'name' => __('Campos de Golf'),
                    'singular_name' => __('Campo de Golf')
                ),
                'public' => true,
                'has_archive' => true,
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
                'rewrite' => array('slug' => 'campos-de-golf'),
            )
        );
    }
}