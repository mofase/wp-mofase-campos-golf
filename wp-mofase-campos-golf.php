<?php
/*
Plugin Name: Mofase Campos Golf
Description: Plugin to manage golf course information and integrate with Astra Theme.
Version: 1.0
Author: Your Name
*/

require_once plugin_dir_path(__FILE__) . 'includes/class-golf-course-manager.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-golf-course-meta-box.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-golf-course-taxonomy.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-golf-course-importer.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-golf-course-assets.php';

// Instantiate Classes
new Golf_Course_Manager();
new Golf_Course_Meta_Box();
new Golf_Course_Taxonomy();
new Golf_Course_Importer();
new Golf_Course_Assets();