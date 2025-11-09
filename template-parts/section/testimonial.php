<?php
// Detecta contexto atual
$is_page  = is_page();
$is_single = is_single();

// Define argumentos base
$args = [
  'post_type'      => 'depoimento',
  'posts_per_page' => 1,
  'orderby'        => 'rand',
];

// 🔹 Quando for página: busca depoimento sem associação (testimonial_case vazio)
if ($is_page) {
  $args['meta_query'] = [
    [
      'key'     => 'testimonial_case',
      'compare' => 'NOT EXISTS', // campo não existe
    ],
    [
      'key'     => 'testimonial_case',
      'value'   => '',
      'compare' => '=', // ou está vazio
    ],
    'relation' => 'OR'
  ];
}

// 🔹 Quando for post: busca depoimento vinculado ao case atual
if ($is_single) {
  $current_case_id = get_the_ID();
  $args['meta_query'] = [
    [
      'key'     => 'testimonial_case',
      'value'   => $current_case_id,
      'compare' => '=',
    ],
  ];
}

$depoimento_query = new WP_Query($args);

if ($depoimento_query->have_posts()):
  while ($depoimento_query->have_posts()):
    $depoimento_query->the_post();

    $id        = get_the_ID();
    $nome      = get_the_title();
    $conteudo  = apply_filters('the_content', get_the_content());
    $conteudo  = str_replace('<p>', '<p class="testimonial-text">', $conteudo);

    $foto_url  = get_the_post_thumbnail_url($id, 'medium_large');
    $cargo     = get_field('testimonial_role') ?: '';
    $empresa   = get_field('testimonial_company') ?: '';
    $case_obj  = get_field('testimonial_case');
    $link      = $case_obj ? get_permalink($case_obj) : '';

    // Define colunas (com ou sem foto)
    $text_col_classes = $foto_url ? 'col-12 col-md-8' : 'col-12';
    ?>
    
    <section id="testimonial" class="section-container section-testimonial testimonial py-5">
      <div class="container">
        <div class="row align-items-center">

          <?php if ($foto_url): ?>
            <div class="col-12 col-md-4 mb-4 mb-md-0">
              <figure class="testimonial-image ratio ratio-1x1 m-0">
                <img
                  src="<?php echo esc_url($foto_url); ?>"
                  alt="<?php echo esc_attr("Foto de $nome"); ?>"
                  class="shadow-sm img-fluid object-fit-cover">
              </figure>
            </div>
          <?php endif; ?>

          <blockquote class="testimonial-quote m-0 <?php echo esc_attr($text_col_classes); ?>">
            <?php echo wp_kses_post($conteudo); ?>

            <footer class="testimonial-footer mt-3">
              <cite class="testimonial-author d-block mb-2">
                <span class="fw-bold"><?php echo esc_html($nome); ?></span>
                <?php if ($cargo || $empresa): ?>
                  <br>
                  <span class="testimonial-role"><?php echo esc_html($cargo); ?></span>
                  <?php if ($cargo && $empresa): ?>,<?php endif; ?>
                  <span class="testimonial-company"><?php echo esc_html($empresa); ?></span>
                <?php endif; ?>
              </cite>

              <?php if ($link): ?>
                <a href="<?php echo esc_url($link); ?>"
                   class="card-link link-text link-primary"
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
?>
