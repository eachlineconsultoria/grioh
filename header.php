<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eachline
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>


</head>

<body <?php body_class('site'); ?>>
	<?php wp_body_open(); ?>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'eachline'); ?></a>
	<header id="masthead" class="site-header py-4">
		<div class="container">
			<div
				class="d-flex flex-column flex-lg-row justify-content-center justify-content-md-between align-items-start align-items-lg-center">

				<div class="site-branding d-flex mx-auto align-items-center">
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

				<nav id="site-navigation" class="main-navigation navbar text-center jtext-md-end navbar-expand-lg pt-5 pt-md-0">
					<button class="mb-3 navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primary-menu"
						aria-controls="primary-menu" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fa-solid fa-bars"></i> Menu
					</button>

					<div class="collapse navbar-collapse" id="primary-menu">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'menu-principal',
							'container' => false,
							'menu_class' => 'navbar-nav ms-auto mb-2 mb-lg-0 menu-principal',
							'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
							'walker' => new WP_Bootstrap_Navwalker(), // <- ERRO AQUI
						));
						?>

						<ul id="menu-icones" class="menu-principal-icones navbar-nav flex-row gap-2 ms-lg-3 mt-3 mt-lg-0">
							<li class="nav-item">
								<a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#searchModal">
									<span class="visually-hidden">Pesquisa</span>
									<i class="fa-solid fa-magnifying-glass"></i>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link" data-bs-toggle="dropdown">
									<span class="visually-hidden">Traduzir</span>
									<i class="fa-solid fa-language"></i>
								</a>
							</li>
						</ul>
					</div>
				</nav>

			</div>
		</div>
	</header>


	<!-- Modal de Pesquisa -->
	<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="searchModalLabel">Pesquisar</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				</div>
				<div class="modal-body">
					<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
						<div class="input-group">
							<input id="site-search" type="search" class="form-control" name="s"
								value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Buscar..." />
							<button class="btn btn-primary" type="submit">
								<span class="visually-hidden">Buscar</span>
								<i class="fa-solid fa-search" aria-hidden="true"></i>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>