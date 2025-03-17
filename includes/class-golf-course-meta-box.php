<?php

class Golf_Course_Meta_Box {
    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_meta_boxes']);
        add_action('save_post', [$this, 'set_default_agregado_texto_ia'], 10, 3);
    }

    public function add_meta_boxes() {
        add_meta_box('golf_course_details', 'Detalles del Campo de Golf', [$this, 'meta_box_callback'], 'campo_de_golf');
    }

    public function meta_box_callback($post) {
        wp_nonce_field('save_golf_course_details', 'golf_course_details_nonce');
        $fields = [
            'resumen' => 'wysiwyg',
            'descripcion' => 'wysiwyg',
            'detalles_del_campo' => 'wysiwyg',
            'descripcion_hoyo_a_hoyo' => 'wysiwyg',
            'servicios_y_comodidades' => 'wysiwyg',
            'datos_de_contacto' => 'wysiwyg',
            'ubicacion_gps' => 'text',
            'galeria_de_imagenes' => 'gallery',
            'ranking' => 'number',
            'agregado_texto_ia' => 'text'
        ];

        foreach ($fields as $field => $type) {
            $value = get_post_meta($post->ID, $field, true);
            echo '<label for="'.$field.'">'.ucwords(str_replace('_', ' ', $field)).'</label>';
            if ($type === 'wysiwyg') {
                wp_editor($value, $field);
            } elseif ($type === 'text') {
                echo '<input type="text" id="'.$field.'" name="'.$field.'" value="'.esc_attr($value).'"/><br/>';
            } elseif ($type === 'gallery') {
                echo '<input type="button" id="'.$field.'_button" class="button" value="Añadir galería de imágenes"/><br/>';
                echo '<input type="hidden" id="'.$field.'" name="'.$field.'" value="'.esc_attr($value).'"/>';
                echo '<div id="'.$field.'_preview"></div>';
            } elseif ($type === 'number') {
                echo '<input type="number" id="'.$field.'" name="'.$field.'" value="'.esc_attr($value).'" min="1" max="5"/><br/>';
            }
        }
    }

    public function save_meta_boxes($post_id) {
        if (!isset($_POST['golf_course_details_nonce']) || !wp_verify_nonce($_POST['golf_course_details_nonce'], 'save_golf_course_details')) {
            return;
        }

        $fields = [
            'resumen', 'descripcion', 'detalles_del_campo', 'descripcion_hoyo_a_hoyo',
            'servicios_y_comodidades', 'datos_de_contacto', 'ubicacion_gps', 'galeria_de_imagenes', 'ranking', 'agregado_texto_ia'
        ];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                if ($field === 'galeria_de_imagenes') {
                    update_post_meta($post_id, $field, esc_attr($_POST[$field]));
                } else {
                    update_post_meta($post_id, sanitize_text_field($_POST[$field]));
                }
            }
        }
    }

    public function set_default_agregado_texto_ia($post_id, $post, $update) {
        if ($post->post_type == 'campo_de_golf') {
            if (!get_post_meta($post_id, 'agregado_texto_ia', true)) {
                update_post_meta($post_id, 'agregado_texto_ia', 'no');
            }
        }
    }
}