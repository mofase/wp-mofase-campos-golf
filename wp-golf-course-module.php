<?php
/*
Plugin Name: Golf Course Manager
Description: Plugin to manage golf course information and integrate with Astra Theme.
Version: 1.5
Author: Your Name
*/

// Register Custom Post Type
function create_golf_course_post_type() {
    register_post_type('campo_de_golf',
        array(
            'labels' => array(
                'name' => __('Campos de Golf'),
                'singular_name' => __('Campo de Golf')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'), // Ensure 'thumbnail' is included
            'rewrite' => array('slug' => 'campos-de-golf'),
        )
    );
}
add_action('init', 'create_golf_course_post_type');

// Add Custom Fields
function add_golf_course_meta_boxes() {
    add_meta_box('golf_course_details', 'Detalles del Campo de Golf', 'golf_course_meta_box_callback', 'campo_de_golf');
}
add_action('add_meta_boxes', 'add_golf_course_meta_boxes');

function golf_course_meta_box_callback($post) {
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

function save_golf_course_details($post_id) {
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
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
add_action('save_post', 'save_golf_course_details');

// Set default value for agregado_texto_ia
function set_default_agregado_texto_ia($post_id, $post, $update) {
    if ($post->post_type == 'campo_de_golf') {
        if (!get_post_meta($post_id, 'agregado_texto_ia', true)) {
            update_post_meta($post_id, 'agregado_texto_ia', 'no');
        }
    }
}
add_action('save_post', 'set_default_agregado_texto_ia', 10, 3);

// Custom Templates
function load_golf_course_templates($template) {
    if (is_singular('campo_de_golf')) {
        $template = plugin_dir_path(__FILE__) . 'single-campo_de_golf.php';
    } elseif (is_post_type_archive('campo_de_golf')) {
        $template = plugin_dir_path(__FILE__) . 'archive-campo_de_golf.php';
    }
    return $template;
}
add_filter('template_include', 'load_golf_course_templates');

// Taxonomy for Autonomia and Provincia
function create_golf_course_taxonomies() {
    register_taxonomy('autonomia', 'campo_de_golf', array(
        'labels' => array(
            'name' => 'Autonomias',
            'singular_name' => 'Autonomia'
        ),
        'hierarchical' => true,
        'rewrite' => array('slug' => 'autonomia')
    ));
    register_taxonomy('provincia', 'campo_de_golf', array(
        'labels' => array(
            'name' => 'Provincias',
            'singular_name' => 'Provincia'
        ),
        'hierarchical' => true,
        'rewrite' => array('slug' => 'provincia')
    ));
}
add_action('init', 'create_golf_course_taxonomies');

// Add image field to taxonomies
function add_taxonomy_image_field($taxonomy) {
    ?>
    <div class="form-field term-group">
        <label for="taxonomy-image-id"><?php _e('Image', 'text_domain'); ?></label>
        <input type="hidden" id="taxonomy-image-id" name="taxonomy-image-id" class="custom_media_url" value="">
        <div id="taxonomy-image-wrapper"></div>
        <p>
            <input type="button" class="button button-secondary taxonomy-media-button" id="taxonomy-media-button" name="taxonomy-media-button" value="<?php _e('Add Image', 'text_domain'); ?>" />
            <input type="button" class="button button-secondary taxonomy-media-remove" id="taxonomy-media-remove" name="taxonomy-media-remove" value="<?php _e('Remove Image', 'text_domain'); ?>" />
        </p>
    </div>
    <?php
}
add_action('autonomia_add_form_fields', 'add_taxonomy_image_field', 10, 2);
add_action('provincia_add_form_fields', 'add_taxonomy_image_field', 10, 2);

function edit_taxonomy_image_field($term, $taxonomy) {
    $image_id = get_term_meta($term->term_id, 'taxonomy-image-id', true);
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="taxonomy-image-id"><?php _e('Image', 'text_domain'); ?></label>
        </th>
        <td>
            <input type="hidden" id="taxonomy-image-id" name="taxonomy-image-id" value="<?php echo $image_id; ?>">
            <div id="taxonomy-image-wrapper">
                <?php if ($image_id) { ?>
                    <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                <?php } ?>
            </div>
            <p>
                <input type="button" class="button button-secondary taxonomy-media-button" id="taxonomy-media-button" name="taxonomy-media-button" value="<?php _e('Add Image', 'text_domain'); ?>" />
                <input type="button" class="button button-secondary taxonomy-media-remove" id="taxonomy-media-remove" name="taxonomy-media-remove" value="<?php _e('Remove Image', 'text_domain'); ?>" />
            </p>
        </td>
    </tr>
    <?php
}
add_action('autonomia_edit_form_fields', 'edit_taxonomy_image_field', 10, 2);
add_action('provincia_edit_form_fields', 'edit_taxonomy_image_field', 10, 2);

function save_taxonomy_image($term_id, $tt_id) {
    if (isset($_POST['taxonomy-image-id']) && '' !== $_POST['taxonomy-image-id']) {
        $image = sanitize_text_field($_POST['taxonomy-image-id']);
        update_term_meta($term_id, 'taxonomy-image-id', $image);
    } else {
        delete_term_meta($term_id, 'taxonomy-image-id');
    }
}
add_action('created_autonomia', 'save_taxonomy_image', 10, 2);
add_action('edited_autonomia', 'save_taxonomy_image', 10, 2);
add_action('created_provincia', 'save_taxonomy_image', 10, 2);
add_action('edited_provincia', 'save_taxonomy_image', 10, 2);

// Enqueue Scripts for Gallery, Lightbox, Map, and Taxonomy Image
function enqueue_golf_course_scripts($hook_suffix) {
    if ('post.php' !== $hook_suffix && 'post-new.php' !== $hook_suffix && 'edit-tags.php' !== $hook_suffix && 'term.php' !== $hook_suffix) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('golf_course_gallery', plugin_dir_url(__FILE__) . 'js/gallery.js', array('jquery'), null, true);
    wp_enqueue_script('leaflet_js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), null, true);
    wp_enqueue_style('leaflet_css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
    wp_enqueue_script('taxonomy_image', plugin_dir_url(__FILE__) . 'js/taxonomy-image.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_golf_course_scripts');

function enqueue_golf_course_frontend_scripts() {
    if (is_singular('campo_de_golf') || is_post_type_archive('campo_de_golf')) {
        wp_enqueue_script('leaflet_js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), null, true);
        wp_enqueue_style('leaflet_css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
        wp_enqueue_script('lightbox_js', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js', array('jquery'), null, true);
        wp_enqueue_style('lightbox_css', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css');
        wp_enqueue_script('golf_course_ranking', plugin_dir_url(__FILE__) . 'js/ranking.js', array('jquery'), null, true);
        wp_localize_script('golf_course_ranking', 'golfCourseRanking', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'post_id' => get_the_ID()
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_golf_course_frontend_scripts');

// Ajax handler for ranking
function handle_golf_course_ranking() {
    if (!isset($_POST['post_id']) || !isset($_POST['ranking'])) {
        wp_send_json_error('Missing parameters.');
    }
    $post_id = intval($_POST['post_id']);
    $ranking = intval($_POST['ranking']);
    if ($ranking < 1 || $ranking > 5) {
        wp_send_json_error('Invalid ranking.');
    }
    // Update the ranking meta
    update_post_meta($post_id, 'ranking', $ranking);
    wp_send_json_success('Ranking updated.');
}
add_action('wp_ajax_golf_course_ranking', 'handle_golf_course_ranking');
add_action('wp_ajax_nopriv_golf_course_ranking', 'handle_golf_course_ranking');