<?php /*

 * CPT: Seções + Taxonomia
 *
 * @package Eachline


if ( ! defined( 'ABSPATH' ) ) exit;


 * Registrar Custom Post Type: Seções

function eachline_register_cpt_secoes() {

	$labels = [
		'name'          => __( 'Seções', 'eachline' ),
		'singular_name' => __( 'Seção', 'eachline' ),
		'add_new'       => __( 'Adicionar Nova Seção', 'eachline' ),
		'edit_item'     => __( 'Editar Seção', 'eachline' ),
		'menu_name'     => __( 'Seções', 'eachline' ),
	];

	$args = [
		'labels'             => $labels,
		'public'             => false,        // Not public
		'publicly_queryable' => false,
		'show_ui'            => true,         // Visible in admin
		'show_in_menu'       => true,
		'show_in_nav_menus'  => false,
		'exclude_from_search'=> true,
		'show_in_admin_bar'  => true,

		// Gutenberg
		'show_in_rest'       => true,

		'menu_icon'          => 'dashicons-layout',

		// Metadados
		'supports'           => [
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'revisions',
			'custom-fields',
			'page-attributes',
		],

		// Não queremos URLs públicas
		'rewrite'            => false,
		'query_var'          => false,
	];
	
	register_post_type( 'secoes', $args );
}
add_action( 'init', 'eachline_register_cpt_secoes' );



 Registrar Taxonomia: Categorias de Seções

function eachline_register_taxonomy_secoes() {

	$labels = [
		'name'          => __( 'Categorias de Seções', 'eachline' ),
		'singular_name' => __( 'Categoria de Seção', 'eachline' ),
		'add_new_item'  => __( 'Adicionar Nova Categoria', 'eachline' ),
		'menu_name'     => __( 'Categorias', 'eachline' ),
	];

	$args = [
		'labels'       => $labels,
		'public'       => false,
		'show_ui'      => true,
		'show_in_rest' => true,       // Permite Gutenberg + API REST
		'hierarchical' => true,       // Comporta como categorias

		// Capabilities herdadas (ótimas para CPTs internos)
		'meta_box_cb'  => null,
	];

	register_taxonomy(
		'secao_categoria',
		[ 'secoes' ],
		$args
	);
}
add_action( 'init', 'eachline_register_taxonomy_secoes' );

*/?>
