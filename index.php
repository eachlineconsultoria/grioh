<?php
get_header();
// Template name: Página inicial

?>

<main>
  <?php get_template_part('template-parts/section/hero'); ?>

  <?php
  eachline_posts_by_category(
    'cases',
    'Clientes',
    'post',
    3,
    true,
    '<p>Confira nossos projetos de sucesso.</p>',
    true,
    'Ver todos os cases',
    'Ler o case completo'
  );

  ?>

  <?php get_template_part('template-parts/section/cta'); ?>

  <?php

  get_template_part(
    'template-parts/section/section-links',
    null,
    [
      'link_category_slug' => 'parceiros',
      'section_id' => 'partners',
      'custom_class' => 'partners',
      'limit' => 6,
    ]
  ); ?>

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

<?php
get_footer();
