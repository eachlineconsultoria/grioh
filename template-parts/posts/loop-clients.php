<?php
/**
 * Loop de posts reutilizável (corrigido)
 * Parâmetros: category (slug), posts_per_page (int)
 */

$args = [
  'post_type' => 'post',
  'posts_per_page' => $args['posts_per_page'] ?? 3,
  'category_name' => $args['category'] ?? '',
  'orderby' => 'date',
  'order' => 'DESC',
  'no_found_rows' => true,
];

$query = new WP_Query($args);

if ($query->have_posts()): ?>
  <div class="loop-posts row">
    <?php while ($query->have_posts()):
      $query->the_post(); ?>
      <?php
      $post_id = get_the_ID();
      $permalink = get_permalink($post_id);
      $title = get_the_title($post_id);
      ?>
      <article <?php post_class('col-md-4 mb-4', $post_id); ?>>
        <div class="card h-100">

          <?php if (has_post_thumbnail($post_id)): ?>
            <a href="<?php echo esc_url($permalink); ?>" class="d-block" aria-label="<?php echo esc_attr($title); ?>">
              <?php
              $thumb_id = get_post_thumbnail_id($post_id);
              $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
              the_post_thumbnail('medium', [
                'class' => 'card-img-top img-fluid',
                'alt' => $alt ? $alt : $title,
                'loading' => 'lazy',
                'title' => 'Conheça o projeto: ' . $title

              ]);
              ?>
            </a>
          <?php endif; ?>

          <div class="card-body">
            <h2 class="card-title h5 mb-3">
              <a href="<?php echo esc_url($permalink); ?>" class="text-decoration-none">
                <?php echo esc_html($title); ?>
              </a>
            </h2>

            <a href="<?php echo esc_url($permalink); ?>" class="btn btn-primary mt-2">
              <?php esc_html_e('Conheça o projeto', 'grioh'); ?>
            </a>
          </div>

        </div>
      </article>
    <?php endwhile; ?>
  </div>
  <?php
endif;

wp_reset_postdata();
