<?php
/**
 * Compatibilidade com WooCommerce — otimizada
 *
 * @package Eachline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 1. Declara suporte ao WooCommerce
 */
function eachline_woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'eachline_woocommerce_support' );


/**
 * 2. Carrega scripts e CSS do WooCommerce somente quando necessário
 */
function eachline_woocommerce_assets() {

    if ( ! function_exists('is_woocommerce') ) {
        return;
    }

    if ( ! ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
        return;
    }

    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // CSS
    $css_path = '/assets/css/woocommerce.css';
    if ( file_exists( $theme_dir . $css_path ) ) {
        wp_enqueue_style(
            'eachline-woocommerce',
            $theme_uri . $css_path,
            [],
            filemtime( $theme_dir . $css_path )
        );
    }

    // JS
    $js_path = '/assets/js/woocommerce.js';
    if ( file_exists( $theme_dir . $js_path ) ) {
        wp_enqueue_script(
            'eachline-woocommerce',
            $theme_uri . $js_path,
            ['jquery'],
            filemtime( $theme_dir . $js_path ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'eachline_woocommerce_assets', 20 );


/**
 * 3. Remove o wrapper padrão do WooCommerce e usa o do tema
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );


/**
 * Wrapper customizado — abertura
 */
function eachline_woocommerce_wrapper_start() {
    echo '<main id="main-content" class="site-main container" role="main">';
}
add_action( 'woocommerce_before_main_content', 'eachline_woocommerce_wrapper_start', 10 );


/**
 * Wrapper customizado — fechamento
 */
function eachline_woocommerce_wrapper_end() {
    echo '</main><!-- #main-content -->';
}
add_action( 'woocommerce_after_main_content', 'eachline_woocommerce_wrapper_end', 10 );
