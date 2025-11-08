<?php
/**
 * Template parcial para exibir posts da categoria "Artigos"
 * 
 * Local: template-parts/loop/artigos.php
 * 
 * Requer: chamada da função eachline_posts_by_category()
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
  <div class="card h-100 border-0">

    <?php if (has_post_thumbnail()): ?>
      <a href="<?php the_permalink(); ?>" class=" d-block overflow-hidden ratio ratio-16x9">
        <?php the_post_thumbnail('large', ['class' => 'h-100 object-fit-cover card-img img-fluid', 'alt' => get_the_title()]); ?>
      </a>
    <?php endif; ?>

    <div class="card-body ">

      <header>
        <h3 class="card-title h5 mb-2">
          <a href="<?php the_permalink(); ?>" class="link-text link-primary">
            <?php the_title(); ?>
          </a>
        </h3>
      </header>

      <p class="card-text text-muted small mb-3">
        <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
      </p>

      <footer class="footer-card">
        <a href="<?php the_permalink(); ?>" class="link-text link-primary">
          Ler artigo<i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
      </footer>

    </div>

  </div>
</article>