<?php if ( ! function_exists('in_the_loop') || ! in_the_loop() || ! is_main_query() ) { return;} ?>

<?php
$post_id   = get_the_ID();
$permalink = get_permalink();
$title     = get_the_title();
?>
<article <?php post_class('mb-4'); ?>>
  <div class="card h-100">
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-4 col-12 order-2 order-md-1">
          <?php if (has_post_thumbnail()): ?>
            <a href="<?php echo esc_url($permalink); ?>" class="ratio ratio-9x16 d-block" aria-label="<?php echo esc_attr($title); ?>">
              <?php
                $thumb_id = get_post_thumbnail_id();
                $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
                the_post_thumbnail('medium', [
                  'class'   => 'h-100 object-fit-cover rounded img-fluid',
                  'alt'     => $alt ?: $title,
                  'loading' => 'lazy',
                ]);
              ?>
            </a>
          <?php endif; ?>
        </div>

        <div class="col-md-8 col-12 order-1 align-self-center order-md-2">
          <h2><a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a></h2>

          <?php the_excerpt(); ?>

          <a href="<?php echo esc_url($permalink); ?>">
            Conheça o jogo<i aria-hidden="true" class="ms-1 bi bi-arrow-right-short"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</article>
