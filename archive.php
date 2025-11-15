<?php
/**
 * Template padrão de arquivos (categorias, tags, autores, datas etc.)
 * @package Eachline
 */

get_header();

// Obtém o objeto atual (categoria, tag, autor, data etc.)
$archive_obj = get_queried_object();
// Gera título limpo sem <span>
if (is_category()) {
  $archive_title = single_cat_title('', false);
} elseif (is_tag()) {
  $archive_title = single_tag_title('', false);
} elseif (is_author()) {
  $archive_title = 'Publicações de ' . get_the_author();
} elseif (is_year()) {
  $archive_title = get_the_date('Y');
} elseif (is_month()) {
  $archive_title = get_the_date('F Y');
} elseif (is_day()) {
  $archive_title = get_the_date('d \d\e F \d\e Y');
} elseif (is_post_type_archive()) {
  $archive_title = post_type_archive_title('', false);
} else {
  $archive_title = 'Publicações';
}
$archive_description = get_the_archive_description();

// Paginação
$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
$posts_per_page = get_option('posts_per_page');

// Query personalizada (se quiser alterar comportamento)
$query_args = [
  'post_type' => 'post',
  'posts_per_page' => $posts_per_page,
  'paged' => $paged,
];
$archive_query = new WP_Query($query_args);
?>

<!-- Hero / Cabeçalho -->
<section id="hero" class="container custom-page-header hero my-5">
  <div class="row align-items-center">
    <div class="col-12 col-md-8 mx-auto text-center">
      <header class="section-header">
        <h1 class="section-title mb-3"><?php echo esc_html($archive_title); ?></h1>
        <?php if ($archive_description): ?>
          <p class="section-description"><?php echo wp_kses_post($archive_description); ?></p>
        <?php else: ?>
          <p class="section-description text-muted">
            <?php
            if (is_year()) {
              echo 'Publicações de ' . get_the_date('Y');
            } elseif (is_month()) {
              echo 'Publicações de ' . get_the_date('F \d\e Y');
            } elseif (is_author()) {
              echo 'Artigos escritos por ' . esc_html(get_the_author_meta('display_name'));
            } elseif (is_tag()) {
              echo 'Artigos marcados com "' . single_tag_title('', false) . '"';
            } elseif (is_category()) {
              echo 'Artigos da categoria "' . single_cat_title('', false) . '"';
            } else {
              echo 'Todas as publicações';
            }
            ?>
          </p>
        <?php endif; ?>
      </header>
    </div>
  </div>
</section>

<!-- Conteúdo principal -->
<section id="archive-posts" class="container section-container my-5">
  <?php if ($archive_query->have_posts()): ?>
    <div class="post-list row">
      <?php while ($archive_query->have_posts()):
        $archive_query->the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
          <div class="card h-100 border-0 shadow-sm">

            <?php if (has_post_thumbnail()): ?>
              <a href="<?php the_permalink(); ?>" class="d-block overflow-hidden ratio ratio-16x9">
                <?php the_post_thumbnail('large', [
                  'class' => 'card-img-top object-fit-cover img-fluid',
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
                  Ler artigo <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </footer>
            </div>

          </div>
        </article>
      <?php endwhile; ?>
    </div>

    <!-- Paginação -->
    <?php
    $total_pages = $archive_query->max_num_pages;
    if ($total_pages > 1):
      $current_page = max(1, get_query_var('paged'));
      ?>
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
    <p class="text-center text-muted">Nenhuma publicação encontrada.</p>
  <?php endif; ?>

  <?php wp_reset_postdata(); ?>
</section>

<?php get_template_part('template-parts/section/cta'); ?>
<?php get_template_part('template-parts/section/testimonial'); ?>


<?php get_footer(); ?>