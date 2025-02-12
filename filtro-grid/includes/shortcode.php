<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function post_grid_shortcode( $atts ) {
    // Atributos por defecto, ahora se incluye 'taxonomy'
    $atts = shortcode_atts(
        array(
            'posts_to_show' => 6,
            'post_type'     => 'post',       // Tipo de post (por defecto 'post')
            'taxonomy'      => 'category',   // Taxonomía a filtrar (por defecto 'category')
        ),
        $atts,
        'post_grid_ajax'
    );
    
    ob_start();
    ?>
    <div id="post-filters">
        <!-- Botón para mostrar TODOS los posts -->
        <button class="filter-category" data-category="0">Todas</button>
        <?php
        // Obtener los términos de la taxonomía especificada
        $terms = get_terms( array(
            'taxonomy'   => $atts['taxonomy'],
            'hide_empty' => true,
        ) );
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                echo '<button class="filter-category" data-category="' . esc_attr( $term->term_id ) . '">' . esc_html( $term->name ) . '</button>';
            }
        }
        ?>
    </div>
    <!-- Se incluyen atributos data en el contenedor para post_type y taxonomy -->
    <div id="post-grid" data-post-type="<?php echo esc_attr( $atts['post_type'] ); ?>" data-taxonomy="<?php echo esc_attr( $atts['taxonomy'] ); ?>">
        <?php
        // Cargar inicialmente el grid (todos los posts) usando la taxonomía y tipo configurados
        echo post_grid_load_posts( 0, $atts['post_type'], $atts['taxonomy'] );
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'post_grid_ajax', 'post_grid_shortcode' );
