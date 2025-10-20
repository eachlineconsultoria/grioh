<?php
/**
 * Template Name: Página de Contato
 * Description: Template que exibe os serviços a partir de subpáginas.
 *
 * @package Eachline
 */

get_header();
?>

<main>
  <?php require_once get_template_directory() . '/section/hero.php'; ?>

  <article class="content section-container container">
    <?php the_content(); ?>

    <h3>Liderança</h3>
    <?php
    $args = array(
      'post_type' => 'membro',
      'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()):
      ?>
      <div class="container equipe-loop">
        <div class="row g-4">
          <?php
          while ($query->have_posts()):
            $query->the_post();
            get_template_part('loop/members');
          endwhile;
          wp_reset_postdata();
          ?>
        </div>
      </div>
    <?php endif; ?>
  </article>




</main>

<?php get_footer(); ?>