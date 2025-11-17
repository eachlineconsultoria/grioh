<?php
/**
 * Template parcial para exibir posts da categoria "Artigos"
 * Local: template-parts/loop/artigos.php
 */
?>

<article 
  id="post-<?php the_ID(); ?>" 
  <?php post_class('col-md-4 mb-4'); ?> 
  aria-labelledby="post-title-<?php the_ID(); ?>"
>

  <div class="card h-100 border-0">

    <?php if (has_post_thumbnail()): ?>
      <a 
        href="<?php the_permalink(); ?>" 
        class="d-block overflow-hidden ratio ratio-16x9"
        aria-label="<?php printf(esc_attr__('Ler artigo: %s', 'eachline'), get_the_title()); ?>"
      >
        <?php 
          the_post_thumbnail(
            'large',
            [
              'class' => 'card-img-top object-fit-cover img-fluid',
              'alt'   => esc_attr( get_the_title() ),
              'loading' => 'lazy',
              'decoding' => 'async'
            ]
          ); 
        ?>
      </a>
    <?php endif; ?>

    <div class="card-body d-flex flex-column">

      <header>
        <h3 id="post-title-<?php the_ID(); ?>" class="card-title h5 mb-2">
          <a 
            href="<?php the_permalink(); ?>" 
            class="link-text link-primary"
          >
            <?php the_title(); ?>
          </a>
        </h3>
      </header>

      <?php if (has_excerpt()): ?>
        <p class="card-text text-muted small mb-3">
          <?php echo esc_html( wp_trim_words(get_the_excerpt(), 25, '...') ); ?>
        </p>
      <?php endif; ?>

      <footer class="mt-auto">
        <a 
          href="<?php the_permalink(); ?>" 
          class="link-text link-primary"
          aria-label="<?php printf(esc_attr__('Ler artigo completo: %s', 'eachline'), get_the_title()); ?>"
        >
          <?php esc_html_e('Leia o artigo', 'eachline'); ?>
          <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
      </footer>

    </div>

  </div>

</article>
