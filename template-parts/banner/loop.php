<?php if ( ! function_exists('in_the_loop') || ! in_the_loop() || ! is_main_query() ) { return;} ?>
<?php
/**
 * Loop dos banners (categoria 'destaque')
 */

$query = new WP_Query([
  'post_type' => 'post',
  'posts_per_page' => 1,
  'category_name' => 'destaque',
  'no_found_rows' => true,
]);

if ($query->have_posts()): ?>
  <section class="container my-5">
    <header class="mb-4">
      <h2 class="h4 m-0"><?php esc_html_e('Destaques', 'grioh'); ?></h2>
    </header>

    <div class="row g-4">
      <?php while ($query->have_posts()):
        $query->the_post(); ?>
        <div class="col-12 col-md-6 col-lg-4">
          <?php
          // passa o post atual para o card
          get_template_part(
            'template-parts/banner/content',
            'banner',
            ['post' => get_post()]
          );
          ?>
        </div>
      <?php endwhile; ?>
    </div>
  </section>
  <?php
else:
  // Ajuda no debug; remova em produção
  // echo '<!-- Nenhum post em destaque -->';
endif;

wp_reset_postdata();
