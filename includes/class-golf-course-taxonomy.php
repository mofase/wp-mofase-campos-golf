<?php

class Golf_Course_Taxonomy {
    public function __construct() {
        add_action('init', [$this, 'create_taxonomies']);
        add_action('autonomia_add_form_fields', [$this, 'add_taxonomy_image_field'], 10, 2);
        add_action('provincia_add_form_fields', [$this, 'add_taxonomy_image_field'], 10, 2);
        add_action('autonomia_edit_form_fields', [$this, 'edit_taxonomy_image_field'], 10, 2);
        add_action('provincia_edit_form_fields', [$this, 'edit_taxonomy_image_field'], 10, 2);
        add_action('created_autonomia', [$this, 'save_taxonomy_image'], 10, 2);
        add_action('edited_autonomia', [$this, 'save_taxonomy_image'], 10, 2);
        add_action('created_provincia', [$this, 'save_taxonomy_image'], 10, 2);
        add_action('edited_provincia', [$this, 'save_taxonomy_image'], 10, 2);
    }

    public function create_taxonomies() {
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

    public function add_taxonomy_image_field($taxonomy) {
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

    public function edit_taxonomy_image_field($term, $taxonomy) {
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

    public function save_taxonomy_image($term_id, $tt_id) {
        if (isset($_POST['taxonomy-image-id']) && '' !== $_POST['taxonomy-image-id']) {
            $image = sanitize_text_field($_POST['taxonomy-image-id']);
            update_term_meta($term_id, 'taxonomy-image-id', $image);
        } else {
            delete_term_meta($term_id, 'taxonomy-image-id');
        }
    }
}