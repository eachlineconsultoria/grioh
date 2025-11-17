<?php
/**
 * Template Name: Página com barra lateral
 *
 * Template padrão com sidebar.
 * Otimizado para SEO, acessibilidade e performance.
 *
 * @package Eachline
 */

get_header();

// Hero padrão
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

        <div class="row">

          <!-- CONTEÚDO PRINCIPAL -->
          <div class="col-12 col-md-8 entry-content">

            <!-- Título oculto para acessibilidade (hero já tem o título visual) -->
            <h1 id="page-title-<?php the_ID(); ?>" class="visually-hidden">
              <?php echo esc_html(get_the_title()); ?>
            </h1>

            <?php
              // Conteúdo seguro
              the_content();

              // Paginação de páginas divididas com <!--nextpage-->
              wp_link_pages([
                'before' => '<nav class="page-links" aria-label="Paginação interna da página">',
                'after'  => '</nav>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
              ]);
            ?>

          </div>


          <!-- SIDEBAR -->
          <?php get_sidebar(); ?>

        </div>

      </article>

    <?php endwhile; ?>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
