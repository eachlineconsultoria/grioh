<?php

/**
 * Template Name: Página inicial
 *
 * Estrutura otimizada da home, com seções modulares,
 * funções reutilizáveis e foco em performance, SEO e acessibilidade.
 *
 * @package Eachline
 */

get_header();
?>

<main id="main-content">

  <!-- HERO PRINCIPAL -->
  <?php
  // Seção hero padronizada
  get_template_part('template-parts/section/hero');
  ?>


  <!-- CASES / CLIENTES -->
  <?php
  /**
   * eachline_posts_by_category
   * Exibe um bloco com posts filtrados por categoria.
   * Totalmente configurável via parâmetros.
   */
  eachline_posts_by_category(
    'cases',                         // slug da categoria
    'Clientes',                      // título da seção
    'post',                          // tipo de post
    3,                               // quantidade de posts
    true,                            // exibir título
    '<p>Confira nossos projetos de sucesso.</p>', // descrição
    true,                            // exibe botão final
    'Ver todos os cases',            // texto do botão ver mais
    'Ler o case completo'            // texto do botão dentro do card
  );
  ?>


  <!-- CHAMADO PARA AÇÃO -->
  <?php
  get_template_part('template-parts/section/cta');
  ?>


  <!-- PARCEIROS (LINKS) -->
  <?php
  /**
   * Seção customizada para exibir a categoria "parceiros"
   * com limite de 6 itens e classe personalizada.
   */
  get_template_part(
    'template-parts/section/section-links',
    null,
    [
      'link_category_slug' => 'parceiros',
      'section_id'         => 'partners',
      'custom_class'       => 'partners',
      'limit'              => 6,
    ]
  );
  ?>


  <!-- ARTIGOS DO BLOG -->
  <?php
  eachline_posts_by_category(
    'artigos',
    'Artigos',
    'post',
    3,
    true,
    '<p>Confira novidades e atualizações.</p>',
    true,
    'Ver todos os artigos',
    'Continue lendo'
  );
  ?>

</main>

<?php get_footer(); ?>