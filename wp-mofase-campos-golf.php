<?php
/**
 * Plugin Name: Mofase Campos Golf
 * Description: Plugin to manage golf course information and integrate with Astra Theme.
 * Version: 1.0
 * Author: Your Name
 */

require_once plugin_dir_path(__FILE__) . 'includes/class-mofase-campos-golf-manager.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-mofase-campos-golf-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-mofase-campos-golf-taxonomy.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-mofase-campos-golf-importer.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-mofase-campos-golf-assets.php';

// Instantiate Classes
new Mofase_Campos_Golf_Manager();
new Mofase_Campos_Golf_Box();
new Mofase_Campos_Golf_Taxonomy();
new Mofase_Campos_Golf_Importer();
new Mofase_Campos_Golf_Assets();
?>