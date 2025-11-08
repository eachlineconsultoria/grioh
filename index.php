<?php
get_header();
// Template name: Página inicial

?>

<main>
  <?php get_template_part('template-parts/section/hero'); ?>


  <!-- // clientes -->
  <?php
  eachline_posts_by_category(
    'cases',
    'Clientes',
    'post',
    3,
    false,
    '<p>Confira novidades e atualizações.</p>',
    true,
    'Acesse os cases'
  );
  ?>

  <?php get_template_part('template-parts/section/cta'); ?>

  <!-- // parceiros -->
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

  <!-- // artigos -->
  <?php

  eachline_posts_by_category(
    'artigos',
    'Artigos',
    'post',
    3,
    false,
    '<p>Confira novidades e atualizações.</p>',
    true,
    'Ler artigos'
  );
  ?>
  </section>

</main>

<?php
get_footer();
