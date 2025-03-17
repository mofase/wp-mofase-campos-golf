<div class="wrap">
    <h1>Importar Campos de Golf</h1>
    <form method="post" enctype="multipart/form-data" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="import_golf_courses">
        <input type="file" name="golf_course_file" />
        <?php submit_button('Importar'); ?>
    </form>
</div>