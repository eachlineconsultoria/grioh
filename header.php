<?php

/**
 * Header Template
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

	<a class="skip-link screen-reader-text" href="#primary">
		<?php esc_html_e('Pular para o conteúdo', 'eachline'); ?>
	</a>

	<header id="masthead" class="site-header py-4" role="banner">
		<div class="container">

			<div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center">

				<?php
				// Marca e título já preparados antes para evitar repetições
				$home_url = esc_url(home_url('/'));
				$blog_name = get_bloginfo('name');
				?>

				<div class="site-branding d-flex mx-auto align-items-center">
					<?php the_custom_logo(); ?>

					<?php if (is_front_page() && is_home()) : ?>
						<h1 class="site-title mb-0 ms-2">
							<a href="<?php echo $home_url; ?>" rel="home"><?php echo esc_html($blog_name); ?></a>
						</h1>
					<?php else : ?>
						<p class="site-title mb-0 ms-2">
							<a href="<?php echo $home_url; ?>" rel="home"><?php echo esc_html($blog_name); ?></a>
						</p>
					<?php endif; ?>
				</div>

				<!-- Navegação -->
				<nav id="site-navigation"
					class="main-navigation navbar navbar-expand-lg pt-5 pt-md-0"
					role="navigation"
					aria-label="<?php esc_attr_e('Menu principal', 'eachline'); ?>">

					<!-- Botão mobile -->
					<button class="navbar-toggler mb-3"
						type="button"
						data-bs-toggle="collapse"
						data-bs-target="#primary-menu"
						aria-controls="primary-menu"
						aria-expanded="false"
						aria-label="<?php esc_attr_e('Abrir menu', 'eachline'); ?>">

						<i class="fa-solid fa-bars"></i>
						<span class="visually-hidden"><?php esc_html_e('Abrir menu', 'eachline'); ?></span>
					</button>

					<div class="collapse navbar-collapse" id="primary-menu">

						<?php
wp_nav_menu([
    'theme_location' => 'menu-principal',
    'container'      => false,
    'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0 menu-principal nav-menu',
    'walker'         => new Eachline_Universal_Navwalker(),
    'fallback_cb'    => false,
]);


						?>

						<!-- Ícones -->
						<ul id="menu-icones"
							class="menu-principal-icones navbar-nav flex-row gap-2 ms-lg-3 mt-3 mt-lg-0">

							<!-- Busca -->
							<li class="nav-item">
								<button class="nav-link btn p-0"
									data-bs-toggle="modal"
									data-bs-target="#searchModal">
									<span class="visually-hidden"><?php esc_html_e('Pesquisar', 'eachline'); ?></span>
									<i class="fa-solid fa-magnifying-glass"></i>
								</button>
							</li>

							<!-- Idiomas (placeholder) -->
							<li class="nav-item">
								<button class="nav-link btn p-0"
									aria-haspopup="true"
									aria-expanded="false">
									<span class="visually-hidden"><?php esc_html_e('Selecionar idioma', 'eachline'); ?></span>
									<i class="fa-solid fa-language"></i>
								</button>
							</li>

						</ul>
					</div>
				</nav>

			</div>
		</div>
	</header>

	<?php get_template_part('template-parts/breadcrumbs'); ?>

	<!-- Modal Busca -->
	<div class="modal fade" id="searchModal" tabindex="-1"
		data-bs-backdrop="static" data-bs-keyboard="false"
		aria-labelledby="searchModalLabel" aria-hidden="true">

		<div class="modal-dialog modal-fullscreen">
			<div class="modal-content bg-white d-flex align-items-center justify-content-center">

				<div class="modal-body w-100 d-flex flex-column align-items-center justify-content-center">
					<?php get_search_form(); ?>

					<button type="button"
						class="btn-close mx-auto d-block mt-4"
						data-bs-dismiss="modal"
						aria-label="<?php esc_attr_e('Fechar', 'eachline'); ?>">
					</button>
				</div>

			</div>
		</div>
	</div>