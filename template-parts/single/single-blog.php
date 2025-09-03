<?php if ( ! function_exists('in_the_loop') || ! in_the_loop() || ! is_main_query() ) { return;} ?>

<?php
$post_id   = get_the_ID();
$permalink = get_permalink();
$title     = get_the_title();
$date_pub  = get_the_date('d/m/Y');
?>

blog


<article <?php post_class('mb-4'); ?>>
  <div class="card h-100">
    <div class="card-body">
      <?php if (has_post_thumbnail()): ?>
        <a href="<?php echo esc_url($permalink); ?>" class="d-block" aria-label="<?php echo esc_attr($title); ?>">
          <?php
            $thumb_id = get_post_thumbnail_id();
            $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
            the_post_thumbnail('medium', [
              'class'   => 'card-img-top img-fluid',
              'alt'     => $alt ?: $title,
              'loading' => 'lazy',
            ]);
          ?>
        </a>
      <?php endif; ?>

      <h2><a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a></h2>

      <div class="d-flex justify-content-start align-items-center gap-2 mb-2">
        <?php if ($p = get_post_meta($post_id, 'participantes', true)): ?>
          <span><?php esc_html_e('Participação de', 'grioh'); echo ' ' . esc_html($p); ?></span>
          <span class="mx-1">•</span>
        <?php endif; ?>
        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html($date_pub); ?></time>
      </div>

      <?php the_excerpt(); ?>

      <a href="<?php echo esc_url($permalink); ?>">
        Leia o texto<i aria-hidden="true" class="ms-1 bi bi-arrow-right-short"></i>
      </a>
    </div>
  </div>
</article>
