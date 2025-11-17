<?php

/**
 * Retorna o link de uma categoria pelo slug.
 * Fallback seguro evita links quebrados.
 */
function eachline_get_category_url($slug)
{
  $term = get_category_by_slug(sanitize_title($slug));
  return $term ? get_category_link($term->term_id) : home_url('/' . $slug . '/');
}
?>

<section id="press"
  class="container section-container rounded press"
  role="region"
  aria-labelledby="press-title">

  <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">

    <h2 id="press-title" class="section-title text-center text-md-start">
      Confira nossa presença na mídia e nos eventos.
    </h2>

    <div class="button-group d-flex flex-column flex-md-row">

      <a href="<?php echo esc_url(eachline_get_category_url('imprensa')); ?>"
        class="mt-4 mt-md-0 link-text"
        title="Ver clipping de imprensa"
        aria-label="Ver todas as publicações de imprensa">
        Clipping
        <i class="ms-2 fa-solid fa-newspaper" aria-hidden="true"></i>
      </a>

      <a href="<?php echo esc_url(eachline_get_category_url('eventos')); ?>"
        class="ms-md-4 mt-4 mt-md-0 link-text"
        title="Ver eventos"
        aria-label="Ver todos os eventos">
        Eventos
        <i class="ms-2 fa-solid fa-calendar" aria-hidden="true"></i>
      </a>

    </div>

  </div>

</section>