<?php
/**
 * Jetpack Compatibility File (Optimized)
 *
 * @link https://jetpack.com/
 * @package Eachline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Configura integrações com Jetpack.
 */
function eachline_jetpack_setup() {

	/**
	 * Infinite Scroll
	 * -----------------------------------------------------------
	 */
	if ( class_exists( 'Jetpack' ) ) {
		add_theme_support( 'infinite-scroll', [
			'container' => 'main',
			'render'    => 'eachline_infinite_scroll_render',
			'footer'    => false, // Melhor performance e evita conflito de layout
			'wrapper'   => false, // Evita <div> desnecessário
		] );
	}

	/**
	 * Vídeos responsivos
	 * -----------------------------------------------------------
	 */
	add_theme_support( 'jetpack-responsive-videos' );

	/**
	 * Content Options
	 * -----------------------------------------------------------
	 */
	add_theme_support( 'jetpack-content-options', [
		'post-details' => [
			'stylesheet' => 'eachline-style',
			'date'       => '.posted-on',
			'categories' => '.cat-links',
			'tags'       => '.tags-links',
			'author'     => '.byline',
			'comment'    => '.comments-link',
		],
		'featured-images' => [
			'archive' => true,
			'post'    => true,
			'page'    => true,
		],
	] );
}
add_action( 'after_setup_theme', 'eachline_jetpack_setup' );


/**
 * Render do Infinite Scroll (limpo + seguro)
 */
function eachline_infinite_scroll_render() {

	while ( have_posts() ) {
		the_post();

		$template = is_search()
			? 'content-search'
			: 'content-' . get_post_type();

		get_template_part( 'template-parts/' . $template );
	}
}
