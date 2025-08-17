<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php if (function_exists('grioh_schema_type')) {
     grioh_schema_type();
   } ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>

  <!-- (Opcional) CSS de diagnóstico de acessibilidade. Evite em produção. -->
  <!-- <link rel="stylesheet" href="https://raw.githubusercontent.com/karlgroves/diagnostic.css/refs/heads/master/diagnostic.css"> -->
</head>

<body <?php body_class(); ?>>
  <?php if (function_exists('wp_body_open')) {
    wp_body_open();
  } ?>

  <!-- Skip link para acessibilidade -->
  <a class="visually-hidden-focusable" href="#content"><?php esc_html_e('Ir para o conteúdo', 'grioh'); ?></a>

  <header class="navbar navbar-expand-lg bg-body-tertiary border-bottom" role="banner">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo esc_url(home_url('/')); ?>" title="Página inicial da <?php echo esc_attr(get_bloginfo('name')); ?>">
        <?php if ( is_front_page() || is_home() ) : ?>
          <h1 class="m-0" >
            <img src="<?php echo esc_url(get_template_directory_uri() . '/img/logo-icon.svg'); ?>"
              alt="<?php echo esc_attr__('Ilustração de uma tartaruga no estilo pixelart vista de cima com as quatro patas abertas, na cor preta, com quatro riscos brancos no casco', 'grioh'); ?>"
              class="d-inline-block align-text-top" />
          </h1>
        <?php else : ?>
          <span class="m-0">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/img/logo-icon.svg'); ?>"
              alt="<?php echo esc_attr__('Ilustração de uma tartaruga no estilo pixelart vista de cima com as quatro patas abertas, na cor preta, com quatro riscos brancos no casco', 'grioh'); ?>"
              title="<?php echo esc_attr(get_bloginfo('name')); ?>" class="d-inline-block align-text-top" />
          </span>
        <?php endif; ?>
      </a>


      <!-- Botão mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
        aria-controls="menuPrincipal" aria-expanded="false"
        aria-label="<?php esc_attr_e('Alternar navegação', 'grioh'); ?>">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu + botão de busca -->
      <div class="collapse navbar-collapse" id="menuPrincipal" role="navigation"
        aria-label="<?php esc_attr_e('Menu principal', 'grioh'); ?>">
        <?php
        wp_nav_menu([
          'theme_location' => 'main-menu',
          'container' => false,
          'menu_class' => 'navbar-nav ms-auto mb-2 mb-lg-0',
          'depth' => 2,
          'fallback_cb' => '__return_false',
          'walker' => new Grioh_Bootstrap_Navwalker(),
        ]);
        ?>


        <!-- Ícone de busca (abre modal) -->
        <button class="btn btn-link ms-2 p-2" type="button" data-bs-toggle="modal" data-bs-target="#modalBusca"
          aria-label="<?php esc_attr_e('Abrir busca', 'grioh'); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" role="img"
            aria-label="<?php esc_attr_e('Buscar', 'grioh'); ?>">
            <path fill="currentColor"
              d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242.656a5 5 0 1 1 0-10.001 5 5 0 0 1 0 10.001z" />
          </svg>
        </button>
      </div>
    </div>
  </header>

  <!-- Conteúdo principal -->
  <main id="content" <?php if (function_exists('grioh_schema_type')) {
    grioh_schema_type();
  } ?> class="py-4">