<?php
$args = array(
  'post_type' => 'post',
  'posts_per_page' => 3,
  'category_name' => 'historias-sucesso',
  'orderby' => 'date',
  'order' => 'DESC',
);

$cases_query = new WP_Query($args);
?>

<?php if ($cases_query->have_posts()): ?>
  <div class="row">
    <?php while ($cases_query->have_posts()):
      $cases_query->the_post(); ?>
      <div class="col-12 col-md-4 mb-5 mb-md-0">
        <article class="card  border rounded h-100">
          <figure class="m-0 card-container">
            <?php if (has_post_thumbnail()): ?>

              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid card-image object-fit-cover rounded-top w-100']); ?>
              </a>
            <?php else: ?>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/img/case-default.jpg"
                class="img-fluid card-image rounded-top w-100" alt="Imagem padrão">
            <?php endif; ?>
          </figure>
          <div class="card-body p-3">
            <h3 class="card-title mb-0">
              <a href="<?php the_permalink(); ?>" class="card-link ">
              <?php the_title(); ?>
            </a></h3>
            <p class="card-excerpt mb-0"><?php echo get_the_excerpt(); ?></p>
          </div>
          <footer class="border-0 card-footer card-footer">
            <a href="<?php the_permalink(); ?>" class="card-link link link-primario">
              Leia mais<i class="ms-2 fa-solid fa-arrow-right"></i>
            </a>
          </footer>
        </article>
      </div>
    <?php endwhile;
    wp_reset_postdata(); ?>
  </div>
<?php endif; ?>