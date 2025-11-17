<?php
// Detecta contexto atual
$is_page   = is_page();
$is_single = is_single();

// Configuração inicial da query
$args = [
  'post_type'      => 'depoimento',
  'posts_per_page' => 1,
  'orderby'        => 'rand',
  'no_found_rows'  => true, // performance
];

// 🔹 Página: depoimentos sem case associado
if ($is_page) {
  $args['meta_query'] = [
    'relation' => 'OR',
    [
      'key'     => 'testimonial_case',
      'compare' => 'NOT EXISTS',
    ],
    [
      'key'     => 'testimonial_case',
      'value'   => '',
      'compare' => '=',
    ],
  ];
}

// 🔹 Post singular: depoimentos relacionados ao case atual
if ($is_single) {
  $args['meta_query'] = [
    [
      'key'     => 'testimonial_case',
      'value'   => get_the_ID(),
      'compare' => '=',
    ],
  ];
}

$depoimentos = new WP_Query($args);

if (!$depoimentos->have_posts()) {
  return;
}

while ($depoimentos->have_posts()) :
  $depoimentos->the_post();

  $id        = get_the_ID();
  $nome      = esc_html(get_the_title());
  $conteudo  = apply_filters('the_content', get_the_content());
  $conteudo  = str_replace('<p>', '<p class="testimonial-text">', $conteudo);

  $foto_url  = get_the_post_thumbnail_url($id, 'medium_large');
  $cargo     = esc_html(get_field('testimonial_role') ?: '');
  $empresa   = esc_html(get_field('testimonial_company') ?: '');

  $case_obj  = get_field('testimonial_case');
  $link      = $case_obj ? esc_url(get_permalink($case_obj)) : '';

  // Layout responsivo (com ou sem foto)
  $text_col_classes = $foto_url ? 'col-12 col-md-8' : 'col-12';
  ?>

  <section id="testimonial" class="section-container section-testimonial testimonial py-5">
    <div class="container">
      <div class="row align-items-center">

        <?php if ($foto_url) : ?>
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
              <span class="fw-bold"><?php echo $nome; ?></span>

              <?php if ($cargo || $empresa) : ?>
                <br>
                <span class="testimonial-role"><?php echo esc_html($cargo); ?></span>
                <?php if ($cargo && $empresa) : ?>, <?php endif; ?>
                <span class="testimonial-company"><?php echo esc_html($empresa); ?></span>
              <?php endif; ?>
            </cite>

            <?php if ($link) : ?>
              <a href="<?php echo $link; ?>"
                class="card-link link-text link-primary"
                title="Leia o case completo relacionado a este depoimento">
                Leia o case completo
                <i class="ms-2 fa-solid fa-arrow-right" aria-hidden="true"></i>
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
