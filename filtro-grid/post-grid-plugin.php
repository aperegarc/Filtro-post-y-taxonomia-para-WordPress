<?php
/**
 * Plugin Name: Post Grid Filter with AJAX
 * Description: Un plugin para mostrar un grid de posts con filtro por categoría y taxonomía usando AJAX.
 * Version: 1.0
 * Author: Adrián Pérez
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Evita el acceso directo
}

// Incluir archivos necesarios
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/ajax-handler.php';

// Encolar scripts y estilos
function post_grid_enqueue_scripts() {
    // Encolar el CSS del grid
    wp_enqueue_style( 'post-grid-style', plugin_dir_url( __FILE__ ) . 'assets/post-grid.css' );
    
    // Encolar el script que maneja el AJAX
    wp_enqueue_script( 'post-grid-script', plugin_dir_url( __FILE__ ) . 'assets/post-grid.js', array( 'jquery' ), null, true );
    
    // Pasar la URL del AJAX a nuestro script
    wp_localize_script( 'post-grid-script', 'postGridAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'post_grid_enqueue_scripts' );
