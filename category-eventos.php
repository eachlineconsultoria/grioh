<?php
/**
 * Template padrão de categoria
 * Mostra posts da categoria atual com paginação.
 */

get_header();
get_template_part('template-parts/section/hero');

// Dados da categoria atual
$category = get_queried_object();
$cat_title = $category->name ?? 'Categoria';
$cat_description = $category->description ?? '';

// Paginação
$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
$posts_per_page = 9;

// Query da categoria atual
$category_query = new WP_Query([
  'post_type' => 'post',
  'posts_per_page' => $posts_per_page,
  'paged' => $paged,
  'cat' => $category->term_id ?? 0,
  'ignore_sticky_posts' => true
]);
?>

<section id="content" class="section-container container <?php if (is_archive()): ?> py-5 <?php endif; ?> my-5">
  <?php if (!(is_archive())): ?>
    <header class="d-flex flex-column mb-4">
      <h1 class="section-title mb-2"><?php echo esc_html($cat_title); ?></h1>
      <?php if ($cat_description): ?>
        <p class="section-description text-muted"><?php echo wp_kses_post($cat_description); ?></p>
      <?php endif; ?>
    </header>
  <?php endif; ?>
  <?php if (is_category('cases')): ?>



    <?php
    get_template_part(
      'template-parts/section/section-links',
      'section-links',
      [
        'link_category_slug' => 'parceiros',
        'section_id' => 'partners',
        'custom_title' => 'Convira quem confia em nós!',
        'custom_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
      ]
    );
    ?>
  <?php endif; ?>
  <?php if ($category_query->have_posts()): ?>
    <?php if (is_category('cases')): ?>
      <header class="section-header mb-5">
        <h2 class="section-title mb-0">
          Histórias de Sucesso
        </h2>

        <div class="section-description my-0">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
          magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. </div>
      </header>
    <?php endif; ?>

    <?php if (is_category('artigos')): ?>
      <header class="section-header mb-5">
        <h2 class="section-title mb-0">
          Confira nossos textos
        </h2>

        <div class="section-description my-0">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
          magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. </div>
      </header>
    <?php endif; ?>

    <div class="post-list row">
      <?php while ($category_query->have_posts()):
        $category_query->the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
          <div class="card h-100 border-0">
            <?php if (has_post_thumbnail()): ?>
              <a href="<?php the_permalink(); ?>" class="d-block overflow-hidden ratio ratio-16x9">
                <?php the_post_thumbnail('large', [
                  'class' => 'h-100 object-fit-cover card-img img-fluid',
                  'alt' => get_the_title(),
                ]); ?>
              </a>
            <?php endif; ?>

            <div class="card-body">
              <header>
                <h3 class="card-title h5 mb-2">
                  <a href="<?php the_permalink(); ?>" class="link-text link-primary">
                    <?php the_title(); ?>
                  </a>
                </h3>
              </header>

              <p class="card-text text-muted small mb-3">
                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
              </p>

              <footer class="footer-card">
                <a href="<?php the_permalink(); ?>" class="link-text link-primary">
                  Continue lendo <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </footer>
            </div>
          </div>
        </article>
      <?php endwhile; ?>
    </div>


    <!-- Paginação -->
    <?php
    $total_pages = $category_query->max_num_pages;
    $current_page = max(1, $paged);

    if ($total_pages > 1): ?>
      <nav class="pagination mt-4" aria-label="Paginação">
        <ul class="pagination-list justify-content-center align-items-center">

          <!-- Primeira -->
          <?php if ($current_page > 1): ?>
            <li class="page-item me-3">
              <a class="page-link pagination-text" href="<?php echo esc_url(get_pagenum_link(1)); ?>"
                aria-label="Primeira página">
                <i class="fa-solid fa-arrow-left-long me-2"></i> Primeira
              </a>
            </li>
          <?php endif; ?>

          <!-- Anterior -->
          <?php if ($current_page > 1): ?>
            <li class="page-item me-3">
              <a class="page-link pagination-text" href="<?php echo esc_url(get_pagenum_link($current_page - 1)); ?>"
                aria-label="Página anterior">
                <i class="fa-solid fa-arrow-left me-2"></i> Anterior
              </a>
            </li>
          <?php endif; ?>

          <!-- Números -->
          <?php
          $links = paginate_links([
            'total' => $total_pages,
            'current' => $current_page,
            'type' => 'array',
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => false,
          ]);
          if ($links) {
            foreach ($links as $link) {
              $active = strpos($link, 'current') !== false ? 'active' : '';
              echo '<li class="page-item me-3 ' . esc_attr($active) . '">' . wp_kses_post($link) . '</li>';
            }
          }
          ?>

          <!-- Próxima -->
          <?php if ($current_page < $total_pages): ?>
            <li class="page-item me-3">
              <a class="page-link pagination-text" href="<?php echo esc_url(get_pagenum_link($current_page + 1)); ?>"
                aria-label="Próxima página">
                Próxima <i class="fa-solid fa-arrow-right ms-2"></i>
              </a>
            </li>

            <li class="page-item me-0">
              <a class="page-link pagination-text" href="<?php echo esc_url(get_pagenum_link($total_pages)); ?>"
                aria-label="Última página">
                Última <i class="fa-solid fa-arrow-right-long ms-2"></i>
              </a>
            </li>
          <?php endif; ?>
        </ul>

        <p class="text-center mt-4 small text-muted">
          Página <?php echo esc_html($current_page); ?> de <?php echo esc_html($total_pages); ?>
        </p>
      </nav>
    <?php endif; ?>

  <?php else: ?>
    <p class="text-center text-muted">Nenhum post encontrado nesta categoria.</p>
  <?php endif; ?>
</section>

<?php



wp_reset_postdata();
get_footer();
?>