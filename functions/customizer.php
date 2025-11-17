<?php
/**
 * Eachline Theme Customizer (Optimized)
 *
 * @package Eachline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registra configurações, seções e controles do customizador.
 */
function eachline_customize_register( $wp_customize ) {

	$wp_customize->add_setting( 'eachline_accent_color', [
		'default'           => '#007bff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	] );

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'eachline_accent_color',
			[
				'label'       => __( 'Cor de destaque', 'eachline' ),
				'section'     => 'colors',
				'settings'    => 'eachline_accent_color',
			]
		)
	);
}
add_action( 'customize_register', 'eachline_customize_register' );


/**
 * Live Preview (JS) — carrega apenas no Customizer.
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
 * Carrega CSS dinâmico via wp_add_inline_style (melhor prática).
 */
function eachline_customizer_css() {
	$accent = sanitize_hex_color( get_theme_mod( 'eachline_accent_color', '#007bff' ) );

	if ( ! $accent ) {
		return;
	}

	$custom_css = "
		:root {
			--accent-color: {$accent};
		}

		a,
		.link-accent {
			color: var(--accent-color);
		}

		.btn-primary,
		.bg-primary {
			background-color: var(--accent-color);
		}

		.btn-primary:hover {
			filter: brightness(0.9);
		}
	";

	// Aplica no estilo principal do tema (diferente do wp_head inline).
	wp_add_inline_style( 'eachline-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'eachline_customizer_css' );
