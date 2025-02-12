<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function post_grid_load_posts( $category_id = 0, $post_type = 'post', $taxonomy = 'category' ) {
    $args = array(
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'post_type'      => $post_type,
    );
    
    if ( $taxonomy === 'category' ) {
        // Si es la taxonomía "category", usamos el argumento 'cat'
        if ( $category_id > 0 ) {
            $args['cat'] = $category_id;
        }
    } else {
        // Para otras taxonomías, usamos un tax_query
        if ( $category_id > 0 ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $category_id,
                )
            );
        }
    }
    
    $query = new WP_Query( $args );
    $output = '<div class="post-grid">';
    
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $output .= '<div class="post-grid-item">';
            $output .= '<h3>' . get_the_title() . '</h3>';
            $output .= '<div>' . get_the_excerpt() . '</div>';
            $output .= '</div>';
        }
        wp_reset_postdata();
    } else {
        $output .= '<p>No hay posts disponibles.</p>';
    }
    
    $output .= '</div>';
    return $output;
}

function post_grid_ajax_request() {
    $category_id = isset( $_POST['category_id'] ) ? intval( $_POST['category_id'] ) : 0;
    $post_type   = isset( $_POST['post_type'] )   ? sanitize_text_field( $_POST['post_type'] ) : 'post';
    $taxonomy    = isset( $_POST['taxonomy'] )    ? sanitize_text_field( $_POST['taxonomy'] ) : 'category';
    
    echo post_grid_load_posts( $category_id, $post_type, $taxonomy );
    wp_die();
}
add_action( 'wp_ajax_load_posts_by_category', 'post_grid_ajax_request' );
add_action( 'wp_ajax_nopriv_load_posts_by_category', 'post_grid_ajax_request' );
