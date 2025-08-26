<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header>
    <?php if ( is_singular() ) : ?>
      <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
    <?php else : ?>
      <h2 class="entry-title">
        <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
      </h2>
    <?php endif; ?>

    <?php edit_post_link(); ?>

    <?php if ( ! is_search() ) :
      // carrega template-parts/entry/meta.php
      get_template_part( 'template-parts/entry/entry-meta', 'meta' );
    endif; ?>
  </header>

  <?php
    // summary em listagens; content no singular
    $is_listing = is_home() || is_archive() || is_search();
    $part_name  = $is_listing ? 'summary' : 'content';

    // carrega template-parts/entry/entry-summary.php ou entry-content.php
    get_template_part( 'template-parts/entry/entry', $part_name );
  ?>

  <?php if ( is_singular() ) :
    // carrega template-parts/entry/footer.php (ou entry-footer.php, veja observação abaixo)
    get_template_part( 'template-parts/entry/entry-footer', 'footer' );
  endif; ?>
</article>
