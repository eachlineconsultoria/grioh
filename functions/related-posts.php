<?php
function eachline_related_posts(
  $title = 'Artigos relacionados',
  $posts_per_page = 3,
  $show_link = true,
  $link_text = 'Ver todos os artigos'
) {
  global $post;
  if (!$post) return;

  $current_id = $post->ID;
  $related_query = null;

  // 1️⃣ Busca por TAG
  $tags = wp_get_post_tags($current_id);
  if ($tags) {
    $tag_ids = wp_list_pluck($tags, 'term_id');
    $related_query = new WP_Query([
      'tag__in' => $tag_ids,
      'post__not_in' => [$current_id],
      'posts_per_page' => $posts_per_page,
      'ignore_sticky_posts' => true
    ]);
  }

  // 2️⃣ Fallback: busca por CATEGORIA
  if (!$related_query || !$related_query->have_posts()) {
    $categories = wp_get_post_categories($current_id);
    if ($categories) {
      $related_query = new WP_Query([
        'category__in' => $categories,
        'post__not_in' => [$current_id],
        'posts_per_page' => $posts_per_page,
        'ignore_sticky_posts' => true
      ]);
    }
  }

  // 3️⃣ Se nada encontrado, encerra
  if (!$related_query || !$related_query->have_posts()) return;
  ?>

  <section class="related-posts container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="h3 m-0 fw-bold"><?php echo esc_html($title); ?></h2>
      <?php if ($show_link): ?>
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="link-text link-secondary">
          <?php echo esc_html($link_text); ?> <i class="fa-solid fa-arrow-right"></i>
        </a>
      <?php endif; ?>
    </div>

    <!-- 🔹 Mantém a estrutura padrão usada em post-category -->
    <div class="post-list row">
      <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
          <div class="card h-100 border-0">
            <?php if (has_post_thumbnail()): ?>
              <a href="<?php the_permalink(); ?>" class="d-block overflow-hidden ratio ratio-16x9">
                <?php the_post_thumbnail('large', [
                  'class' => 'h-100 object-fit-cover card-img img-fluid',
                  'alt'   => get_the_title(),
                ]); ?>
              </a>
            <?php endif; ?>

            <div class="card-body">
              <header>
                <h3 class="card-title h5 mb-2">
                  <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                  </a>
                </h3>
              </header>

              <p class="card-text text-muted small mb-3">
                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
              </p>

              <footer class="footer-card">
                <a href="<?php the_permalink(); ?>" class="link-text link-primary">
                  Ler artigo <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </footer>
            </div>
          </div>
        </article>
      <?php endwhile; ?>
    </div>
  </section>

  <?php wp_reset_postdata();
}
