<?php
/**
 * Template padrão de arquivos (categorias, tags, autores, datas etc.)
 * Otimizado: performance + SEO + paginação universal
 * @package Eachline
 */

get_header();

/**
 * 1. Objeto atual (categoria, tag, autor, data, CPT, taxonomia...)
 */
$archive_obj        = get_queried_object();
$archive_title      = get_the_archive_title();
$archive_description = get_the_archive_description();

// Remove <span> indesejado do título padrão do WP
$archive_title = wp_strip_all_tags($archive_title);

/**
 * 2. Paginação
 */
$paged = max(1, get_query_var('paged'));

/**
 * 3. Usa a query GLOBAL do WordPress (muito melhor que recriar outra)
 *    Isso mantém compatibilidade com filtros, plugins, taxonomias, CPT, etc.
 */
global $wp_query;

?>

<!-- =========================================================
     HERO DO ARQUIVO (Categorias, Tag, Autor, Data etc.)
     ========================================================= -->
<section id="hero" class="container custom-page-header hero my-5">
  <div class="row align-items-center">
    <div class="col-12 col-md-8 mx-auto text-center">

      <header class="section-header">

        <!-- TÍTULO DO ARQUIVO -->
        <h1 class="section-title mb-3">
          <?php echo esc_html($archive_title); ?>
        </h1>

        <!-- DESCRIÇÃO DO ARQUIVO -->
        <?php if ($archive_description): ?>
          <p class="section-description">
            <?php echo wp_kses_post($archive_description); ?>
          </p>

        <?php else: ?>
          <p class="section-description text-muted">
            <?php
            if (is_year()) {
              echo 'Publicações de ' . get_the_date('Y');
            } elseif (is_month()) {
              echo 'Publicações de ' . get_the_date('F \d\e Y');
            } elseif (is_author()) {
              echo 'Artigos de ' . esc_html(get_the_author_meta('display_name'));
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


<!-- =========================================================
     LISTAGEM DE POSTS
     ========================================================= -->
<section id="archive-posts" class="container section-container my-5">

  <?php if (have_posts()): ?>
    <div class="post-list row">

      <?php while (have_posts()): the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
          <div class="card h-100 border-0 shadow-sm">

            <!-- Thumbnail -->
            <?php if (has_post_thumbnail()): ?>
              <a href="<?php the_permalink(); ?>"
                 class="d-block overflow-hidden ratio ratio-16x9">

                <?php the_post_thumbnail('large', [
                  'class'    => 'card-img-top object-fit-cover img-fluid',
                  'alt'      => esc_attr(get_the_title()),
                  'loading'  => 'lazy',
                  'decoding' => 'async',
                ]); ?>
              </a>
            <?php endif; ?>

            <!-- Conteúdo do card -->
            <div class="card-body">

              <header>
                <h3 class="card-title h5 mb-2">
                  <a href="<?php the_permalink(); ?>"
                     class="link-text link-primary">
                    <?php the_title(); ?>
                  </a>
                </h3>
              </header>

              <p class="card-text text-muted small mb-3">
                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
              </p>

              <footer class="footer-card">
                <a href="<?php the_permalink(); ?>"
                   class="link-text link-primary">
                  Ler artigo <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </footer>

            </div>
          </div>
        </article>

      <?php endwhile; ?>

    </div>

    <!-- =========================================================
         PAGINAÇÃO UNIVERSAL (já integrada no projeto)
         ========================================================= -->
    <?php
      $wp_query = $wp_query; // redundante mas explícito
      get_template_part('template-parts/pagination');
    ?>

  <?php else: ?>

    <p class="text-center text-muted">
      Nenhuma publicação encontrada.
    </p>

  <?php endif; ?>

</section>


<!-- CTA + Testemunhos -->
<?php get_template_part('template-parts/section/cta'); ?>
<?php get_template_part('template-parts/section/testimonial'); ?>

<?php get_footer(); ?>
