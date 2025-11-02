<?php
$title = trim($jobs_container['jobs_title'] ?? '');
$fallback_title = 'Pronto para a jornada extraordinária conosco?';

$slug = 'trabalhe-conosco';
$category = get_category_by_slug($slug);
$link = $category ? get_category_link($category->term_id) : home_url('/trabalhe-conosco');
?>
<section id="jobs" class=" container section-container rounded jobs">
  <div
    class="container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">

    <h2 class="section-title text-center text-md-start">
      <?php echo esc_html($title ?: $fallback_title); ?>
    </h2>

    <a href="<?php echo esc_url($link); ?>" class="mt-5 mt-md-0 link-text link-white"
      title="Acesse as vagas em Trabalhe Conosco">
      Acesse as vagas
      <i class="ms-2 fa-solid fa-arrow-right" aria-hidden="true"></i>
    </a>

  </div>
</section>