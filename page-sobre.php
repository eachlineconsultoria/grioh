<?php
/**
 * Template Name: Sobre
 * Description: Template que exibe os serviços a partir de subpáginas.
 * @package Eachline
 */

get_header();
?>

<main>
  <?php get_template_part('template-parts/section/hero'); ?>

  <article class="content section-container container">
    <?php the_content(); ?>
  </article>

  <?php get_template_part('template-parts/section/cta'); ?>

  <section class="section-container container">
  <h3 class="section-title">Liderança</h3>
  <?php
  // Query dos posts do tipo "membro"
  $args = array(
    'post_type'      => 'membro',        // ✅ slug correto do Custom Post Type
    'posts_per_page' => -1,              // Mostra todos os membros
    'orderby'        => 'menu_order',    // opcional — usa ordem definida no admin
    'order'          => 'name',
  );

  $query = new WP_Query($args);

  if ($query->have_posts()):
    ?>
    <div class="container team-loop">
      <div class="row g-4">
        <?php
        while ($query->have_posts()):
          $query->the_post();
          // Carrega o template de cada membro
          get_template_part('template-parts/loop/members');
        endwhile;
        wp_reset_postdata();
        ?>
      </div>
    </div>
  <?php else: ?>
    <p class="text-muted text-center my-4">Nenhum membro encontrado.</p>
  <?php endif; ?>

</section>
  <?php

  get_template_part(
    'template-parts/section/section-links',
    null,
    [
      'link_category_slug' => 'premios-e-reconhecimentos',
      'section_id' => 'prizes',
      'custom_class' => 'prizes',
      'limit' => '-1',
    ]
  ); ?>
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

</main>

<?php get_footer(); ?>