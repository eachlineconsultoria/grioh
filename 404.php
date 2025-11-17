<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Eachline
 */

get_header();
?>

<main id="main-content" class="container site-main">

	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="section-title"><?php esc_html_e('Oops! Essa página não pode ser encontrada.', 'eachline'); ?></h1>
		</header><!-- .page-header -->

			<p class="section-description mb-5">
				<?php esc_html_e('Parece que nada foi encontrado neste local. Talvez tente um dos links abaixo ou uma pesquisa?', 'eachline'); ?>
			</p>

			<?php
			get_search_form();

			?>

		
	</section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
