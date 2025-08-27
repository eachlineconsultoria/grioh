<?php if ( ! function_exists('in_the_loop') || ! in_the_loop() || ! is_main_query() ) { return;} ?>

<?php
$post_id   = get_the_ID();
$permalink = get_permalink();
$title     = get_the_title();
$date_pub  = get_the_date('d/m/Y');
?>
<article <?php post_class('mb-4'); ?>>
  <div class="card h-100">
    <div class="card-body">
      <h2><a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a></h2>

      <div class="d-flex justify-content-start align-items-center gap-2 mb-2">
        <?php if ($p = get_post_meta($post_id, 'participantes', true)): ?>
          <span><?php esc_html_e('Participação de', 'grioh'); echo ' ' . esc_html($p); ?></span>
          <span class="mx-1">•</span>
        <?php endif; ?>
        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html($date_pub); ?></time>
      </div>

      <a href="<?php echo esc_url($permalink); ?>">
        Ouça o episódio<i aria-hidden="true" class="ms-1 bi bi-arrow-right-short"></i>
      </a>
    </div>
  </div>
</article>
