<?php
// Dados vindos de get_template_part(..., ..., $args)
$post = $args['post'] ?? get_post();
$post_id = $args['post_id'] ?? ($post ? $post->ID : 0);
$permalink = $args['permalink'] ?? ($post_id ? get_permalink($post_id) : '#');
$title = $args['title'] ?? ($post_id ? get_the_title($post_id) : '');

// Vídeo
$video_url = $args['video_url'] ?? trim((string) get_post_meta($post_id, 'video_url', true));
$has_video = $args['has_video'] ?? !empty($video_url);
$embed_html = $args['embed_html'] ?? ($has_video ? wp_oembed_get($video_url) : '');
$modal_id = $args['modal_id'] ?? ('videoModal-' . $post_id);

// Thumbnail (vídeo > destacada > placeholder)
$video_thumbnail = $has_video ? get_video_thumbnail_url($video_url) : false;
?>
<?php if ($video_thumbnail): ?>

  <a href="<?php echo $has_video ? '#' : esc_url($permalink); ?>" class="text-decoration-none" <?php if ($has_video && $embed_html): ?> data-bs-toggle="modal" data-bs-target="#<?php echo esc_attr($modal_id); ?>" <?php endif; ?>
    aria-label="<?php echo esc_attr($title ?: ''); ?>">
  <?php endif; ?>
  <?php if ($video_thumbnail): ?>
    <img src="<?php echo esc_url($video_thumbnail); ?>" alt="<?php echo esc_attr($title ?: ''); ?>"
      class="ratio ratio-16x9 position-relative" loading="lazy">
    <!-- opcional: ícone play sobre a thumb -->
    <span
      class="position-absolute top-50 start-50 translate-middle bg-dark text-white rounded-circle d-inline-flex align-items-center justify-content-center"
      style="width:56px;height:56px;opacity:.85">
      <i class="bi bi-play-fill fs-3"></i>
    </span>
  <?php elseif ($post_id && has_post_thumbnail($post_id)): ?>
    <?php the_post_thumbnail('large', [
      'class' => 'ratio ratio-16x9',
      'alt' => esc_attr(get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true) ?: ($title ?: '')),
      'loading' => 'lazy',
    ]); ?>
  <?php else: ?>
    <div class="d-none" style="height:200px;"></div>
  <?php endif; ?>

  <?php if ($video_thumbnail): ?>
  </a>
<?php endif; ?>

<?php if ($has_video && $embed_html && $post_id): ?>
  <!-- Modal com player; remove/recoloque src ao fechar para parar o vídeo -->
  <div class="modal fade" id="<?php echo esc_attr($modal_id); ?>" title="<?php echo esc_html($title ?: ''); ?>"
    tabindex="-1" aria-labelledby="<?php echo esc_attr($modal_id); ?>Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 shadow">
        <!-- <div class="modal-header">
          <h5 class="modal-title" id="<?php echo esc_attr($modal_id); ?>Label"><?php echo esc_html($title ?: ''); ?></h5>
        </div> -->
        <div class="modal-body p-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="<?php esc_attr_e('Fechar', 'grioh'); ?>"></button>
          <div class="ratio ratio-16x9">
            <?php
            echo wp_kses(
              $embed_html,
              [
                'iframe' => [
                  'src' => true,
                  'width' => true,
                  'height' => true,
                  'title' => true,
                  'frameborder' => true,
                  'allow' => true,
                  'allowfullscreen' => true,
                  'loading' => true,
                  'referrerpolicy' => true,
                  'style' => true,
                ],
              ]
            );
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var modal = document.getElementById('<?php echo esc_js($modal_id); ?>');
      if (!modal) return;

      // procura <iframe> dentro do modal
      var iframe = modal.querySelector('iframe');
      if (!iframe) return;

      var originalSrc = iframe.getAttribute('src');

      modal.addEventListener('hidden.bs.modal', function () {
        // reset do src para parar o vídeo
        iframe.setAttribute('src', '');
        setTimeout(function () { iframe.setAttribute('src', originalSrc); }, 150);
      });
    });
  </script>
<?php endif; ?>