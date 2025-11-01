<?php

$title = trim($press_container['press_title'] ?? '');
$fallback_title = 'Confira nossa presença na mídia e nos eventos.';

function get_category_url_by_slug($slug)
{
  $category = get_category_by_slug($slug);
  return $category ? get_category_link($category->term_id) : '#';
}
?>
<section id="press" class="container section-container rounded press">
  <div class=" d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">

    <h2 class="section-title text-center text-md-start">
      <?php echo esc_html($title ?: $fallback_title); ?>
    </h2>

    <div class="button-group d-flex flex-column flex-md-row">
      <a href="<?php echo esc_url(get_category_url_by_slug('imprensa')); ?>" class="mt-4 mt-md-0 link-text"
        title="Ver clipping de imprensa">
        Clipping <i class="ms-2 fa-solid fa-newspaper" aria-hidden="true"></i>
      </a>

      <a href="<?php echo esc_url(get_category_url_by_slug('eventos')); ?>" class="ms-md-4 mt-4 mt-md-0 link-text"
        title="Ver eventos">
        Eventos <i class="ms-2 fa-solid fa-calendar" aria-hidden="true"></i>
      </a>
    </div>

  </div>
</section>