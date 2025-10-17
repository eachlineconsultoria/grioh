<?php
get_header();
// Template name: Página inicial

?>

<main>

  <?php require_once get_template_directory() . '/section/hero.php'; ?>
  
  <?php require_once get_template_directory() . '/section/partners.php'; ?>

  <section id="partners" class="container section-container cases">
    <header class="section-header d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
      <h2 class="section-title">Clientes</h2>
      <a href="<?php $slug = 'historias-sucesso'; $category = get_category_by_slug($slug); if ($category) {echo get_category_link($category->term_id);}?>" class="card-link link link-primario">Acesse todos os cases<i class="ms-2 fa-solid fa-arrow-right"></i></a>
    </header>
    <?php require_once get_template_directory() . '/loop/cases.php'; ?>
  </section>

  <?php require_once get_template_directory() . '/section/cta.php'; ?>



  <section id="articles" class="container section-container articles">
    <header class="section-header flex-column flex-md-row d-flex align-items-center justify-content-center justify-content-md-between">
      <h2 class="section-title">Artigos</h2>
      <a href="<?php $slug = 'artigos'; $category = get_category_by_slug($slug); if ($category) { echo get_category_link($category->term_id); } ?>" class="card-link link link-primario">Leia todos os artigos<i class="ms-2 fa-solid fa-arrow-right"></i></a>
    </header>
    <?php require_once get_template_directory() . '/loop/articles.php'; ?>
  </section>




</main>

<?php
get_footer();
