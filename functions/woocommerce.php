<?php
/**
 * Compatibilidade com WooCommerce
 *
 * @package Eachline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Declara suporte e recursos
 */
add_action( 'after_setup_theme', function () {
  add_theme_support( 'woocommerce' );
  add_theme_support( 'wc-product-gallery-zoom' );
  add_theme_support( 'wc-product-gallery-lightbox' );
  add_theme_support( 'wc-product-gallery-slider' );
});

/**
 * Enfileira CSS e JS do WooCommerce apenas quando necessário
 */
add_action( 'wp_enqueue_scripts', function () {
  if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
    $dir = get_template_directory();
    $uri = get_template_directory_uri();

    $css = '/assets/css/woocommerce.css';
    if ( file_exists( $dir . $css ) ) {
      wp_enqueue_style( 'eachline-woocommerce', $uri . $css, [], filemtime( $dir . $css ) );
    }

    $js = '/assets/js/woocommerce.js';
    if ( file_exists( $dir . $js ) ) {
      wp_enqueue_script( 'eachline-woocommerce', $uri . $js, [], filemtime( $dir . $js ), true );
    }
  }
}, 20 );

/**
 * Remove wrappers padrão e usa os do tema
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', function () {
  echo '<main id="main-content" class="site-main container">';
}, 10 );

add_action( 'woocommerce_after_main_content', function () {
  echo '</main><!-- #primary -->';
}, 10 );
