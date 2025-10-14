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

<main class="container">
  <section id="hero" class="custom-page-header hero row">
    <div
      class="section hero-content position-relative d-flex flex-column justify-content-center align-self-start col-12 col-md-6 mb-3 mb-md-0">
      <h1 class="section-title"><?php echo esc_html($title); ?></h1>
      <p class="section-description"><?php echo esc_html($description); ?></p>
      <a href="<?php echo esc_url($button_link); ?>"
        class="d-inline-flex align-items-center d-inline-flex link link-primario">
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
  </section>

  <?php require_once get_template_directory() . '/section/partners.php'; ?>
</main>

<?php
get_footer();
