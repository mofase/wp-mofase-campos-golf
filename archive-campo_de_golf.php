<?php
get_header(); ?>
<div class="golf-course-archive">
    <h1>Campos de Golf</h1>
    <div class="golf-course-filter">
        <form method="get">
            <label for="autonomia">Autonomía:</label>
            <select name="autonomia" id="autonomia">
                <option value="">Seleccione una autonomía</option>
                <?php
                $autonomias = get_terms('autonomia');
                foreach ($autonomias as $autonomia) {
                    echo '<option value="' . $autonomia->slug . '">' . $autonomia->name . '</option>';
                }
                ?>
            </select>
            <label for="provincia">Provincia:</label>
            <select name="provincia" id="provincia">
                <option value="">Seleccione una provincia</option>
                <?php
                $provincias = get_terms('provincia');
                foreach ($provincias as $provincia) {
                    echo '<option value="' . $provincia->slug . '">' . $provincia->name . '</option>';
                }
                ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>
    </div>
    <div id="golf-course-map" style="height: 400px;"></div>