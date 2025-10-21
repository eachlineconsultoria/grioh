<?php
/**
 * Template Name: Sobre
 * Description: Template que exibe os serviços a partir de subpáginas.
 * @package Eachline
 */

get_header();
?>

<main>
  <?php require_once get_template_directory() . '/section/hero.php'; ?>

  <article class="content section-container container">
    <?php the_content(); ?>
  </article>
  
  <?php include get_template_directory() . '/section/cta.php'; ?>
  
  <section class=" section-container container">
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

  </section>
  <?php if (get_field('prizes_section')): ?>

    <?php
    $link_category_slug = 'premios-e-reconhecimentos'; // ou 'premios-e-reconhecimentos'
    $section_id = 'prizes'; // ID da seção no HTML
    $custom_class = 'prizes'; // classes adicionais
    $limit = '6'; // quantidade de links a serem exibidos
  
    include get_template_directory() . '/section/section-links.php';
    ?>
  <?php endif; ?>

  <?php if (get_field('partners_section')): ?>
    <?php
    $link_category_slug = 'parceiros'; // ou 'premios-e-reconhecimentos'
    $section_id = 'partners'; // ID da seção no HTML
    $custom_class = 'partners'; // classes adicionais
    $limit = '6'; // quantidade de links a serem exibidos
  
    include get_template_directory() . '/section/section-links.php';
    ?>
  <?php endif; ?>


</main>

<?php get_footer(); ?>