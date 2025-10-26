<?php
/**
 * Eachline functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Eachline
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eachline_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Eachline, use a find and replace
	 * to change 'eachline' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('eachline', get_template_directory() . '/languages');

	function eachline_theme_setup()
	{
		load_theme_textdomain('eachline', get_template_directory() . '/languages');
	}
	add_action('after_setup_theme', 'eachline_theme_setup');


	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	// Ativa suporte a imagens destacadas (featured images)
	add_theme_support('post-thumbnails');

	// Opcional: define os tipos de post que terão suporte
	function eachline_enable_thumbnails()
	{
		add_post_type_support('page', 'thumbnail'); // habilita em páginas
		add_post_type_support('post', 'thumbnail'); // garante que posts também tenham
	}
	add_action('init', 'eachline_enable_thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-principal' => esc_html__('Menu principal', 'eachline'),
			'menu-footer' => esc_html__('Menud rodapé', 'eachline'),
			'footer-links' => esc_html__('Politicas e Termos', 'eachline'),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
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

	// Set up the WordPress core custom background feature.
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

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'eachline_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eachline_content_width()
{
	$GLOBALS['content_width'] = apply_filters('eachline_content_width', 640);
}
add_action('after_setup_theme', 'eachline_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function eachline_widgets_init()
{

	// Sidebar principal
	register_sidebar(array(
		'name' => esc_html__('Página de contato', 'eachline'),
		'id' => 'aside-contact',
		'description' => esc_html__('Adicione widgets à sidebar principal.', 'eachline'),
		// Remove divs e wrappers
		'before_widget' => '',
		'after_widget' => '',

		// Opcional: pode manter os títulos se quiser
		'before_title' => '',
		'after_title' => '',
	));



	// Bignumbers
	register_sidebar(array(
		'name' => esc_html__('Seção: Big numbers', 'eachline'),
		'id' => 'bignumbers',
		'description' => esc_html__('Área de widgets da página de sobre.', 'eachline'),
		'before_widget' => '<div id="%1$s" class="col-6 col-md widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}
add_action('widgets_init', 'eachline_widgets_init');


// Rodapé: Redes sociais
register_sidebar(array(
	'name' => esc_html__('Rodapé: redes sociais', 'eachline'),
	'id' => 'footer-social',
	'description' => esc_html__('Área de widgets de posicionamento das redes sociais.', 'eachline'),

	// Remove divs e wrappers
	'before_widget' => '',
	'after_widget' => '',

	// Opcional: pode manter os títulos se quiser
	'before_title' => '',
	'after_title' => '',
));


/**
 * Enqueue scripts and styles.
 */
function eachline_scripts()
{
	wp_enqueue_style('eachline-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('eachline-style', 'rtl', 'replace');

	wp_enqueue_script('eachline-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'eachline_scripts');


function theme_enqueue_scripts()
{
	wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
	wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array(), null, true);
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css');
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap');
	wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array(), time());
	wp_enqueue_style('aplicacao-style', get_template_directory_uri() . '/aplicacao.css', array(), time());


}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// submenu do bootstrap
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';


// ativação do menu
add_filter('pre_option_link_manager_enabled', '__return_true');

// remover tag categoria
// require_once get_template_directory() . '/inc/remove-slug-category-tag.php';


function add_excerpt_to_pages()
{
	add_post_type_support('page', 'excerpt');
}
add_action('init', 'add_excerpt_to_pages');

// Remove as tags <p> e <br> automáticas do Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');

// Remove info title from archive
function my_theme_archive_title($title)
{
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_author()) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title('', false);
	} elseif (is_tax()) {
		$title = single_term_title('', false);
	}

	return $title;
}

add_filter('get_the_archive_title', 'my_theme_archive_title');
