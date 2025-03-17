<?php
get_header();
?>

<div class="search-container">
    <form method="GET" action="<?php echo esc_url(home_url('/')); ?>">
        <label for="autonomia">Autonomía:</label>
        <?php
        wp_dropdown_categories(array(
            'taxonomy' => 'autonomia',
            'name' => 'autonomia',
            'show_option_all' => 'Todas las Autonomías',
            'selected' => get_query_var('autonomia'),
        ));
        ?>

        <label for="provincia">Provincia:</label>
        <?php
        wp_dropdown_categories(array(
            'taxonomy' => 'provincia',
            'name' => 'provincia',
            'show_option_all' => 'Todas las Provincias',
            'selected' => get_query_var('provincia'),
        ));
        ?>

        <button type="submit">Buscar</button>
    </form>
</div>

<div id="mapa-campos" style="height: 500px;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('mapa-campos').setView([40.416775, -3.703790], 6); // Coordenadas centrales de España
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php
        $args = array(
            'post_type' => 'campo_de_golf',
            'posts_per_page' => -1,
        );

        if (get_query_var('autonomia')) {
            $args['tax_query'][] = array(
                'taxonomy' => 'autonomia',
                'field' => 'id',
                'terms' => get_query_var('autonomia'),
            );
        }

        if (get_query_var('provincia')) {
            $args['tax_query'][] = array(
                'taxonomy' => 'provincia',
                'field' => 'id',
                'terms' => get_query_var('provincia'),
            );
        }

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