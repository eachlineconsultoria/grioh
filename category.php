<?php get_header();
// Define limite e paginação
$limite = isset($limite_de_posts) ? intval($limite_de_posts) : 3;

// Captura o número da página atual (compatível com páginas estáticas)
$paged = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
$paged = $paged ? $paged : 1;
$args = array(
  'paged' => $paged
);


?>
<div class="container">
  <header class="header">
    <h1 class="entry-title section-title" itemprop="name"><?php single_term_title(); ?></h1>
    <div class="archive-meta  section-description" itemprop="description">
      <?php if ('' != get_the_archive_description()) {
        echo get_the_archive_description();
      } ?>
    </div>
  </header>
  <ul class="list-unstyled row">
    <?php if (have_posts()):
      while (have_posts()):
        the_post(); ?>
        <li class="col-12 col-md-2 col-lg-4 mb-4">
          <article id="post-<?php the_ID(); ?>" <?php post_class('card border rounded h-100'); ?>>

            <figure class="m-0 card-container">
              <?php if (has_post_thumbnail()): ?>

                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid card-image object-fit-cover rounded-top w-100']); ?>
                </a>
              <?php else: ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/card-default.jpg"
                  class="img-fluid card-image rounded-top w-100" alt="Imagem padrão">
              <?php endif; ?>
            </figure>
            <div class="card-body p-3">
              <header>
                <h2 class="entry-title card-title mb-0">
                  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                    rel="bookmark"><?php the_title(); ?></a>
                </h2>

              </header>
              <p class="card-meta mb-0">
                Por <strong><?php the_author(); ?></strong> &bull; <?php the_time('d/m/Y'); ?>
              </p>
              <p class="card-excerpt mb-0"><?php echo get_the_excerpt(); ?></p>
            </div>
          </article>
        </li>
      <?php endwhile; endif; ?>
  </ul>
</div>
<?php if (isset($exibir_paginacao) && $exibir_paginacao): ?>
  <?php
  $total_pages = $cases_query->max_num_pages;
  $current_page = max(1, $paged);

  include get_template_directory() . '/template-parts/pagination.php';
?>
<?php endif; ?><?php get_footer(); ?>