<?php
// Verifica se está na página inicial
$is_front_page = is_front_page();
?>

<section id="cases" class="container section-container cases">
  <header
    class="section-header d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">

    <h2 class="section-title">
      Cases
    </h2>

    <?php if ($is_front_page): // Exibe o link apenas se NÃO estiver na front-page ?>
      <a href="<?php
      $category = get_category_by_slug('cases');

      if ($category) {
        $category_link = get_category_link($category->term_id);
        echo esc_url($category_link);
      }
      ?>" class="card-link link-text link-primary" title="Acesse todos os cases">
        Acesse todos os cases
        <i class="ms-2 fa-solid fa-arrow-right" aria-hidden="true"></i>
      </a>
    <?php endif; ?>

  </header>

  <?php require_once get_template_directory() . '/loop/cases.php'; ?>
</section>