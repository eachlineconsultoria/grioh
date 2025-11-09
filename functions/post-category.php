<?php
/**
 * Exibe posts de uma categoria específica com layout padrão de cards
 *
 * @param string $category_slug Slug da categoria
 * @param string $title Título da seção
 * @param string $post_type Tipo de post (default: 'post')
 * @param int $posts_per_page Quantidade de posts (default: 3)
 * @param bool $show_excerpt Exibe resumo (default: true)
 * @param string $description Texto descritivo (default: '')
 * @param bool $show_link Mostra link "Ver mais" (default: true)
 * @param string $link_text Texto do link da seção (default: 'Ver todos')
 * @param string $card_link_text Texto do link de cada card (default: 'Ler mais')
 */
function eachline_posts_by_category(
  $category_slug,
  $title = '',
  $post_type = 'post',
  $posts_per_page = 3,
  $show_excerpt = true,
  $description = '',
  $show_link = true,
  $link_text = 'Ver todos',
  $card_link_text = 'Ler mais'
) {
  // 🔹 Busca categoria
  $category = get_category_by_slug($category_slug);
  if (!$category) return;

  // 🔹 Query otimizada
  $query = new WP_Query([
    'post_type'           => $post_type,
    'posts_per_page'      => $posts_per_page,
    'cat'                 => $category->term_id,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
  ]);

  if (!$query->have_posts()) return;

  // 🔹 Link da categoria
  $category_link = get_category_link($category->term_id);
  ?>

  <section class="section-container container category-section my-5">
    <header class="section-header d-flex justify-content-between align-items-center flex-wrap mb-4">
      <div>
        <?php if ($title): ?>
          <h2 class="section-title mb-2"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($description): ?>
          <div class="section-description text-muted"><?php echo wp_kses_post($description); ?></div>
        <?php endif; ?>
      </div>

      <?php if ($show_link): ?>
        <a href="<?php echo esc_url($category_link); ?>" 
           class="link-text link-primary fw-semibold">
          <?php echo esc_html($link_text); ?> <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
      <?php endif; ?>
    </header>

    <div class="row post-list">
      <?php while ($query->have_posts()): $query->the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
          <div class="card h-100 border-0 shadow-sm">
            
            <?php if (has_post_thumbnail()): ?>
              <a href="<?php the_permalink(); ?>" class="d-block overflow-hidden ratio ratio-16x9">
                <?php the_post_thumbnail('large', [
                  'class' => 'card-img-top object-fit-cover img-fluid',
                  'alt'   => get_the_title(),
                ]); ?>
              </a>
            <?php endif; ?>

            <div class="card-body d-flex flex-column">
              <h3 class="card-title h5 mb-2">
                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                  <?php the_title(); ?>
                </a>
              </h3>

              <?php if ($show_excerpt): ?>
                <p class="card-text text-muted small mb-3">
                  <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
                </p>
              <?php endif; ?>

              <footer class="mt-auto">
                <a href="<?php the_permalink(); ?>" class="link-text link-primary">
                  <?php echo esc_html($card_link_text); ?> <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </footer>
            </div>
          </div>
        </article>
      <?php endwhile; ?>
    </div>
  </section>

  <?php
  wp_reset_postdata();
}
