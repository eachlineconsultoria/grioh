<?php
/**
 * Template Name: Página de Artigos
 * Description: Exibe o conteúdo da página e lista paginada de posts da categoria "artigos".
 */

get_header();

// Configuração de paginação
$posts_per_page = 9; // 3 colunas × 3 linhas
$paged = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
$paged = max(1, intval($paged));

// ---------------- HERO ----------------
// Usa os dados da própria página
$hero_data = [
  'title' => get_the_title(),
  'description' => has_excerpt() ? get_the_excerpt() : '',
  'image_url' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
  'link' => '#post-list'
];

// ---------------- QUERY DE POSTS ----------------
// Lista posts da categoria "artigos"
$args = [
  'post_type' => 'post',
  'posts_per_page' => $posts_per_page,
  'paged' => $paged,
  'post_status' => 'publish',
  'category_name' => 'artigos', // slug da categoria
];

$query = new WP_Query($args);
?>

<!-- Hero Section -->
<?php require_once get_template_directory() . '/section/hero.php'; ?>


<!-- Posts Grid -->
<section id="article-list" class="container my-5">
  <?php if ($query->have_posts()): ?>
    <div class="row g-4">
      <?php while ($query->have_posts()):
        $query->the_post(); ?>
        <div class="col-12 col-md-6 col-lg-4">
          <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 shadow-sm'); ?>>
            <figure class="m-0 card-container">
              <a href="<?php echo esc_url($permalink); ?>" class="d-block">
                <?php if (has_post_thumbnail()): ?>
                  <?php the_post_thumbnail('medium_large', [
                    'class' => 'img-fluid card-image object-fit-cover rounded-top rounded-0 w-100',
                    'alt' => esc_attr($title)
                  ]); ?>
                <?php else: ?>
                  <img src="<?php echo esc_url(get_template_directory_uri() . '/img/card-default.jpg'); ?>"
                    class="img-fluid card-image rounded-top w-100"
                    alt="Imagem padrão para o artigo <?php echo esc_attr($title); ?>">
                <?php endif; ?>
              </a>
            </figure>
            <div class="card-body d-flex flex-column">

              <h2 class="h5 card-title mb-2">
                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"
                  title="<?php the_title_attribute(); ?>">
                  <?php the_title(); ?>
                </a>
              </h2>
              <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
              <div class="border-0 card-footer">
                <a class="card-link link-text link-primary" href="<?php the_permalink(); ?>"
                  title="<?php the_title_attribute(); ?>">
                  Leia mais <span class="fa-solid fa-arrow-right">
                  </span>
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
      Nenhum artigo encontrado.
    </div>
  <?php endif; ?>
</section>

<?php get_footer(); ?>