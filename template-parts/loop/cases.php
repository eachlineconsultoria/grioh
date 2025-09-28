<?php
// 3 posts da categoria "cases" com imagem do ACF + título + excerpt
$q = new WP_Query([
  'posts_per_page' => 3,
  'post_status' => 'publish',
  'ignore_sticky_posts' => true,
  'category_name' => 'cases', // ou use 'cat' => ID_da_categoria
]);

if ($q->have_posts()): ?>
  <div class="cases-list row">
    <?php while ($q->have_posts()):
      $q->the_post();
      $permalink = get_permalink();
      $title = get_the_title();

      // Excerpt com fallback
      $excerpt = get_the_excerpt();
      if (!$excerpt) {
        $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 25, '…');
      }

      // ---- Imagem do ACF (case_image) com fallback para a destacada ----
      $img_html = '';
      $img_id = 0;

      if (function_exists('get_field')) {
        $acf_image = get_field('case_image'); // ACF Image (ID ou Array)
        if (is_array($acf_image) && !empty($acf_image['id'])) {
          $img_id = (int) $acf_image['id'];
        } elseif (!empty($acf_image) && is_numeric($acf_image)) {
          $img_id = (int) $acf_image;
        }
      }

      if (!$img_id && has_post_thumbnail()) {
        $img_id = get_post_thumbnail_id();
      }

      $alt = $img_id ? (string) get_post_meta($img_id, '_wp_attachment_image_alt', true) : '';
      if ($alt === '')
        $alt = $title;

      if ($img_id) {
        $img_html = wp_get_attachment_image(
          $img_id,
          'large',                // ajuste o tamanho se quiser (thumbnail|medium|large|custom)
          false,
          ['alt' => esc_attr($alt), 'loading' => 'lazy', 'decoding' => 'async', 'style' => 'height:254px', 'class' => 'object-fit-cover case-item__img img-fluid card-img-top']
        );
      }
      // -----------------------------------------------------------------
      ?>
      <div class="col-12 col-md-4">
        <article class="case-item h-100 card">
          <?php if ($img_html): ?>
            <a href="<?php echo esc_url($permalink); ?>" class="case-item__media"
              aria-label="<?php echo esc_attr($title); ?>">
              <?php echo $img_html; ?>
            </a>
          <?php endif; ?>
          <div class="card-body">
            <h3 class="card-title case-item__title">
              <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
            </h3>

            <p class="case-item__excerpt card-text">
              <?php echo wpautop(esc_html($excerpt)); ?>
            </p>
          </div>
          <footer class="card-footer border-0 bg-white">
            

            <a href="<?php echo esc_url($permalink); ?>" class="btn btn-primary">Saiba mais</a>
          </footer>
        </article>
      </div>
    <?php endwhile; ?>
  </div>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>