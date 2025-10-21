<?php
/**
 * Seção de exibição dos cases
 * Pode ser incluída em qualquer página com:
 * $limite_de_posts = 6;
 * $exibir_paginacao = true;
 * include get_template_directory() . '/section/cases.php';
 */

// Define limite e paginação
$limite = isset($limite_de_posts) ? intval($limite_de_posts) : 3;

// Captura o número da página atual (compatível com páginas estáticas)
$paged = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
$paged = $paged ? $paged : 1;

// Define a query
$args = array(
  'post_type' => 'post',
  'posts_per_page' => $limite,
  'category_name' => 'cases',
  'orderby' => 'date',
  'order' => 'DESC',
  'paged' => $paged
);

$cases_query = new WP_Query($args);
?>

<?php if ($cases_query->have_posts()): ?>
  <div class="row">
    <?php while ($cases_query->have_posts()):
      $cases_query->the_post(); ?>
      <div class="col-12 col-md-4 mb-4">
        <article class="card border rounded h-100">
          <figure class="m-0 card-container">
            <?php if (has_post_thumbnail()): ?>
              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium_large', [
                  'class' => 'img-fluid card-image object-fit-cover rounded-top w-100',
                  'alt' => esc_attr(get_the_title())
                ]); ?>
              </a>
            <?php else: ?>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/case-default.jpg"
                class="img-fluid card-image rounded-top w-100" alt="Imagem padrão">
            <?php endif; ?>
          </figure>

          <div class="card-body p-3">
            <h3 class="card-title mb-0">
              <a href="<?php the_permalink(); ?>" class="card-link">
                <?php the_title(); ?>
              </a>
            </h3>
            <p class="card-excerpt mb-0"><?php echo get_the_excerpt(); ?></p>
          </div>

          <footer class="border-0 card-footer">
            <a href="<?php the_permalink(); ?>" class="card-link link-text link-primary">
              Leia mais <i class="ms-2 fa-solid fa-arrow-right"></i>
            </a>
          </footer>
        </article>
      </div>
    <?php endwhile; ?>
  </div>

  <?php if (isset($exibir_paginacao) && $exibir_paginacao): ?>
    <?php
    $total_pages = $cases_query->max_num_pages;
    $current_page = max(1, $paged);

   include get_template_directory() . '/template-parts/pagination.php';
  ?>
  <?php endif; ?>

  <?php wp_reset_postdata(); ?>
<?php endif; ?>