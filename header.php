<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php grioh_schema_type(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width">
  <?php wp_head(); ?>


  <link rel="stylesheet"
    href="https://raw.githubusercontent.com/karlgroves/diagnostic.css/refs/heads/master/diagnostic.css">

</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header class="navbar navbar-expand-lg bg-body-tertiary border-bottom" role="banner">
    <div class="container">
      <!-- LOGO à esquerda -->
      <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/img/logo-icon.svg" alt="Ilustração de uma tartaruga no estilo pixelart vista de cima com as 4 patas abertas na cor preta, com 4 riscos brancos no casco" title="<?php bloginfo('name'); ?>"> </a>

      <!-- Botão mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
        aria-controls="menuPrincipal" aria-expanded="false"
        aria-label="<?php esc_attr_e('Alternar navegação', 'grioh'); ?>">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu à direita + ícone de busca -->
      <div class="collapse navbar-collapse" id="menuPrincipal" role="navigation"
        aria-label="<?php esc_attr_e('Menu principal', 'grioh'); ?>">
        <?php
        wp_nav_menu([
          'theme_location' => 'main-menu',
          'container' => false,
          'menu_class' => 'navbar-nav ms-auto mb-2 mb-lg-0',
          'fallback_cb' => '__return_false',
          'depth' => 2,
        ]);
        ?>

        <!-- Ícone de busca (abre modal) -->
        <button class="btn btn-link ms-2 p-2" type="button" data-bs-toggle="modal" data-bs-target="#modalBusca"
          aria-label="<?php esc_attr_e('Abrir busca', 'grioh'); ?>">
          <!-- SVG de lupa (sem dependência de ícones externos) -->
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
            viewBox="0 0 16 16" role="img" aria-label="Search">
            <path
              d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
          </svg>
        </button>
      </div>
    </div>
  </header>

<main id="content" <?php if(function_exists('grioh_schema_type')){ grioh_schema_type(); } ?> class="py-4">



  <div id="wrapper" class="hfeed">


    <header id="header" role="banner">
      <div id="branding">
        <div id="site-title" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
          <?php
          if (is_front_page() || is_home() || is_front_page() && is_home()) {
            echo '<h1>';
          }
          echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '" rel="home" itemprop="url"><span itemprop="name">' . esc_html(get_bloginfo('name')) . '</span></a>';
          if (is_front_page() || is_home() || is_front_page() && is_home()) {
            echo '</h1>';
          }
          ?>
        </div>
        <div id="site-description" <?php if (!is_single()) {
          echo ' itemprop="description"';
        } ?>>
          <?php bloginfo('description'); ?>
        </div>
      </div>
      <nav id="menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
        <?php wp_nav_menu(array('theme_location' => 'main-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>')); ?>
        <div id="search"><?php get_search_form(); ?></div>
      </nav>
    </header>
    <div id="container">
      <main id="content" role="main">