<?php
get_header();
// Template name: Página inicial

?>

<main>

  <?php require_once get_template_directory() . '/section/hero.php'; ?>

  <?php
  // parceiros
  if (get_field('partners_section')):


    $link_category_slug = 'parceiros';
    $section_id = 'partners';
    $custom_class = 'partners';
    $limit = '6';

    include get_template_directory() . '/section/section-links.php';
    ?>
  <?php endif; ?>

  <?php
  // Cases
  $limit = 1;
  require_once get_template_directory() . '/section/cases.php';

  // CTA
  require_once get_template_directory() . '/section/cta.php'; ?>

  <section id="articles" class="container section-container articles">
    <header
      class="section-header flex-column flex-md-row d-flex align-items-center justify-content-center justify-content-md-between">
      <h2 class="section-title">Artigos</h2>
      <a href="<?php $slug = 'artigos';
      $category = get_category_by_slug($slug);
      if ($category) {
        echo get_category_link($category->term_id);
      } ?>" class="card-link link-text link-primary">Leia todos os artigos<i
          class="ms-2 fa-solid fa-arrow-right"></i></a>
    </header>
    <?php require_once get_template_directory() . '/loop/articles.php'; ?>
  </section>




</main>

<?php
get_footer();
