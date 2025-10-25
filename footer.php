<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eachline
 */

?>
<?php require_once get_template_directory() . '/section/jobs.php'; ?>
<?php require_once get_template_directory() . '/section/press.php'; ?>
<?php require_once get_template_directory() . '/section/newsletter.php'; ?>

<footer id="colophon" class="site-footer flex-column flex-md-row footer justify-content-center d-flex">

	<div class="site-info container">

		<div class="footer-branding text-center">
			<?php the_custom_logo(); ?>
			<?php if (is_front_page() && is_home()): ?>
				<h1 class="site-title mb-0 ms-2">
					<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
						<?php bloginfo('name'); ?>
					</a>
				</h1>
			<?php else: ?>
				<p class="site-title mb-0 ms-2">
					<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
						<?php bloginfo('name'); ?>
					</a>
				</p>
			<?php endif; ?>
		</div>

		<nav>
			<?php
			wp_nav_menu(array(
				'theme_location' => 'menu-footer',
				'container' => false,
				'menu_class' => 'menu-footer m-0 p-0 navbar-nav align-items-center justify-content-center flex-column flex-md-row d-flex',
				'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
				'walker' => new WP_Bootstrap_Navwalker(),
			));
			?>
		</nav>

		<div class="footer-divider"></div>

		<div class="footer-links flex-column flex-md-row d-flex justify-content-center justify-content-md-between">
			<?php
			wp_nav_menu(array(
				'theme_location' => 'footer-links',
				'container' => false,
				'menu_class' => 'footer-credits mb-3 mb-md-0 d-flex justify-content-start',

			));
			?>


			<?php if (is_active_sidebar('footer-social')): ?>
				<?php dynamic_sidebar('footer-social'); ?>
			<?php endif; ?>
		</div>

		<div class="footer-credits d-flex justify-content-between">
			<span>&copy; <?php the_date('Y'); ?>. Eachline — Todos os direitos reservados.</span>

			<a href="http://wagnerbeethoven.com.br" title="Desenvolvido por Wagner Beethoven"><img
					src="<?php echo get_template_directory_uri(); ?>/assets/img/author.svg"></a>
		</div>
	</div>

</footer>

<?php wp_footer(); ?>

</body>

</html>