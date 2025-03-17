<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

class Golf_Course_Importer {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_import_menu']);
        add_action('admin_init', [$this, 'handle_import']);
    }

    public function add_import_menu() {
        add_submenu_page('edit.php?post_type=campo_de_golf', 'Importar Campos de Golf', 'Importar Campos de Golf', 'manage_options', 'golf-course-import', [$this, 'import_page']);
    }

    public function import_page() {
        require plugin_dir_path(__FILE__) . '../templates/import-page.php';
    }

    public function handle_import() {
        if (isset($_FILES['golf_course_file'])) {
            $file = $_FILES['golf_course_file']['tmp_name'];
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // Skip header row

                $nombre = $row[0];
                $autonomia = $row[1];
                $provincia = $row[2];

                // Create or get taxonomy terms
                $autonomia_term = term_exists($autonomia, 'autonomia');
                if (!$autonomia_term) {
                    $autonomia_term = wp_insert_term($autonomia, 'autonomia');
                }

                $provincia_term = term_exists($provincia, 'provincia');
                if (!$provincia_term) {
                    $provincia_term = wp_insert_term($provincia, 'provincia');
                }

                // Create post
                $post_id = wp_insert_post(array(
                    'post_title' => $nombre,
                    'post_type' => 'campo_de_golf',
                    'post_status' => 'publish',
                ));

                // Set taxonomy terms
                wp_set_object_terms($post_id, intval($autonomia_term['term_id']), 'autonomia');
                wp_set_object_terms($post_id, intval($provincia_term['term_id']), 'provincia');

                // Set default value for agregado_texto_ia
                update_post_meta($post_id, 'agregado_texto_ia', 'no');
            }

            echo '<div class="updated"><p>Importación completada.</p></div>';
        }
    }
}