<?php get_header();
// Define limite e paginação
$limite = isset($limite_de_posts) ? intval($limite_de_posts) : 3;

// Captura o número da página atual (compatível com páginas estáticas)
$paged = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
$paged = $paged ? $paged : 1;
$args = array(
  'paged' => $paged
);


?>
<?php
require get_template_directory() . '/section/breadcrumbs.php';

if (is_category() || is_tax()) {
  $term = get_queried_object();

  // Dados básicos
  $title = esc_html($term->name ?? '');
  $description = wp_kses_post($term->description ?? '');

  // Campo de imagem do ACF associado à taxonomia
  $image_field = get_field('category_image', $term);
  $image_url = $image_field['url'] ?? '';

  // Âncora do botão
  $link = '#post-list'; // altere para o ID da seção de destino
}
?>

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
<div class="container">

  <ul id="post-list" class="mt-5 list-unstyled row">
    <?php if (have_posts()):
      while (have_posts()):
        the_post(); ?>
        <li class="col-12 col-md-2 col-lg-4 mb-4">
          <article id="post-<?php the_ID(); ?>" <?php post_class('card border rounded h-100'); ?>>

            <figure class="m-0 card-container">
              <?php if (has_post_thumbnail()): ?>

                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid card-image object-fit-cover rounded-top w-100']); ?>
                </a>
              <?php else: ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/card-default.jpg"
                  class="img-fluid card-image rounded-top w-100" alt="Imagem padrão">
              <?php endif; ?>
            </figure>
            <div class="card-body p-3">
              <header>
                <h2 class="entry-title card-title mb-0">
                  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                    rel="bookmark"><?php the_title(); ?></a>
                </h2>

              </header>
              <p class="card-meta mb-0">
                Por <strong><?php the_author(); ?></strong> &bull; <?php the_time('d/m/Y'); ?>
              </p>
              <p class="card-excerpt mb-0"><?php echo get_the_excerpt(); ?></p>
            </div>
          </article>
        </li>
      <?php endwhile; endif; ?>
  </ul>
</div>

<?php if (isset($exibir_paginacao) && $exibir_paginacao): ?>
  <?php
  $total_pages = $cases_query->max_num_pages;
  $current_page = max(1, $paged);

  include get_template_directory() . '/template-parts/pagination.php';
?>
<?php endif; ?><?php get_footer(); ?>