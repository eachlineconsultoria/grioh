<?php
$args = array(
  'post_type' => 'depoimento',
  'posts_per_page' => 1,
  'orderby' => 'rand',
);

$depoimento_query = new WP_Query($args);

if ($depoimento_query->have_posts()):
  while ($depoimento_query->have_posts()):
    $depoimento_query->the_post();
    $nome = get_the_title();
    $conteudo = apply_filters('the_content', get_the_content());
    $conteudo = str_replace('<p>', '<p class="testimonial-text">', $conteudo);
    $foto_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); // ou 'medium' ou 'full'
    $cargo = get_field('testimonial_role');
    $empresa = get_field('testimonial_company');
    $link = get_field('testimonial_case');

    ?>

    <section id="testimonial" class="section-testimonial section-container testimonial ">
      <div class="container">
        <div class="row">
          <?php if ($foto_url): ?>
            <figure class="testimonial-image position-relative col-12 col-md-4 mb-md-0  mb-3">
              <img src="<?php echo esc_url($foto_url); ?>" alt="<?php echo esc_attr($nome); ?>"
                class="rounded img-fluid object-fit-cover">
            </figure>
          <?php endif; ?>

          <blockquote class="m-0 testimonial-quote align-self-center col-12 col-md-8">
            <?php echo $conteudo; ?>
            <footer>
              <cite class="testimonial-author fw-bold d-block fst-normal"><?php echo esc_html($nome); ?></cite>
              <p>
                <span class="testimonial-role">
                  <?php echo esc_html($cargo); ?>,
                </span>
                <span class="testimonial-company">
                  <?php echo esc_html($empresa); ?>
                </span>
              </p>
            </footer>
            <a href="<?php echo esc_html($link); ?>" class="w-100 d-inline-blockcard-link link-text link-primary">
              Leia o case completo<i class="ms-2 fa-solid fa-arrow-right"></i>
            </a>
          </blockquote>

        </div>
      </div>
    </section>

    <?php
  endwhile;
  wp_reset_postdata();
endif;
?>