<?php
/**
 * The template for displaying all pages
 *
 * Default page template for Eachline theme.
 * Other specific templates (e.g., "Serviços", "Contato") can override this.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Eachline
 */

get_header();
?>

<main id="main-content" class="site-main">

  <?php require_once get_template_directory() . '/section/hero.php'; ?>

  <?php if (have_posts()): ?>
    <?php while (have_posts()): the_post(); ?>

      <article id="page-<?php the_ID(); ?>" <?php post_class('container section-container page-content'); ?>>

        <div id="content" class="entry-content">
          <?php
          the_content();

          // Paginação interna de páginas divididas com <!--nextpage-->
          wp_link_pages([
            'before' => '<div class="page-links">' . __('Páginas:', 'eachline'),
            'after'  => '</div>',
          ]);
          ?>
        </div>

      </article>

    <?php endwhile; ?>
  <?php endif; ?>
 <?php /* Cases */ $limit = 1;
  require_once get_template_directory() . '/section/cases.php'; ?>

  
</main>

<?php get_footer(); ?>
