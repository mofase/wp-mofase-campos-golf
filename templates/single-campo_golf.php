<?php
get_header();
while (have_posts()) : the_post(); ?>
    <div class="golf-course">
        <div class="golf-course-thumbnail"><?php the_post_thumbnail('full'); ?></div>
        <h1><?php the_title(); ?></h1>
        <div class="golf-course-content">
            <p><strong>Resumen:</strong> <?php echo apply_filters('the_content', get_post_meta(get_the_ID(), 'resumen', true)); ?></p>
            <p><strong>Descripción:</strong> <?php echo apply_filters('the_content', get_post_meta(get_the_ID(), 'descripcion', true)); ?></p>
            <p><strong>Detalles del Campo:</strong> <?php echo apply_filters('the_content', get_post_meta(get_the_ID(), 'detalles_del_campo', true)); ?></p>
            <p><strong>Descripción Hoyo a Hoyo:</strong> <?php echo apply_filters('the_content', get_post_meta(get_the_ID(), 'descripcion_hoyo_a_hoyo', true)); ?></p>
            <p><strong>Servicios y Comodidades:</strong> <?php echo apply_filters('the_content', get_post_meta(get_the_ID(), 'servicios_y_comodidades', true)); ?></p>
            <p><strong>Datos de Contacto:</strong> <?php echo apply_filters('the_content', get_post_meta(get_the_ID(), 'datos_de_contacto', true)); ?></p>
            <p><strong>Ubicación GPS:</strong> <?php echo get_post_meta(get_the_ID(), 'ubicacion_gps', true); ?></p>
            <div id="golf-course-map" style="height: 400px;"></div>
            <p><strong>Autonomía:</strong> <?php echo get_the_term_list(get_the_ID(), 'autonomia', '', ', ', ''); ?></p>
            <p><strong>Provincia:</strong> <?php echo get_the_term_list(get_the_ID(), 'provincia', '', ', ', ''); ?></p>
            <p><strong>Galería de Imágenes:</strong></p>
            <div class="golf-course-gallery">
                <?php
                $gallery = get_post_meta(get_the_ID(), 'galeria_de_imagenes', true);
                if ($gallery) {
                    $images = explode(',', $gallery);
                    foreach ($images as $image) {
                        $img_url = wp_get_attachment_url($image);
                        echo '<a href="'.$img_url.'" data-lightbox="golf-course-gallery">'.wp_get_attachment_image($image, 'medium').'</a>';
                    }
                }
                ?>
            </div>
            <p><strong>Ranking:</strong>
                <div id="golf-course-ranking">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <button data-ranking="<?php echo $i; ?>"><?php echo $i; ?> ★</button>
                    <?php endfor; ?>
                </div>
            </p>
            <p>Imagen: <?php  echo get_post_meta(get_the_ID(),'_thumbnail_id', true); ?></p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('golf-course-map').setView([<?php echo get_post_meta(get_the_ID(), 'ubicacion_gps', true); ?>], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            L.marker([<?php echo get_post_meta(get_the_ID(), 'ubicacion_gps', true); ?>]).addTo(map)
                .bindPopup('<?php the_title(); ?>')
                .openPopup();
        });
    </script>
<?php endwhile;
get_footer();
?>