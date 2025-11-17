<?php

/**
 * Template partial para exibir uma seção de links do Link Manager.
 *
 * Parâmetros esperados:
 * - $link_category_slug (string): slug da categoria de links (ex: 'premios', 'parceiros')
 * - $section_id (string): ID da section HTML (ex: 'prizes', 'partners')
 * - $custom_class (string): classes adicionais da section
 * - $limit (int): quantidade máxima de links (default: 6)
 */

if (!defined('ABSPATH')) exit;

// ---------------------------
// 🔒 Validação básica
// ---------------------------
if (empty($link_category_slug)) {
  echo '<!-- Erro: Parâmetro "link_category_slug" é obrigatório. -->';
  return;
}

// Sanitiza entradas
$section_id   = !empty($section_id)   ? sanitize_title($section_id)   : 'section-' . sanitize_title($link_category_slug);
$custom_class = !empty($custom_class) ? sanitize_html_class($custom_class) : '';
$limit        = isset($limit) ? (int) $limit : 6;
$limit        = max(1, $limit); // impede valores abaixo de 1
$orderby      = !empty($orderby) ? sanitize_text_field($orderby) : 'RAND';

// ---------------------------
// 🔍 Busca categoria
// ---------------------------
$link_cat = get_term_by('slug', $link_category_slug, 'link_category');

if (!$link_cat || is_wp_error($link_cat)) {
  echo '<!-- Categoria de link inválida: ' . esc_html($link_category_slug) . ' -->';
  return;
}

// ---------------------------
// 🔗 Consulta bookmarks
// ---------------------------
$bookmarks = get_bookmarks([
  'category' => $link_cat->term_id,
  'orderby'  => $orderby,
  'order'    => 'ASC',
  'limit'    => $limit,
]);

if (empty($bookmarks)) {
  echo '<!-- Nenhum link encontrado para "' . esc_html($link_category_slug) . '". -->';
  return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>"
  class="container section-container <?php echo esc_attr($custom_class); ?>">

  <header class="section-header text-center mb-5">
    <h2 class="section-title mb-0"><?php echo esc_html($link_cat->name); ?></h2>

    <?php if (!empty($link_cat->description)) : ?>
      <div class="section-description my-0 mx-auto">
        <?php echo wp_kses_post(trim($link_cat->description)); ?>
      </div>
    <?php endif; ?>
  </header>

  <ul class="link-list list-unstyled d-flex flex-wrap justify-content-center gap-4 mb-0" role="list">
    <?php foreach ($bookmarks as $bookmark) :

      // fallback de imagem (garante markup consistente)
      $image_url = !empty($bookmark->link_image)
        ? esc_url($bookmark->link_image)
        : esc_url(get_template_directory_uri() . '/assets/img/placeholder.svg');

      // título acessível
      $label = !empty($bookmark->link_name)
        ? esc_attr($bookmark->link_name)
        : __('Link externo', 'eachline');
    ?>
      <li class="link-list-item border rounded-circle overflow-hidden" role="listitem">
        <a href="<?php echo esc_url($bookmark->link_url); ?>"
          class="d-block w-100 h-100 rounded-circle link-item"
          style="background-image: url('<?php echo $image_url; ?>');"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="<?php echo $label; ?>">

          <span class="visually-hidden"><?php echo esc_html($bookmark->link_name); ?></span>
        </a>
      </li>

    <?php endforeach; ?>
  </ul>

</section>