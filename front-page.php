<?php
get_header();
// Template name: Página inicial

?>

<main>

  <?php require_once get_template_directory() . '/section/hero.php'; ?>

  <?php
  if (get_field('partners_section')):

    $link_category_slug = 'parceiros';
    $section_id = 'partners';
    $custom_class = 'partners';
    $limit = 6;

    include get_template_directory() . '/section/section-links.php';

  endif;
  ?>


  <?php /* Cases */ $limit = 1;
  require_once get_template_directory() . '/section/cases.php'; ?>

  <?php /* CTA */ require_once get_template_directory() . '/section/cta.php'; ?>

  <?php
  // Configurações da seção
  $section_id = 'articles';
  $category_slug = 'artigos';
  $section_title = 'Artigos';
  $limit = 3;

  // Monta link da categoria dinamicamente
  $category = get_category_by_slug($category_slug);
  $category_link = $category ? get_category_link($category->term_id) : '#';
  ?>

  <section id="<?php echo esc_attr($section_id); ?>"
    class="container section-container <?php echo esc_attr($section_id); ?>">
    <header
      class="section-header d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
      <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>

      <a href="<?php echo esc_url($category_link); ?>" class="card-link link-text link-primary">
        Leia todos os artigos
        <i class="ms-2 fa-solid fa-arrow-right" aria-hidden="true"></i>
      </a>
    </header>

    <?php
    // Parâmetros que serão usados dentro do loop
    $loop_args = [
      'post_type' => 'post',
      'posts_per_page' => $limit,
      'category_name' => $category_slug,
      'orderby' => 'date',
      'order' => 'DESC',
    ];

    include get_template_directory() . '/loop/articles.php';
    ?>
  </section>

</main>

<?php
get_footer();
