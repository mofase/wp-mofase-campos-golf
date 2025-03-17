<?php
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