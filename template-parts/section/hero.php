<?php
get_template_part('template-parts/breadcrumbs');

// 🔹 Obtém o grupo ACF (se existir)
$hero_container = get_field('hero_container');

// 🔹 Garante que é um array antes de acessar
$hero_container = is_array($hero_container) ? $hero_container : [];

// 🔹 Extrai os subcampos do grupo
$acf_title       = trim($hero_container['hero_title'] ?? '');
$acf_description = trim($hero_container['hero_description'] ?? '');
$icon_choice     = $hero_container['icon_choice'] ?? '';
$button          = $hero_container['hero_button'] ?? [];

// 🔹 Campos internos do grupo "hero_button"
$link  = esc_url($button['hero_button_link'] ?? '#');
$text  = esc_html($button['hero_button_text'] ?? '');
$icon  = $button['hero_button_icon'] ?? '';
$icon_base = get_template_directory_uri() . '/img/icons/';

// 🔹 Fallback de ícones SVG randômicos
$icons = [
  'square' => 'icon-square.svg',
  'circle' => 'icon-circle.svg',
  'equal'  => 'icon-equal.svg',
  'arrow'  => 'icon-arrow.svg',
];
if (empty($icon_choice)) {
  $icon_choice = array_rand($icons);
}

// 🔹 Condicional para o ícone do botão
if (!(is_home() || is_front_page() || is_page() || is_single())) {
  $icon = 'fa-solid fa-arrow-right';
}

// ==========================================================
// 🔸 Lógica de conteúdo do Hero
// ==========================================================

// 1️⃣ Páginas de taxonomia (categoria, tag, etc.)
if (is_category() || is_tag() || is_tax()) {
  $term = get_queried_object();
  $title = esc_html($term->name ?? '');
  $description = wp_kses_post($term->description ?? '');

// 2️⃣ Páginas com grupo ACF "hero_container" preenchido
} elseif (!empty($acf_title) || !empty($acf_description) || !empty($button)) {
  $title = $acf_title ?: get_the_title();
  $description = $acf_description ?: get_the_excerpt();

// 3️⃣ Páginas sem ACF — usa título e resumo padrão
} else {
  $title = get_the_title();
  $description = get_the_excerpt();
}
?>

<section id="hero" class="container custom-page-header hero container">
  <div class="row">
    <div class="section hero-content position-relative d-flex flex-column justify-content-center align-self-start col-12 col-md-6 mb-3 mb-md-0">

      <?php if (!empty($title)): ?>
        <h1 class="section-title"><?php echo esc_html($title); ?></h1>
      <?php endif; ?>

      <?php if (!empty($description)): ?>
        <p class="section-description"><?php echo wp_kses_post($description); ?></p>
      <?php endif; ?>

      <?php if (!empty($text)): ?>
        <a href="<?php echo $link; ?>" class="hero-link link-text link-primary">
          <?php echo $text; ?>
          <i class="ms-2 <?php echo esc_attr($icon); ?>"></i>
        </a>
      <?php endif; ?>

      <?php if (!empty($icon_choice) && isset($icons[$icon_choice])): ?>
        <div class="hero-icon position-absolute">
          <img src="<?php echo esc_url($icon_base . $icons[$icon_choice]); ?>" 
               alt="Ícone <?php echo esc_attr($icon_choice); ?>" 
               class="custom-icon" />
        </div>
      <?php endif; ?>

    </div>

    <div class="col-12 col-md-6">
      <figure class="hero-image mb-0 h-100">
        <?php if (has_post_thumbnail()): ?>
          <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>"
               class="img-fluid w-100 h-100 rounded object-fit-cover"
               alt="<?php echo esc_attr(get_the_title()); ?>">
        <?php endif; ?>
      </figure>
    </div>
  </div>
</section>
