<?php
get_header();
// Template name: Página inicial
// Pega campos ACF
$title = get_field('custom_header_title');
$description = get_field('custom_header_description');
$button_text = get_field('custom_button_text');
$button_link = get_field('custom_button_link');
$icon_choice = get_field('custom_icon_choice');
?>

<main>
  <section id="hero" class="container custom-page-header hero container">
    <div class="row">
      <div
        class="section hero-content position-relative d-flex flex-column justify-content-center align-self-start col-12 col-md-6 mb-3 mb-md-0">
        <h1 class="section-title"><?php echo esc_html($title); ?></h1>
        <p class="section-description"><?php echo esc_html($description); ?></p>
        <a href="<?php echo esc_url($button_link); ?>" class="hero-link link link-primario">
          <?php echo esc_html($button_text); ?><i class="ms-2 fa-solid fa-arrow-right"></i>
        </a>
        <?php if ($icon_choice): ?>
          <div class="hero-icon position-absolute">
            <?php
            $icon_base = get_template_directory_uri() . '/assets/img/icons/';

            switch ($icon_choice) {
              case 'square':
                echo '<img src="' . $icon_base . 'icon-square.svg" alt="Ícone quadrado" class="custom-icon" />';
                break;
              case 'circle':
                echo '<img src="' . $icon_base . 'icon-circle.svg" alt="Ícone círculo" class="custom-icon" />';
                break;
              case 'equal':
                echo '<img src="' . $icon_base . 'icon-equal.svg" alt="Ícone igual" class="custom-icon" />';
                break;
              case 'arrow':
                echo '<img src="' . $icon_base . 'icon-arrow.svg" alt="Ícone seta" class="custom-icon" />';
                break;
            }
            ?>

          </div>
        <?php endif; ?>
      </div>

      <figure class="hero-picture col-12 col-md-6 position-relative">
        <?php if (has_post_thumbnail()): ?>
          <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid w-100 h-100 rounded object-fit-cover"
            alt="">
        <?php endif; ?>


      </figure>
    </div>
  </section>

  <?php require_once get_template_directory() . '/section/partners.php'; ?>

  <section id="partners" class="container section-container cases">
    <header class="section-header d-flex align-items-center justify-content-center justify-content-md-between">
      <h2 class="section-title">Clientes</h2>
      <a href="<?php $slug = 'historias-sucesso'; $category = get_category_by_slug($slug); if ($category) {echo get_category_link($category->term_id);}?>" class="card-link link link-primario">Acesse todos os cases<i class="ms-2 fa-solid fa-arrow-right"></i></a>
    </header>
    <?php require_once get_template_directory() . '/loop/cases.php'; ?>
  </section>

  <?php require_once get_template_directory() . '/section/cta.php'; ?>



  <section id="articles" class="container section-container articles">
    <header class="section-header d-flex align-items-center justify-content-center justify-content-md-between">
      <h2 class="section-title">Artigos</h2>

      <a href="
    <?php
    $slug = 'artigos';

    $category = get_category_by_slug($slug);
    if ($category) {
      echo get_category_link($category->term_id);
    }
    ?>" class="card-link link link-primario">Leia todos os artigos<i class="ms-2 fa-solid fa-arrow-right"></i></a>

    </header>
    <?php require_once get_template_directory() . '/loop/articles.php'; ?>
  </section>




</main>

<?php
get_footer();
