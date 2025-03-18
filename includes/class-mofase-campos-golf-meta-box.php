<?php
class Mofase_Campos_Golf_Box {
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    public function add_meta_boxes() {
        add_meta_box('golf_course_details', 'Detalles del Campo de Golf', array($this, 'render_meta_box'), 'campo_de_golf', 'normal', 'high');
    }

    public function render_meta_box($post) {
        wp_nonce_field('save_golf_course_details', 'golf_course_details_nonce');
        $fields = [
            'resumen' => 'wysiwyg',
            'descripcion' => 'wysiwyg',
            'detalles_del_campo' => 'wysiwyg',
            'descripcion_hoyo_a_hoyo' => 'wysiwyg',
            'servicios_y_comodidades' => 'wysiwyg',
            'datos_de_contacto' => 'wysiwyg',
            'ubicacion_gps' => 'text',
            'autonomia' => 'dropdown',
            'provincia' => 'dropdown',
            'galeria_de_imagenes' => 'gallery',
            'imagen_destacada' => 'image'
        ];

        foreach ($fields as $field => $type) {
            $value = get_post_meta($post->ID, $field, true);
            echo '<label for="'.$field.'">'.ucwords(str_replace('_', ' ', $field)).'</label>';
            if ($type === 'wysiwyg') {
                wp_editor($value, $field);
            } elseif ($type === 'text') {
                echo '<input type="text" id="'.$field.'" name="'.$field.'" value="'.esc_attr($value).'"/><br/>';
            } elseif ($type === 'dropdown') {
                if ($field === 'autonomia') {
                    wp_dropdown_categories(array(
                        'taxonomy' => 'autonomia',
                        'name' => $field,
                        'selected' => $value,
                    ));
                } elseif ($field === 'provincia') {
                    wp_dropdown_categories(array(
                        'taxonomy' => 'provincia',
                        'name' => $field,
                        'selected' => $value,
                    ));
                }
            } elseif ($type === 'gallery') {
                echo '<input type="button" id="'.$field.'_button" class="button" value="Añadir galería de imágenes"/><br/>';
                echo '<input type="hidden" id="'.$field.'" name="'.$field.'" value="'.esc_attr($value).'"/>';
                echo '<div id="'.$field.'_preview"></div>';
            } elseif ($type === 'image') {
                $image_id = get_post_meta($post->ID, $field, true);
                echo wp_get_attachment_image($image_id, 'thumbnail');
                echo '<button type="button" class="button" id="upload_'.$field.'_button">Subir Imagen</button>';
            }
        }
    }

    public function save_meta_boxes($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['golf_course_summary'])) {
            update_post_meta($post_id, 'golf_course_summary', wp_kses_post($_POST['golf_course_summary']));
        }

        if (isset($_POST['golf_course_description'])) {
            update_post_meta($post_id, 'golf_course_description', wp_kses_post($_POST['golf_course_description']));
        }

        if (isset($_POST['golf_course_details'])) {
            update_post_meta($post_id, 'golf_course_details', wp_kses_post($_POST['golf_course_details']));
        }

        if (isset($_POST['golf_course_hole_by_hole'])) {
            update_post_meta($post_id, 'golf_course_hole_by_hole', wp_kses_post($_POST['golf_course_hole_by_hole']));
        }

        if (isset($_POST['golf_course_services'])) {
            update_post_meta($post_id, 'golf_course_services', wp_kses_post($_POST['golf_course_services']));
        }

        if (isset($_POST['golf_course_contact'])) {
            update_post_meta($post_id, 'golf_course_contact', wp_kses_post($_POST['golf_course_contact']));
        }

        if (isset($_POST['golf_course_gps'])) {
            update_post_meta($post_id, 'golf_course_gps', sanitize_text_field($_POST['golf_course_gps']));
        }

        if (isset($_POST['golf_course_autonomia'])) {
            update_post_meta($post_id, 'golf_course_autonomia', sanitize_text_field($_POST['golf_course_autonomia']));
        }

        if (isset($_POST['golf_course_provincia'])) {
            update_post_meta($post_id, 'golf_course_provincia', sanitize_text_field($_POST['golf_course_provincia']));
        }

        if (isset($_POST['golf_course_gallery'])) {
            update_post_meta($post_id, 'golf_course_gallery', sanitize_text_field($_POST['golf_course_gallery']));
        }

        if (isset($_POST['golf_course_featured_image'])) {
            update_post_meta($post_id, 'golf_course_featured_image', sanitize_text_field($_POST['golf_course_featured_image']));
        }

        if (isset($_POST['golf_course_ranking'])) {
            update_post_meta($post_id, 'golf_course_ranking', sanitize_text_field($_POST['golf_course_ranking']));
        }

        if (isset($_POST['golf_course_generated_text_ai'])) {
            update_post_meta($post_id, 'golf_course_generated_text_ai', sanitize_text_field($_POST['golf_course_generated_text_ai']));
        }
    }
}
?>