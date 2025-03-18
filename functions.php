<?php
// Registrar el tipo de post personalizado 'campo_golf'
function register_golf_course_post_type() {
    $labels = array(
        'name'               => _x('Campos de Golf', 'post type general name', 'textdomain'),
        'singular_name'      => _x('Campo de Golf', 'post type singular name', 'textdomain'),
        'menu_name'          => _x('Campos de Golf', 'admin menu', 'textdomain'),
        'name_admin_bar'     => _x('Campo de Golf', 'add new on admin bar', 'textdomain'),
        'add_new'            => _x('Añadir Nuevo', 'golf course', 'textdomain'),
        'add_new_item'       => __('Añadir Nuevo Campo de Golf', 'textdomain'),
        'new_item'           => __('Nuevo Campo de Golf', 'textdomain'),
        'edit_item'          => __('Editar Campo de Golf', 'textdomain'),
        'view_item'          => __('Ver Campo de Golf', 'textdomain'),
        'all_items'          => __('Todos los Campos de Golf', 'textdomain'),
        'search_items'       => __('Buscar Campos de Golf', 'textdomain'),
        'parent_item_colon'  => __('Parent Campos de Golf:', 'textdomain'),
        'not_found'          => __('No se encontraron Campos de Golf.', 'textdomain'),
        'not_found_in_trash' => __('No se encontraron Campos de Golf en la basura.', 'textdomain')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'campo_golf'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields')
    );

    register_post_type('campo_golf', $args);
}
add_action('init', 'register_golf_course_post_type');

// Asegurarse de que el template se utilice para el tipo de post personalizado 'campo_golf'
function load_custom_templates($template) {
    global $post;

    if ($post->post_type == 'campo_golf' && $template !== locate_template(array("single-campo_golf.php"))) {
        return plugin_dir_path(__FILE__) . 'templates/single-campo_golf.php';
    }

    return $template;
}
add_filter('single_template', 'load_custom_templates');

// Función para guardar el ranking del campo de golf
function save_golf_course_ranking() {
    if (isset($_POST['post_id']) && isset($_POST['ranking'])) {
        $post_id = intval($_POST['post_id']);
        $ranking = intval($_POST['ranking']);

        update_post_meta($post_id, 'golf_course_ranking', $ranking);

        wp_send_json_success();
    }

    wp_send_json_error();
}
add_action('wp_ajax_save_golf_course_ranking', 'save_golf_course_ranking');
add_action('wp_ajax_nopriv_save_golf_course_ranking', 'save_golf_course_ranking');
?>