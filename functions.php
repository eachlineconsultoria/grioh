<?php
/**
 * Funções principais do tema Eachline
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package Eachline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança básica: bloqueia acesso direto ao arquivo.
}

/**
 * Versão do tema
 * Use _S_VERSION para versionar scripts/estilos do tema.
 */
if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Configuração inicial do tema
 * - Tradução
 * - Suporte a recursos nativos
 * - Menus
 */
function eachline_setup() {

	// Torna o tema traduzível
	load_theme_textdomain( 'eachline', get_template_directory() . '/languages' );

	// Feed RSS automático
	add_theme_support( 'automatic-feed-links' );

	// Deixa o WP gerenciar a <title>
	add_theme_support( 'title-tag' );

	// Imagens destacadas (posts e depois pages via hook separado)
	add_theme_support( 'post-thumbnails' );

	// Menus de navegação
	register_nav_menus(
		array(
			'menu-principal' => esc_html__( 'Menu principal', 'eachline' ),
			'menu-footer'    => esc_html__( 'Menu do rodapé', 'eachline' ),
			'footer-links'   => esc_html__( 'Políticas e Termos', 'eachline' ),
		)
	);

	// HTML5 semântico para componentes padrão
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Background customizável (se você for usar)
	add_theme_support(
		'custom-background',
		apply_filters(
			'eachline_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Atualização seletiva de widgets no Customizer
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Logo customizável
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'eachline_setup' );

/**
 * Suporte a imagem destacada em páginas
 * (posts já têm suporte por padrão)
 */
function eachline_add_page_thumbnails_support() {
	add_post_type_support( 'page', 'thumbnail' );
}
add_action( 'init', 'eachline_add_page_thumbnails_support' );

/**
 * Largura padrão do conteúdo
 * Ajuda a evitar imagens muito grandes em alguns contextos.
 */
function eachline_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'eachline_content_width', 640 );
}
add_action( 'after_setup_theme', 'eachline_content_width', 0 );

/**
 * Registro de áreas de widget (sidebars)
 */
function eachline_widgets_init() {

	// Sidebar da página de contato
	register_sidebar(
		array(
			'name'          => esc_html__( 'Página de contato', 'eachline' ),
			'id'            => 'aside-contact',
			'description'   => esc_html__( 'Widgets exibidos na página de contato.', 'eachline' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);

	// Sidebar genérica para páginas com barra lateral
	register_sidebar(
		array(
			'name'          => esc_html__( 'Página com sidebar', 'eachline' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Widgets exibidos na barra lateral.', 'eachline' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);

	// Seção "Big Numbers" da página Sobre
	register_sidebar(
		array(
			'name'          => esc_html__( 'Seção: Big numbers', 'eachline' ),
			'id'            => 'bignumbers',
			'description'   => esc_html__( 'Área de widgets da seção de números da página Sobre.', 'eachline' ),
			'before_widget' => '<div id="%1$s" class="col-6 col-md widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Rodapé: redes sociais
	register_sidebar(
		array(
			'name'          => esc_html__( 'Rodapé: redes sociais', 'eachline' ),
			'id'            => 'footer-social',
			'description'   => esc_html__( 'Área de widgets para ícones de redes sociais no rodapé.', 'eachline' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}
add_action( 'widgets_init', 'eachline_widgets_init' );

/**
 * Enfileira estilos e scripts do tema
 * - Usa CDNs para Bootstrap, Font Awesome e Google Fonts
 * - Usa filemtime para versionar CSS local (cache bust controlado)
 */
function eachline_assets() {

	// --------- CSS --------- //

	// Bootstrap via CDN
	wp_enqueue_style(
		'eachline-bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
		array(),
		'5.3.2'
	);

	// Font Awesome via CDN
	wp_enqueue_style(
		'eachline-font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css',
		array(),
		'7.0.1'
	);

	// Google Fonts – Atkinson Hyperlegible
	wp_enqueue_style(
		'eachline-google-fonts',
		'https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap',
		array(),
		null
	);

	// CSS principal do tema (style.css)
	$style_path = get_stylesheet_directory() . '/style.css';
	$style_ver  = file_exists( $style_path ) ? filemtime( $style_path ) : _S_VERSION;

	wp_enqueue_style(
		'eachline-style',
		get_stylesheet_uri(),
		array( 'eachline-bootstrap', 'eachline-font-awesome', 'eachline-google-fonts' ),
		$style_ver
	);
	wp_style_add_data( 'eachline-style', 'rtl', 'replace' );

	// CSS extra da aplicação (aplicacao.css)
	$aplicacao_path = get_template_directory() . '/aplicacao.css';
	$aplicacao_ver  = file_exists( $aplicacao_path ) ? filemtime( $aplicacao_path ) : _S_VERSION;

	wp_enqueue_style(
		'eachline-aplicacao',
		get_template_directory_uri() . '/aplicacao.css',
		array( 'eachline-style' ),
		$aplicacao_ver
	);

	// --------- JS --------- //

	// Navegação do tema (script do _s)
	wp_enqueue_script(
		'eachline-navigation',
		get_template_directory_uri() . '/js/navigation.js',
		array(),
		_S_VERSION,
		true
	);

	// Bootstrap JS bundle via CDN (inclui Popper)
	wp_enqueue_script(
		'eachline-bootstrap-js',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
		array(),
		'5.3.2',
		true
	);

	// Threaded comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'eachline_assets' );

/**
 * Custom Header
 */
require get_template_directory() . '/functions/custom-header.php';

/**
 * Template tags customizadas
 */
require get_template_directory() . '/functions/template-tags.php';

/**
 * Funções auxiliares que alteram hooks/comportamento padrão
 */
require get_template_directory() . '/functions/template-functions.php';

/**
 * Customizer
 */
require get_template_directory() . '/functions/customizer.php';

/**
 * Jetpack (se estiver ativo)
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/functions/jetpack.php';
}

/**
 * WooCommerce (se estiver ativo)
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/functions/woocommerce.php';
}

/**
 * Navwalker do Bootstrap
 */
require_once get_template_directory() . '/functions/class-wp-bootstrap-navwalker.php';

/**
 * Posts relacionados
 */
require_once get_template_directory() . '/functions/related-posts.php';

/**
 * Ativa o Link Manager antigo (se você quiser usar)
 */
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

/**
 * Adiciona excerpt em páginas
 */
function eachline_add_excerpt_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'eachline_add_excerpt_to_pages' );

/**
 * Remove as tags <p> e <br> automáticas do Contact Form 7
 * para evitar markup sujo no front.
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Título mais limpo para arquivos (categoria, tag, autor, etc.)
 */
function eachline_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'eachline_archive_title' );

/**
 * Funções auxiliares de posts por categoria
 */
require_once get_template_directory() . '/functions/post-category.php';

/**
 * Campos extras no perfil de usuário (cargo, redes, exibir no site, etc.)
 */
require_once get_template_directory() . '/functions/user_extra_fields.php';
/**
 * Remove os textos das urls de categorias e tags
 */
require_once get_template_directory() . '/functions/remove-slug-category-tag.php';