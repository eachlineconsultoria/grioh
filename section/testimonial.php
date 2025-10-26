<?php
$args = [
  'post_type'      => 'depoimento',
  'posts_per_page' => 1,
  'orderby'        => 'rand',
];

$depoimento_query = new WP_Query($args);

if ($depoimento_query->have_posts()):
  while ($depoimento_query->have_posts()):
    $depoimento_query->the_post();

    $id        = get_the_ID();
    $nome      = get_the_title();
    $conteudo  = apply_filters('the_content', get_the_content());
    // Mantém seu padrão: p com classe testimonial-text
    $conteudo  = str_replace('<p>', '<p class="testimonial-text">', $conteudo);

    $foto_url  = get_the_post_thumbnail_url($id, 'full');
    $cargo     = get_field('testimonial_role') ?: '';
    $empresa   = get_field('testimonial_company') ?: '';
    $link      = get_field('testimonial_case') ?: '';

    // Coluna do texto: ocupa 8 quando há foto, 12 quando não há
    $text_col_classes = $foto_url ? 'col-12 col-md-8' : 'col-12';
    ?>
    
    <section id="testimonial" class="section-container section-testimonial testimonial">
      <div class="container">
        <div class="row">
          
          <?php if ($foto_url): ?>
            <div class="position-relative col-12 col-md-4 mb-3 mb-md-0">
              <figure class="testimonial-image ratio ratio-1x1 m-0">
                <img
                  src="<?php echo esc_url($foto_url); ?>"
                  alt="<?php echo esc_attr("Foto de $nome"); ?>"
                  class="rounded img-fluid object-fit-cover">
              </figure>
            </div>
          <?php endif; ?>

          <blockquote class="testimonial-quote align-self-center m-0 <?php echo esc_attr($text_col_classes); ?>">
            <?php echo wp_kses_post($conteudo); ?>

            <footer class="testimonial-footer mt-3">
              <cite class="testimonial-author fst-normal d-block mb-2">
                <span class="fw-bold"><?php echo esc_html($nome); ?></span>
                <?php if ($cargo || $empresa): ?>
                  &mdash; 
                  <span class="testimonial-role"><?php echo esc_html($cargo); ?></span><?php echo ($cargo && $empresa) ? ',' : ''; ?>
                  <span class="testimonial-company"><?php echo esc_html($empresa); ?></span>
                <?php endif; ?>
              </cite>

              <?php if ($link): ?>
                <a href="<?php echo esc_url($link); ?>"
                   class="w-100 d-inline-block card-link link-text link-primary"
                   title="Leia o case completo de <?php echo esc_attr($nome); ?>">
                  Leia o case completo <i class="ms-2 fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
              <?php endif; ?>
            </footer>
          </blockquote>

        </div>
      </div>
    </section>

    <?php
  endwhile;
  wp_reset_postdata();
endif;
