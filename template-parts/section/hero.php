<?php
get_template_part('template-parts/breadcrumbs');

// 🔹 Obtém o grupo ACF (se existir)
$hero_container = get_field('hero_container');

// 🔹 Garante que é um array antes de acessar
$hero_container = is_array($hero_container) ? $hero_container : [];

// 🔹 Extrai os subcampos do grupo
$acf_title = trim($hero_container['hero_title'] ?? '');
$acf_description = trim($hero_container['hero_description'] ?? '');
$icon_choice = $hero_container['icon_choice'] ?? '';
$button = $hero_container['hero_button'] ?? [];

// 🔹 Campos internos do grupo "hero_button"
$link = esc_url($button['hero_button_link'] ?? '#');
$text = esc_html($button['hero_button_text'] ?? '');
$icon = $button['hero_button_icon'] ?? '';
$icon_base = get_template_directory_uri() . '/img/icons/';

// 🔹 Fallback de ícones SVG randômicos
$icons = [
  'square' => 'icon-square.svg',
  'circle' => 'icon-circle.svg',
  'equal' => 'icon-equal.svg',
  'arrow' => 'icon-arrow.svg',
];
if (empty($icon_choice)) {
  $icon_choice = array_rand($icons);
}

// 🔹 Condicional para o ícone do botão
if (!(is_home() || is_front_page() || is_page() || is_single())) {
  $icon = 'fa-solid fa-arrow-right';
}

// ==========================================================
// 🔸 Conteúdo textual do Hero
// ==========================================================
if (is_category() || is_tag() || is_tax()) {
  $term = get_queried_object();
  $title = esc_html($term->name ?? '');
  $description = wp_kses_post($term->description ?? '');
} elseif (!empty($acf_title) || !empty($acf_description) || !empty($button)) {
  $title = $acf_title ?: get_the_title();
  $description = $acf_description ?: get_the_excerpt();
} else {
  $title = get_the_title();
  $description = get_the_excerpt();
}

// ==========================================================
// 🔸 Lógica da imagem do Hero (com fallback final)
// ==========================================================
$hero_image_url = '';

if (is_single() && has_post_thumbnail() && has_category('servicos')) {
  // 1️⃣ Featured image de posts da categoria "servicos"
  $hero_image_url = esc_url(get_the_post_thumbnail_url(null, 'large'));

} elseif (is_category() || is_tag() || is_tax()) {
  // 2️⃣ Imagem do ACF da categoria/tag
  $term = get_queried_object();
  $image_field = get_field('category_image', $term);
  if (!empty($image_field)) {
    $hero_image_url = is_array($image_field)
      ? esc_url($image_field['url'])
      : esc_url($image_field);
  }

} elseif (is_page() && has_post_thumbnail()) {
  // 3️⃣ Imagem destacada da página
  $hero_image_url = esc_url(get_the_post_thumbnail_url(null, 'large'));
}

// 4️⃣ Fallback final (imagem padrão do tema)
if (empty($hero_image_url)) {
  $hero_image_url = get_template_directory_uri() . '/img/hero-default.jpg';
}
?>

<section id="hero" class="container custom-page-header hero container">
  <div class="row">
    <div
      class="section hero-content position-relative d-flex flex-column justify-content-center align-self-start col-12 col-md-6 mb-3 mb-md-0">

      <?php if (!empty($title)): ?>
        <h1 class="section-title"><?php echo esc_html($title); ?></h1>
      <?php endif; ?>

      <?php if (!empty($description)): ?>
        <p class="section-description"><?php echo wp_kses_post($description); ?></p>
      <?php endif; ?>

      <?php
      if (is_category() || is_tag() || is_tax()) {
        $text = 'Confira';
        $icon = 'fa-solid fa-arrow-down';
        $link = '#content';
      }
      ?>

      <?php if (!empty($text)): ?>
        <a href="<?php echo $link; ?>" class="hero-link link-text link-primary">
          <?php echo $text; ?>
          <i class="ms-2 <?php echo esc_attr($icon); ?>"></i>
        </a>
      <?php endif; ?>


      <?php if (!empty($icon_choice) && isset($icons[$icon_choice])): ?>
        <div class="hero-icon position-absolute">
          <img src="<?php echo esc_url($icon_base . $icons[$icon_choice]); ?>"
            alt="Ícone <?php echo esc_attr($icon_choice); ?>" class="border-0" />
        </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($hero_image_url)): ?>
      <div class="col-12 col-md-6">
        <figure class="hero-image mb-0 h-100">
          <img src="<?php echo $hero_image_url; ?>" class="img-fluid w-100 h-100 rounded object-fit-cover"
            alt="<?php echo esc_attr($title); ?>">
        </figure>
      </div>
    <?php endif; ?>
  </div>
</section>