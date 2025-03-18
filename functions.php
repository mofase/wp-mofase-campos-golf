<?php
// Asegurarse de que el template se utilice para el tipo de post personalizado 'golf_course'
function load_custom_templates($template) {
    global $post;

    if ($post->post_type == 'golf_course' && $template !== locate_template(array("single-golf_course.php"))) {
        return plugin_dir_path(__FILE__) . 'templates/single-golf_course.php';
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