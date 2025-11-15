<?php
/**
 * Template de resultados de pesquisa
 * @package Eachline
 */

get_header();

$search_query = get_search_query();
$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;

// 🔹 Query personalizada: apenas posts publicados
$args = [
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'paged'          => $paged,
  's'              => $search_query,
  'posts_per_page' => get_option('posts_per_page'),
];

$search_query_obj = new WP_Query($args);
$total_results = $search_query_obj->found_posts;
?>

<!-- HERO -->
<section id="hero" class="container custom-page-header hero my-5">
  <div class="row align-items-center">
    <div class="col-12 text-center">
      <header class="section-header">
        <?php if ($search_query): ?>
          <h1 class="section-title mb-3">
            <?php if ($total_results > 0): ?>
              <?php echo esc_html($total_results); ?> resultado<?php echo ($total_results > 1 ? 's' : ''); ?> para:
            <?php else: ?>
              Nenhum resultado para:
            <?php endif; ?>
            <span class="text-primary">"<?php echo esc_html($search_query); ?>"</span>
          </h1>

          <?php if ($total_results > 0): ?>
            <p class="section-description text-muted mb-0">
              Veja o que encontramos relacionados à sua pesquisa.
            </p>
          <?php else: ?>
            <p class="section-description text-muted mb-0">
              Tente refazer sua busca com termos diferentes.
            </p>
          <?php endif; ?>
        <?php else: ?>
          <h1 class="section-title mb-3">Pesquisar</h1>
          <p class="section-description text-muted mb-0">
            Digite um termo e descubra conteúdos.
          </p>
        <?php endif; ?>
      </header>
    </div>
  </div>
</section>

<!-- RESULTADOS -->
<section id="search-results" class="container section-container my-5">
  <?php if ($search_query_obj->have_posts()): ?>
    <div class="post-list row">
      <?php while ($search_query_obj->have_posts()):
        $search_query_obj->the_post(); ?>
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
              <header>
                <h3 class="card-title h5 mb-2">
                  <a href="<?php the_permalink(); ?>" class="link-text link-primary">
                    <?php echo esc_html(get_the_title()); ?>
                  </a>
                </h3>
              </header>

              <p class="card-text text-muted small mb-3">
                <?php
                $excerpt = wp_trim_words(get_the_excerpt(), 25, '...');
                if ($search_query) {
                  $highlight = '<mark class="fw-bold">' . esc_html($search_query) . '</mark>';
                  echo wp_kses_post(str_ireplace($search_query, $highlight, $excerpt));
                } else {
                  echo wp_kses_post($excerpt);
                }
                ?>
              </p>

              <footer class="mt-auto">
                <a href="<?php the_permalink(); ?>" class="link-text link-primary">
                  Ler artigo <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </footer>
            </div>
          </div>
        </article>
      <?php endwhile; ?>
    </div>

    <!-- PAGINAÇÃO -->
    <?php
    $total_pages = $search_query_obj->max_num_pages;
    $current_page = max(1, get_query_var('paged'));

    if ($total_pages > 1): ?>
      <nav class="pagination mt-4" aria-label="Paginação">
        <ul class="pagination-list justify-content-center align-items-center">

          <?php if ($current_page > 1): ?>
            <li class="page-item me-3">
              <a href="<?php echo esc_url(get_pagenum_link($current_page - 1)); ?>" class="page-link pagination-text">
                <i class="fa-solid fa-arrow-left me-2"></i> Anterior
              </a>
            </li>
          <?php endif; ?>

          <?php
          $links = paginate_links([
            'total'     => $total_pages,
            'current'   => $current_page,
            'type'      => 'array',
            'end_size'  => 1,
            'mid_size'  => 2,
            'prev_next' => false,
          ]);

          if ($links) {
            foreach ($links as $link) {
              $active = strpos($link, 'current') !== false ? 'active' : '';
              echo '<li class="page-item me-3 ' . esc_attr($active) . '">' . wp_kses_post($link) . '</li>';
            }
          }
          ?>

          <?php if ($current_page < $total_pages): ?>
            <li class="page-item me-0">
              <a href="<?php echo esc_url(get_pagenum_link($current_page + 1)); ?>" class="page-link pagination-text">
                Próxima <i class="fa-solid fa-arrow-right ms-2"></i>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>

  <?php else: ?>
    <div class="text-center py-5">
      <i class="fa-solid fa-magnifying-glass fa-3x mb-4 text-secondary"></i>
      <h2 class="h4 mb-3">Nenhum resultado encontrado</h2>
      <p class="text-muted mb-4">Tente novamente com outros termos ou revise a ortografia.</p>

      <form role="search" method="get" class="search-form d-flex justify-content-center"
            action="<?php echo esc_url(home_url('/')); ?>">
        <label for="search-input" class="visually-hidden">Pesquisar por:</label>
        <input type="search" id="search-input" class="form-control w-auto me-2"
               placeholder="Buscar..." value="<?php echo esc_attr($search_query); ?>" name="s" />
        <button type="submit" class="btn btn-primary">Pesquisar</button>
      </form>
    </div>
  <?php endif; ?>

  <?php wp_reset_postdata(); ?>
</section>

<?php get_footer(); ?>
