<section id="partners" class="container section-container cases">
  <header class="section-header d-flex align-items-center justify-content-center justify-content-md-between">
    <h2 class="section-title">Clientes</h2>
    
    <a href="
    <?php
    $slug = 'cases'; // substitua pelo slug desejado
    
    $category = get_category_by_slug($slug);
    if ($category) {
      echo get_category_link($category->term_id);
    }
    ?>" class="case-link link link-primario">Acesse todos os cases<i class="ms-2 fa-solid fa-arrow-right"></i></a>
    
  </header>

  <?php
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'category_name' => 'cases',
    'orderby' => 'date',
    'order' => 'DESC',
  );

  $cases_query = new WP_Query($args);
  ?>

  <?php if ($cases_query->have_posts()): ?>
    <div class="row">
      <?php while ($cases_query->have_posts()):
        $cases_query->the_post(); ?>
        <div class="col-12 col-md-4">
          <article class="card case-card border rounded h-100">
            <figure class="m-0 case-container">
              <?php if (has_post_thumbnail()): ?>

                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid case-image object-fit-cover rounded-top w-100']); ?>
                </a>
              <?php else: ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/case-default.jpg"
                  class="img-fluid case-image rounded-top w-100" alt="Imagem padrão">
              <?php endif; ?>
            </figure>
            <div class="card-body case-body p-3">
              <h3 class="card-title case-title mb-0"><?php the_title(); ?></h3>
              <p class="case-excerpt mb-0"><?php echo get_the_excerpt(); ?></p>


            </div>
            <footer class="border-0 case-footer card-footer">
              <a href="<?php the_permalink(); ?>" class="case-link link link-primario">
                Leia mais<i class="ms-2 fa-solid fa-arrow-right"></i>
              </a>
            </footer>
          </article>
        </div>
      <?php endwhile;
      wp_reset_postdata(); ?>
    </div>
  </section>
<?php endif; ?>
</section>