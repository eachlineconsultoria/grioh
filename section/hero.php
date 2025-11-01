<?php
require get_template_directory() . '/section/breadcrumbs.php';


$hero_container = get_field('hero_container'); // grupo principal

$title = trim($hero_container['hero_title'] ?? '') ?: get_the_title();
$description = trim($hero_container['hero_description'] ?? '') ?: get_the_excerpt();
$icon_choice = $hero_container['icon_choice'] ?? '';
$button = $hero_container['hero_button'] ?? [];

$link = esc_url($button['hero_button_link'] ?? '#');
$text = esc_html($button['hero_button_text'] ?? '');
$icon = $button['hero_button_icon'] ?? '';
$icon_base = get_template_directory_uri() . '/assets/img/icons/';
?>
<section id="hero" class="container custom-page-header hero container">
  <div class="row">
    <div
      class="section hero-content position-relative d-flex flex-column justify-content-center align-self-start col-12 col-md-6 mb-3 mb-md-0">

      <?php if ($title): ?>
        <h1 class="section-title"><?php echo esc_html($title); ?></h1>
      <?php endif; ?>

      <?php if ($description): ?>
        <p class="section-description"><?php echo wp_kses_post($description); ?></p>
      <?php endif; ?>

      <?php if ($text): ?>
        <a href="<?php echo $link; ?>" class="hero-link link-text link-primary">
          <?php echo $text; ?>
          <i class="ms-2 <?php echo esc_attr($icon ?: 'fa-solid fa-arrow-right'); ?>"></i>
        </a>
      <?php endif; ?>

      <?php if ($icon_choice): ?>
        <div class="hero-icon position-absolute">
          <?php
          $icons = [
            'square' => 'icon-square.svg',
            'circle' => 'icon-circle.svg',
            'equal' => 'icon-equal.svg',
            'arrow' => 'icon-arrow.svg',
          ];
          if (isset($icons[$icon_choice])) {
            printf(
              '<img src="%s%s" alt="Ícone %s" class="custom-icon" />',
              esc_url($icon_base),
              esc_attr($icons[$icon_choice]),
              esc_attr($icon_choice)
            );
          }
          ?>
        </div>
      <?php endif; ?>

    </div>
    <div class="col-12 col-md-6">
            <figure class="hero-image mb-0 h-100">
        <?php if (has_post_thumbnail()): ?>
          <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>"
            class="img-fluid w-100 h-100 rounded object-fit-cover" alt="<?php echo esc_attr(get_the_title()); ?>">
        <?php endif; ?>
      </figure>
    </div>
  </div>
</section>