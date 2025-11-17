<?php
/**
 * Template padrão de categoria
 * Usa paginação universal + query nativa do WP
 * @package Eachline
 */

get_header();

// Hero da página
get_template_part('template-parts/section/hero');

// Objeto da categoria
$category            = get_queried_object();
$cat_title           = $category->name ?? 'Categoria';
$cat_description     = $category->description ?? '';

// Paginação nativa
$paged               = max(1, get_query_var('paged'));

// A query global do WordPress já está configurada corretamente,
// então vamos usá-la para manter compatibilidade total:
global $wp_query;
?>

<section id="content" class="section-container container <?php echo is_archive() ? 'py-5' : ''; ?> my-5">

  <?php if (!is_archive()): ?>
    <header class="d-flex flex-column mb-4">
      <h1 class="section-title mb-2"><?php echo esc_html($cat_title); ?></h1>

      <?php if ($cat_description): ?>
        <p class="section-description text-muted">
          <?php echo wp_kses_post($cat_description); ?>
        </p>
      <?php endif; ?>
    </header>
  <?php endif; ?>

  <!-- Se categoria "cases", exibe seção personalizada -->
  <?php if (is_category('cases')): ?>
    <?php
      get_template_part(
        'template-parts/section/section-links',
        'section-links',
        [
          'link_category_slug' => 'parceiros',
          'section_id' => 'partners',
          'custom_title' => 'Convira quem confia em nós!',
          'custom_description' => 'Lorem ipsum dolor sit amet...'
        ]
      );
    ?>
  <?php endif; ?>

  <!-- Títulos personalizados por categoria -->
  <?php if (have_posts()): ?>

    <?php if (is_category('cases')): ?>
      <header class="section-header mb-5">
        <h2 class="section-title mb-0">Histórias de Sucesso</h2>
        <div class="section-description my-0">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit...
        </div>
      </header>
    <?php endif; ?>

    <?php if (is_category('artigos')): ?>
      <header class="section-header mb-5">
        <h2 class="section-title mb-0">Confira nossos artigos</h2>
        <div class="section-description my-0">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit...
        </div>
      </header>
    <?php endif; ?>

    <!-- Loop dos posts -->
    <div class="post-list row">
      <?php while (have_posts()): the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
          <div class="card h-100 border-0">

            <!-- Thumbnail -->
            <?php if (has_post_thumbnail()): ?>
              <a href="<?php the_permalink(); ?>" class="d-block overflow-hidden ratio ratio-16x9">
                <?php the_post_thumbnail('large', [
                  'class' => 'h-100 object-fit-cover card-img img-fluid',
                  'alt'   => esc_attr(get_the_title()),
                  'loading' => 'lazy',
                  'decoding' => 'async'
                ]); ?>
              </a>
            <?php endif; ?>

            <!-- Conteúdo -->
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

    <!-- Paginação universal -->
    <?php
      $wp_query = $wp_query; // explícito
      get_template_part('template-parts/pagination');
    ?>

  <?php else: ?>
    <p class="text-center text-muted">Nenhum post encontrado nesta categoria.</p>
  <?php endif; ?>

</section>

<?php
wp_reset_postdata();
get_footer();
?>
