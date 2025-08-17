<?php
/**
 * Card do banner: imagem destacada por padrão,
 * se existir meta 'video_url' (YouTube/Vimeo), mostra player e abre modal no clique.
 */

if (empty($args['post']) || !($args['post'] instanceof WP_Post)) {
  return;
}
$post = $args['post'];
setup_postdata($post);

$post_id   = $post->ID;
$permalink = get_permalink($post_id);
$title     = get_the_title($post_id);

// Campo personalizado com a URL do vídeo
$video_url = trim((string) get_post_meta($post_id, 'video_url', true));
$has_video = !empty($video_url);

// Tenta oEmbed
$embed_html = $has_video ? wp_oembed_get($video_url) : '';

$modal_id = 'videoModal-' . $post_id;
?>

<article <?php post_class('card h-100 shadow-sm border-0', $post_id); ?> aria-labelledby="post-<?php echo esc_attr($post_id); ?>-title">
  <?php if ($has_video && $embed_html) : ?>
    <!-- Player inline -->
    <div class="ratio ratio-16x9">
      <?php
      echo wp_kses(
        $embed_html,
        [
          'iframe' => [
            'src' => true, 'width' => true, 'height' => true, 'title' => true,
            'frameborder' => true, 'allow' => true, 'allowfullscreen' => true,
            'loading' => true, 'referrerpolicy' => true,
          ],
        ]
      );
      ?>
    </div>
  <?php else : ?>
    <!-- Imagem destacada -->
    <a href="<?php echo esc_url($permalink); ?>" class="text-decoration-none" aria-label="<?php echo esc_attr($title); ?>">
      <?php
      if (has_post_thumbnail($post_id)) {
        the_post_thumbnail('large', [
          'class'   => 'card-img-top',
          'alt'     => esc_attr(get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true) ?: $title),
          'loading' => 'lazy',
        ]);
      } else {
        echo '<div class="bg-light card-img-top" style="height:200px;"></div>';
      }
      ?>
    </a>
  <?php endif; ?>

  <div class="card-body">
    <h3 id="post-<?php echo esc_attr($post_id); ?>-title" class="h5 mb-2">
      <a
        <?php if ($has_video && $embed_html) : ?>
          href="#"
          data-bs-toggle="modal"
          data-bs-target="#<?php echo esc_attr($modal_id); ?>"
        <?php else : ?>
          href="<?php echo esc_url($permalink); ?>"
        <?php endif; ?>
        class="stretched-link text-decoration-none"
      >
        <?php echo esc_html($title); ?>
      </a>
    </h3>

    <p class="mb-0 text-muted"><?php echo esc_html(get_the_excerpt($post_id)); ?></p>

    <div class="mt-3">
      <?php if ($has_video && $embed_html) : ?>
        <a href="#"
           class="btn btn-primary"
           data-bs-toggle="modal"
           data-bs-target="#<?php echo esc_attr($modal_id); ?>">
          <?php esc_html_e('Ver vídeo', 'grioh'); ?>
        </a>
      <?php else : ?>
        <a href="<?php echo esc_url($permalink); ?>" class="btn btn-primary">
          <?php esc_html_e('Ler publicação', 'grioh'); ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</article>

<?php if ($has_video && $embed_html) : ?>
  <!-- Modal do vídeo -->
  <div class="modal fade" id="<?php echo esc_attr($modal_id); ?>" tabindex="-1" aria-labelledby="<?php echo esc_attr($modal_id); ?>Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 shadow">
        <div class="modal-header">
          <h5 class="modal-title" id="<?php echo esc_attr($modal_id); ?>Label"><?php echo esc_html($title); ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Fechar', 'grioh'); ?>"></button>
        </div>
        <div class="modal-body p-0">
          <div class="ratio ratio-16x9">
            <?php
            echo wp_kses(
              $embed_html,
              [
                'iframe' => [
                  'src' => true, 'width' => true, 'height' => true, 'title' => true,
                  'frameborder' => true, 'allow' => true, 'allowfullscreen' => true,
                  'loading' => true, 'referrerpolicy' => true,
                ],
              ]
            );
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php wp_reset_postdata(); ?>
