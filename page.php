<?php
/**
 * Template para exibir páginas comuns
 *
 * Template base do tema Eachline.
 * Otimizado para SEO, semântica e acessibilidade.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Eachline
 */

get_header();

// Hero padrão do tema
get_template_part('template-parts/section/hero');
?>

<main id="main-content" class="site-main">

  <?php if (have_posts()): ?>
    <?php while (have_posts()): the_post(); ?>

      <article
        id="page-<?php the_ID(); ?>"
        <?php post_class('post-content content container section-container py-5 page-content'); ?>
        role="article"
        aria-labelledby="page-title-<?php the_ID(); ?>"
      >

        <!-- Título invisível para acessibilidade (hero já exibe o visual) -->
        <h1 id="page-title-<?php the_ID(); ?>" class="visually-hidden">
          <?php echo esc_html(get_the_title()); ?>
        </h1>

        <div class="row justify-content-center">

          <div class="col-12 col-md-8 entry-content mb-5">

            <?php
              // Conteúdo principal
              the_content();

              // Paginação interna <!--nextpage-->
              wp_link_pages([
                'before'      => '<nav class="page-links" aria-label="Paginação interna">',
                'after'       => '</nav>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
              ]);
            ?>

          </div>

        </div>

      </article>

    <?php endwhile; ?>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
