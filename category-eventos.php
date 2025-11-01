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
$title = null;
$description = null;
$image_url = null;
$link = null;

if (is_category() || is_tax()) {
  $image_field = get_field('category_image', $term);

  $title = $term->name ?? '';
  $description = $term->description ?? '';
  $image_url = $image_field['url'] ?? '';
  $link = '#post-list';
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
<?php if (isset($term)): ?>
  <section id="hero" class="container custom-page-header hero container">
    <div class="row">
      <div
        class="section hero-content position-relative d-flex flex-column justify-content-center align-self-start col-12 col-md-6 mb-3 mb-md-0">

        <?php if ($title): ?>
          <h1 class="section-title"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>

        <?php if ($description): ?>
          <p class="section-description"><?php echo wp_kses_post($description); ?></p>
        <?php endif; ?>

        <?php if ($link): ?>
          <a href="<?php echo esc_url($link); ?>" class="hero-link link-text link-primary" title="Ir para o conteúdo">
            Acesse o conteúdo <i class="ms-2 fa-solid fa-arrow-down"></i>
          </a>
        <?php endif; ?>

      </div>

      <?php if (!empty($image_url)): ?>
        <div class=" col-12 col-md-6">
          <figure class="hero-image mb-0 h-100">
            <img src="<?php echo esc_url($image_url); ?>" class="img-fluid w-100 h-100 rounded object-fit-cover"
              alt="<?php echo esc_attr($title); ?>">
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
        $query->the_post(); 
        
        // Campos ACF
        $events_type = get_field('events_type');
        $events_date = get_field('events_date');
        ?>
        <div class="col-12 col-md-6 col-lg-4">
          <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 shadow-sm'); ?>>
            <div class="card-body d-flex flex-column">
              
              <?php if ($events_type): ?>
                <p class="text-muted small mb-2">
                  <i class="fa-solid fa-tag me-1"></i>
                  <?php echo esc_html($events_type); ?>
                </p>
              <?php endif; ?>

              <h2 class="h5 card-title mb-2">
                <a href="<?php the_permalink(); ?>" class="link link-text"
                  title="<?php the_title_attribute(); ?>">
                  <?php the_title(); ?>
                </a>
              </h2>

              <p class="card-text flex-grow-1"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>

              <?php if ($events_date): ?>
                <p class="text-muted small mb-3">
                  <i class="fa-regular fa-calendar me-1"></i>
                  <?php echo esc_html($events_date); ?>
                </p>
              <?php endif; ?>

              <div class="p-0 card-footer border-0 mt-auto">
                <a class="link link-text" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                  Leia mais <i class="fa-solid fa-arrow-right"></i>
                </a>
              </div>
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