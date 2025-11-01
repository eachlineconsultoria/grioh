<?php
/**
 * Template Name: Página de Eventos
 * Description: Lista de eventos com paginação
 */

get_header();

// Configuração de paginação
$posts_per_page = 9; // 3 colunas × 3 linhas
$paged = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
$paged = max(1, intval($paged));

// Breadcrumbs
require get_template_directory() . '/section/breadcrumbs.php';

// Dados da categoria/taxonomia
$term = get_queried_object();
$hero_data = null;

if (is_category() || is_tax()) {
  $image_field = get_field('category_image', $term);

  $hero_data = [
    'title' => $term->name ?? '',
    'description' => $term->description ?? '',
    'image_url' => $image_field['url'] ?? '',
    'link' => '#post-list'
  ];
}

// Query personalizada com paginação
$args = [
  'post_type' => 'post',
  'posts_per_page' => $posts_per_page,
  'paged' => $paged,
  'post_status' => 'publish'
];

// Se estiver em categoria/taxonomia, filtrar por ela
if (is_category()) {
  $args['cat'] = $term->term_id;
} elseif (is_tax()) {
  $args['tax_query'] = [
    [
      'taxonomy' => $term->taxonomy,
      'field' => 'term_id',
      'terms' => $term->term_id
    ]
  ];
}

$query = new WP_Query($args);
?>

<!-- Hero Section -->
<?php if ($hero_data): ?>
  <section id="hero" class="custom-page-header hero container my-5">
    <div class="row align-items-center g-4">
      <div class="col-12 col-lg-6">
        <?php if ($hero_data['title']): ?>
          <h1 class="section-title mb-3"><?php echo esc_html($hero_data['title']); ?></h1>
        <?php endif; ?>

        <?php if ($hero_data['description']): ?>
          <div class="section-description mb-4"><?php echo wp_kses_post($hero_data['description']); ?></div>
        <?php endif; ?>

        <a href="<?php echo esc_url($hero_data['link']); ?>" class="btn btn-primary" title="Ver conteúdo">
          Ver Conteúdo <i class="ms-2 fa-solid fa-arrow-down"></i>
        </a>
      </div>

      <?php if (!empty($hero_data['image_url'])): ?>
        <div class="col-12 col-lg-6">
          <figure class="mb-0">
            <img src="<?php echo esc_url($hero_data['image_url']); ?>"
              class="img-fluid rounded shadow-sm object-fit-cover w-100" style="max-height: 400px;"
              alt="<?php echo esc_attr($hero_data['title']); ?>" loading="lazy">
          </figure>
        </div>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>

<!-- Posts Grid -->
<section id="post-list" class="container my-5">
  <?php if ($query->have_posts()): ?>
    <div class="row g-4">
      <?php while ($query->have_posts()):
        $query->the_post(); ?>
        <div class="col-12 col-md-6 col-lg-4">
          <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 shadow-sm'); ?>>
            <div class="card-body d-flex flex-column">
              <h2 class="h5 card-title mb-2">
                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark stretched-link"
                  title="<?php the_title_attribute(); ?>">
                  <?php the_title(); ?>
                </a>
              </h2>
              <p class="card-text flex-grow-1"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
<div class="card-footer"></div>
              <a class=" link link-text" href="<?php the_permalink(); ?>" class="text-decoration-none text-dark stretched-link"
                title="<?php the_title_attribute(); ?>">
                Leia mais <div class="fa-solid fa-arrow-right"></div>
              </a>
            </div>
          </article>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Paginação -->
    <?php if ($query->max_num_pages > 1): ?>
      <nav class="mt-5" aria-label="Navegação de páginas">
        <?php
        echo paginate_links([
          'total' => $query->max_num_pages,
          'current' => $paged,
          'prev_text' => '<i class="fa-solid fa-chevron-left"></i> Anterior',
          'next_text' => 'Próxima <i class="fa-solid fa-chevron-right"></i>',
          'type' => 'list',
          'class' => 'pagination justify-content-center'
        ]);
        ?>
      </nav>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

  <?php else: ?>
    <div class="alert alert-info text-center">
      <i class="fa-solid fa-circle-info me-2"></i>
      Nenhum evento encontrado.
    </div>
  <?php endif; ?>
</section>

<?php get_footer(); ?>