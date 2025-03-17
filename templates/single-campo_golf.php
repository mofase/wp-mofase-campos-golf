<?php
get_header();
?>

<div class="golf-course">
    <h1><?php the_title(); ?></h1>
    <div class="featured-image">
        <?php the_post_thumbnail(); ?>
    </div>
    <div class="course-details">
        <?php the_content(); ?>
    </div>
    <!-- Aquí puedes añadir más campos personalizados -->
</div>

<?php
get_footer();
?>