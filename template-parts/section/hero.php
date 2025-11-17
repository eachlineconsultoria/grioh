<?php
/*
// ==========================================================
// 1) ACF: HERO CONTAINER
// ==========================================================
*/
$hero_container = get_field('hero_container') ?: [];

$acf_title       = trim($hero_container['hero_title'] ?? '');
$acf_description = trim($hero_container['hero_description'] ?? '');
$button          = $hero_container['hero_button'] ?? [];
$icon_choice     = $hero_container['icon_choice'] ?? '';

$link = !empty($button['hero_button_link']) ? esc_url($button['hero_button_link']) : '#';
$text = trim($button['hero_button_text'] ?? '');
$icon = $button['hero_button_icon'] ?? '';

$icon_base = get_template_directory_uri() . '/img/icons/';

$icons = [
  'square' => 'icon-square.svg',
  'circle' => 'icon-circle.svg',
  'equal'  => 'icon-equal.svg',
  'arrow'  => 'icon-arrow.svg',
];

// fallback do ícone do bloco
if (!$icon_choice || !isset($icons[$icon_choice])) {
  $icon_choice = array_rand($icons);
}

// fallback do ícone do botão para páginas não principais
if (!(is_home() || is_front_page() || is_page() || is_single())) {
  $icon = 'fa-solid fa-arrow-right';
}


// ==========================================================
// 2) TÍTULO & DESCRIÇÃO
// ==========================================================

if (is_category() || is_tag() || is_tax()) {
  $term        = get_queried_object();
  $title       = esc_html($term->name ?? '');
  $description = wp_kses_post($term->description ?? '');

  // Ajustes para Taxonomias
  $text = 'Confira';
  $icon = 'fa-solid fa-arrow-down';
  $link = '#content';

} elseif ($acf_title || $acf_description) {

  $title       = $acf_title ?: get_the_title();
  $description = $acf_description ?: get_the_excerpt();

} else {

  $title       = get_the_title();
  $description = get_the_excerpt();
}


// ==========================================================
// 3) IMAGEM DO HERO (com fallback)
// ==========================================================

$hero_image_url = '';

/* 1) Single de "serviços" */
if (is_single() && has_post_thumbnail() && has_category('servicos')) {
  $hero_image_url = get_the_post_thumbnail_url(null, 'large');
}

/* 2) Taxonomias */
elseif (is_category() || is_tag() || is_tax()) {
  $term        = get_queried_object();
  $image_field = get_field('category_image', $term);

  if (!empty($image_field)) {
    $hero_image_url = is_array($image_field)
      ? ($image_field['url'] ?? '')
      : $image_field;
  }
}

/* 3) Páginas */
elseif (is_page() && has_post_thumbnail()) {
  $hero_image_url = get_the_post_thumbnail_url(null, 'large');
}

/* 4) Fallback final */
if (empty($hero_image_url)) {
  $hero_image_url = get_template_directory_uri() . '/img/hero-default.jpg';
}

$hero_image_url = esc_url($hero_image_url);

?>

<section id="hero" class="custom-page-header hero container">
  <div class="row">

    <div class="hero-content col-12 col-md-6 d-flex flex-column justify-content-center position-relative mb-3 mb-md-0">

      <?php if (!empty($title)): ?>
        <h1 class="section-title"><?php echo esc_html($title); ?></h1>
      <?php endif; ?>

      <?php if (!empty($description)): ?>
        <p class="section-description"><?php echo wp_kses_post($description); ?></p>
      <?php endif; ?>

      <?php if (!empty($text)): ?>
        <a href="<?php echo esc_url($link); ?>" class="hero-link link-text link-primary">
          <?php echo esc_html($text); ?>
          <?php if (!empty($icon)): ?>
            <i class="ms-2 <?php echo esc_attr($icon); ?>"></i>
          <?php endif; ?>
        </a>
      <?php endif; ?>

      <?php if (!empty($icons[$icon_choice])): ?>
        <div class="hero-icon position-absolute">
          <img 
            src="<?php echo esc_url($icon_base . $icons[$icon_choice]); ?>" 
            alt=""
            aria-hidden="true"
            class="border-0"
            loading="lazy"
          >
        </div>
      <?php endif; ?>

    </div>

    <div class="col-12 col-md-6">
      <figure class="hero-image mb-0 h-100">
        <img 
          src="<?php echo $hero_image_url; ?>" 
          class="img-fluid w-100 h-100 rounded object-fit-cover"
          alt="<?php echo esc_attr($title); ?>"
          loading="eager"
          decoding="async"
        >
      </figure>
    </div>

  </div>
</section>
