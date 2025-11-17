<?php
// Campo ACF (opcional)
$title = trim($jobs_container['jobs_title'] ?? '');
$fallback_title = 'Pronto para a jornada extraordinária conosco?';

// Slug da categoria
$slug = 'trabalhe-conosco';
$category = get_category_by_slug($slug);

// Link final
$link = $category 
  ? get_category_link($category->term_id) 
  : home_url('/trabalhe-conosco');

// ID para acessibilidade
$heading_id = 'jobs-title-' . wp_rand(1000, 9999);
?>

<section 
  id="jobs" 
  class="container section-container rounded jobs"
  role="region"
  aria-labelledby="<?php echo esc_attr($heading_id); ?>"
>
  <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">

    <h2 
      id="<?php echo esc_attr($heading_id); ?>" 
      class="section-title text-center text-md-start"
    >
      <?php echo esc_html($title ?: $fallback_title); ?>
    </h2>

    <a 
      href="<?php echo esc_url($link); ?>" 
      class="mt-5 mt-md-0 link-text link-white"
      aria-label="Acesse as oportunidades de trabalho na seção Trabalhe Conosco"
    >
      Acesse as vagas
      <i class="ms-2 fa-solid fa-arrow-right" aria-hidden="true"></i>
    </a>

  </div>
</section>
