<?php if ( ! function_exists('in_the_loop') || ! in_the_loop() || ! is_main_query() ) { return;} ?>


<?php
/**
 * Loop de posts reutilizável
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
      $author_id = get_post_field('post_author', $post_id);
      $author = get_the_author_meta('display_name', $author_id) ?: get_the_author_meta('nickname', $author_id);
      $date_pub = get_the_date('d/m/Y', $post_id);
      ?>
      <article <?php post_class('col-md-4 mb-4', $post_id); ?>>
        <div class="card h-100 text-decoration-none">

          <?php if (has_post_thumbnail($post_id)): ?>
            <a href="<?php echo esc_url($permalink); ?>" class="card-img-top d-block"
              aria-label="<?php echo esc_attr($title); ?>">
              <?php
              $thumb_id = get_post_thumbnail_id($post_id);
              $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);

              the_post_thumbnail('medium', [
                'class' => 'img-fluid',
                'alt' => $alt ? $alt : $title,
                'loading' => 'lazy',
                'title' => 'Leia o texto: ' . $title
              ]);
              ?>
            </a>
          <?php endif; ?>

          <div class="card-body">
            <h2 class="visually-hidden-focusable">
              <?php echo esc_html($title); ?>
            </h2>

            <div class="meta text-muted mb-2">
              <?php echo esc_html($author); ?> • <?php echo esc_html($date_pub); ?>
            </div>

            <p class="card-text mb-4"><?php echo esc_html(wp_strip_all_tags(get_the_excerpt($post_id))); ?></p>

            <a href="<?php echo esc_url($permalink); ?>" class="btn btn-primary mt-auto">
              <?php esc_html_e('Leia o texto', 'grioh'); ?>
            </a>
          </div>

        </div>
      </article>
    <?php endwhile; ?>
  </div>
  <?php
endif;

wp_reset_postdata();
