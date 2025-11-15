<?php
/**
 * Template name: Página com barra lateral
 *
 * Default page template for Eachline theme.
 * Other specific templates (e.g., "Serviços", "Contato") can override this.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eachline
 */

get_header();
get_template_part('template-parts/section/hero');

?>

<main id="main-content" class="site-main">


  <?php if (have_posts()): ?>
    <?php while (have_posts()):
      the_post(); ?>

      <article id="page-<?php the_ID(); ?>" <?php post_class('"post-content content site-main py-5 container section-container page-content'); ?>>
        <div class="row">
          <div id="content" class="col-12 col-md-8 entry-content">
              <?php
              the_content();

              // Paginação interna de páginas divididas com <!--nextpage-->
              wp_link_pages([
                'before' => '<div class="page-links">' . __('Páginas:', 'eachline'),
                'after' => '</div>',
              ]);
              ?>
          </div>

          <aside class="col-12 col-md-4 mx-auto sidebar">
            <?php if (is_active_sidebar('sidebar')): ?>
              <?php dynamic_sidebar('sidebar'); ?>
            <?php endif; ?>
          </aside>

        </div>

      </article>

    <?php endwhile; ?>
  <?php endif; ?>



</main>

<?php get_footer(); ?>