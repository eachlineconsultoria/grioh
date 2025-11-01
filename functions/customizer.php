<?php
/**
 * Eachline Theme Customizer
 *
 * @package Eachline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registra configurações, seções e controles do customizador
 */
function eachline_customize_register( $wp_customize ) {
  // Exemplo de configuração (você pode manter as suas)
  $wp_customize->add_setting( 'eachline_accent_color', [
    'default'           => '#007bff',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
  ]);

  $wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize,
    'eachline_accent_color',
    [
      'label'   => __( 'Cor de destaque', 'eachline' ),
      'section' => 'colors',
    ]
  ));
}
add_action( 'customize_register', 'eachline_customize_register' );

/**
 * Atualiza dinamicamente no preview (via JS)
 */
function eachline_customize_preview_js() {
  wp_enqueue_script(
    'eachline-customizer',
    get_template_directory_uri() . '/assets/js/customizer.js',
    [ 'customize-preview' ],
    filemtime( get_template_directory() . '/assets/js/customizer.js' ),
    true
  );
}
add_action( 'customize_preview_init', 'eachline_customize_preview_js' );

/**
 * Injeta CSS dinâmico no <head>
 */
function eachline_customizer_css() {
  $accent = get_theme_mod( 'eachline_accent_color', '#007bff' );
  if ( $accent ) :
    ?>
    <style type="text/css">
      :root {
        --accent-color: <?php echo esc_html( $accent ); ?>;
      }
      a, .btn-primary { color: var(--accent-color); }
      .btn-primary, .bg-primary { background-color: var(--accent-color); }
    </style>
    <?php
  endif;
}
add_action( 'wp_head', 'eachline_customizer_css' );
