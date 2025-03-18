<?php
class Mofase_Campos_Golf_Importer {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_import_export_pages'));
        add_action('admin_post_import_golf_courses', array($this, 'process_import'));
    }

    public function add_import_export_pages() {
        add_submenu_page('edit.php?post_type=golf_course', 'Importar Campos de Golf', 'Importar', 'manage_options', 'import_golf_courses', array($this, 'render_import_page'));
    }

    public function render_import_page() {
        include plugin_dir_path(__FILE__) . '../templates/import-page.php';
    }

    public function process_import() {
        if (!current_user_can('manage_options')) {
            return;
        }

        if (isset($_FILES['golf_course_file']) && $_FILES['golf_course_file']['error'] == UPLOAD_ERR_OK) {
            $file = $_FILES['golf_course_file']['tmp_name'];
            // Aquí puedes añadir la lógica para procesar el archivo y guardar los datos en la base de datos.
        }

        wp_redirect(admin_url('admin.php?page=import_golf_courses&imported=1'));
        exit;
    }
}
?>