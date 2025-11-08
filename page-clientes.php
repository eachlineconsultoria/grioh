<?php
/**
 * Template Name: Cases
 * Description: Página que exibe os cases de sucesso com paginação opcional.
 */

get_header();
?>

<main id="primary" class="site-main">
  <?php get_template_part('template-parts/section/hero'); ?>

  <!-- // parceiros -->
  <?php

  get_template_part(
    'template-parts/section/section-links',
    null,
    [
      'link_category_slug' => 'parceiros',
      'section_id' => 'partners',
      'custom_class' => 'partners',
      'limit' => 6
    ]
  ); ?>


  <!-- // clientes -->
  <?php
  eachline_posts_by_category(
    'cases',
    'Cases',
    'post',
    -1,
    true,
    '<div class="section-description my-0 mx-auto">Descrição da seção - Parceiros. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.      </div>',
    false,
    'Acesse os cases'
  );
  ?>

  <div class="container">
    <?php
    global $wp_query;

    if (get_query_var('paged')) {
      $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
      $paged = get_query_var('page');
    } else {
      $paged = 1;
    }

    $limite_de_posts = 9;
    $exibir_paginacao = true;
    get_template_part('/section/cases.php');
    ?>
  </div>
</main>

<?php get_template_part('template-parts/section/cta'); ?>

<?php


get_footer();
?>