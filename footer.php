<?php

/**
 * Footer Template — versão otimizada
 *
 * Acessibilidade • Performance • Segurança • SEO
 *
 * @package Eachline
 */

// Pré-carrega dados para evitar repetições
$home_url   = esc_url(home_url('/'));
$site_name  = get_bloginfo('name');
$author_url = esc_url('https://wagnerbeethoven.com.br');
$author_svg = esc_url(get_template_directory_uri() . '/img/author.svg');
$current_year = esc_html(wp_date('Y'));

// Seções pré-footer
get_template_part('template-parts/section/press');
get_template_part('template-parts/section/newsletter');
get_template_part('template-parts/section/jobs');
?>

<footer id="colophon"
	class="site-footer footer d-flex flex-column flex-md-row justify-content-center"
	role="contentinfo">

	<div class="site-info container">

		<!-- Marca / logo -->
		<div class="footer-branding text-center">
			<?php the_custom_logo(); ?>

			<?php if (is_front_page() && is_home()) : ?>
				<h1 class="site-title mb-0 ms-2">
					<a href="<?php echo $home_url; ?>" rel="home"><?php echo esc_html($site_name); ?></a>
				</h1>
			<?php else : ?>
				<p class="site-title mb-0 ms-2">
					<a href="<?php echo $home_url; ?>" rel="home"><?php echo esc_html($site_name); ?></a>
				</p>
			<?php endif; ?>
		</div>

		<!-- Menu institucional -->
		<nav class="footer-nav mb-3"
			aria-label="<?php esc_attr_e('Menu institucional do rodapé', 'eachline'); ?>">

			<?php
wp_nav_menu([
    'theme_location' => 'menu-footer',
    'container'      => false,
    'menu_class'     => 'menu-footer m-0 p-0 navbar-nav align-items-center justify-content-center flex-column flex-md-row d-flex',
    'walker'         => new Eachline_Universal_Navwalker(),
    'fallback_cb'    => false,
]);



			?>
		</nav>

		<div class="footer-divider my-4"></div>

		<!-- Links legais & redes sociais -->
		<div class="footer-links d-flex flex-column flex-md-row justify-content-center justify-content-md-between align-items-start gap-3">

			<!-- Links legais / institucionais -->
			<div class="footer-legal">
				<?php
				wp_nav_menu([
					'theme_location' => 'footer-links',
					'container'      => false,
					'menu_class'     => 'footer-credits list-unstyled d-flex flex-column flex-md-row gap-3 m-0',
					'fallback_cb'    => false,
				]);
				?>
			</div>

			<!-- Social -->
			<?php if (is_active_sidebar('footer-social')) : ?>
				<div class="footer-social d-flex gap-3" aria-label="<?php esc_attr_e('Redes sociais', 'eachline'); ?>">
					<?php dynamic_sidebar('footer-social'); ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Créditos finais -->
		<div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-2 gap-2">

			<span>
				&copy; <?php echo $current_year; ?> — Eachline.
				<span class="text-muted"><?php esc_html_e('Todos os direitos reservados.', 'eachline'); ?></span>
			</span>

			<!-- Assinatura -->
			<a href="<?php echo $author_url; ?>"
				class="footer-author d-inline-flex align-items-center"
				title="<?php esc_attr_e('Desenvolvido por Wagner Beethoven', 'eachline'); ?>"
				rel="noopener noreferrer"
				target="_blank">
				<img src="<?php echo $author_svg; ?>"
					alt="<?php esc_attr_e('Logo WB — Desenvolvido por Wagner Beethoven', 'eachline'); ?>"
					width="32"
					height="32"
					loading="lazy"
					decoding="async">
			</a>

		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>

</html>