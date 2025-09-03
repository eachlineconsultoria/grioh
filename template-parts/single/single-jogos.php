<?php
if (!function_exists('in_the_loop') || !in_the_loop() || !is_main_query()) {
  return;
}

// Dados do post
$post_id   = get_the_ID();
$permalink = get_permalink($post_id);
$title     = get_the_title($post_id);

// Vídeo
$video_url  = trim((string) get_post_meta($post_id, 'video_url', true));
$has_video  = !empty($video_url);
$embed_html = $has_video ? wp_oembed_get($video_url) : '';
$modal_id   = 'videoModal-' . $post_id;
?>

<article <?php post_class('mb-4'); ?>>

  <h2 class="mb-3">
    <a href="<?php echo esc_url($permalink); ?>">
      <?php echo esc_html($title ?: ''); ?>
    </a>
  </h2>

  <?php
  // Thumb/thumbnail do topo (usa video thumbnail se houver)
  get_template_part(
    'template-parts/banner/content',
    null,
    [
      'post_id'   => $post_id,
      'permalink' => $permalink,
      'title'     => $title,
      'video_url' => $video_url,
      'has_video' => $has_video,
      'embed_html'=> $embed_html,
      'modal_id'  => $modal_id,
    ]
  );
  ?>

  <div class="col-md-8 col-12 order-1 align-self-center order-md-2">
    <?php the_content(); ?>

    <a href="<?php echo esc_url($permalink); ?>">
      Conheça o jogo<i aria-hidden="true" class="ms-1 bi bi-arrow-right-short"></i>
    </a>
  </div>

</article>
