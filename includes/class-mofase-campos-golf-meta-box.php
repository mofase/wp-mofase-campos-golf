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
        // Render meta box fields
        ?>
        <label for="golf_course_summary">Resumen:</label>
        <?php wp_editor(get_post_meta($post->ID, 'golf_course_summary', true), 'golf_course_summary'); ?>

        <label for="golf_course_description">Descripción:</label>
        <?php wp_editor(get_post_meta($post->ID, 'golf_course_description', true), 'golf_course_description'); ?>

        <label for="golf_course_details">Detalles del Campo:</label>
        <?php wp_editor(get_post_meta($post->ID, 'golf_course_details', true), 'golf_course_details'); ?>

        <label for="golf_course_hole_by_hole">Descripción Hoyo a Hoyo:</label>
        <?php wp_editor(get_post_meta($post->ID, 'golf_course_hole_by_hole', true), 'golf_course_hole_by_hole'); ?>

        <label for="golf_course_services">Servicios y Comodidades:</label>
        <?php wp_editor(get_post_meta($post->ID, 'golf_course_services', true), 'golf_course_services'); ?>

        <label for="golf_course_contact">Datos de Contacto:</label>
        <?php wp_editor(get_post_meta($post->ID, 'golf_course_contact', true), 'golf_course_contact'); ?>

        <label for="golf_course_gps">Ubicación GPS:</label>
        <input type="text" id="golf_course_gps" name="golf_course_gps" value="<?php echo esc_attr(get_post_meta($post->ID, 'golf_course_gps', true)); ?>" />

        <label for="golf_course_autonomia">Autonomía:</label>
        <?php
        $autonomia = get_post_meta($post->ID, 'golf_course_autonomia', true);
        wp_dropdown_categories(array(
            'taxonomy' => 'autonomia',
            'name' => 'golf_course_autonomia',
            'selected' => $autonomia,
        ));
        ?>

        <label for="golf_course_provincia">Provincia:</label>
        <?php
        $provincia = get_post_meta($post->ID, 'golf_course_provincia', true);
        wp_dropdown_categories(array(
            'taxonomy' => 'provincia',
            'name' => 'golf_course_provincia',
            'selected' => $provincia,
        ));
        ?>

        <label for="golf_course_gallery">Galería de Imágenes:</label>
        <input type="text" id="golf_course_gallery" name="golf_course_gallery" value="<?php echo esc_attr(get_post_meta($post->ID, 'golf_course_gallery', true)); ?>" />
        <button type="button" class="button" id="upload_gallery_button">Subir Imágenes</button>

        <label for="golf_course_featured_image">Imagen Destacada:</label>
        <?php
        $image_id = get_post_meta($post->ID, 'golf_course_featured_image', true);
        echo wp_get_attachment_image($image_id, 'thumbnail');
        ?>
        <button type="button" class="button" id="upload_featured_image_button">Subir Imagen</button>

        <label for="golf_course_ranking">Ranking del Campo:</label>
        <div id="golf_course_ranking"></div>

        <label for="golf_course_generated_text_ai">Generado por IA:</label>
        <input type="checkbox" id="golf_course_generated_text_ai" name="golf_course_generated_text_ai" value="1" <?php checked(get_post_meta($post->ID, 'golf_course_generated_text_ai', true), '1'); ?> />
        <?php
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