<?php
get_header();

$provincia = get_queried_object();
?>

<h1><?php echo $provincia->name; ?></h1>

<div id="mapa-campos-provincia" style="height: 500px;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('mapa-campos-provincia').setView([40.416775, -3.703790], 6); // Coordenadas centrales de España
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php
        $args = array(
            'post_type' => 'campo_de_golf',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'provincia',
                    'field' => 'id',
                    'terms' => $provincia->term_id,
                ),
            ),
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                $gps = get_post_meta(get_the_ID(), 'ubicacion_gps', true);
                if ($gps) :
                    list($lat, $lng) = explode(',', $gps);
                ?>
                L.marker([<?php echo esc_js($lat); ?>, <?php echo esc_js($lng); ?>]).addTo(map)
                    .bindPopup('<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>');
                <?php
                endif;
            endwhile;
        endif;
        wp_reset_postdata();
        ?>
    });
</script>

<?php
get_footer();
?>