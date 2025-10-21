<?php
/**
 * Template partial para exibir uma seção de links do Link Manager.
 *
 * Parâmetros esperados:
 * - $link_category_slug (string): slug da categoria de links (ex: 'premios', 'parceiros')
 * - $section_id (string): ID da section HTML (ex: 'prizes', 'partners')
 * - $custom_class (string): classes adicionais da section
 * - $limit (int): quantidade máxima de links (padrão: 6)
 */

// Protege o acesso direto
if (!isset($link_category_slug) || empty($link_category_slug)) {
  echo '<!-- Erro: Parâmetro "link_category_slug" é obrigatório. -->';
  return;
}

$section_id = $section_id ?? 'section-' . sanitize_title($link_category_slug);
$custom_class = $custom_class ?? '';
$limit = $limit ?? 6;

// Recupera a categoria
$link_cat = get_term_by('slug', $link_category_slug, 'link_category');

if (!$link_cat || is_wp_error($link_cat)) {
  echo '<!-- Categoria de link inválida. -->';
  return;
}

$bookmarks = get_bookmarks(array(
  'category' => $link_cat->term_id,
  'orderby' => 'RAND',
  'order' => 'ASC',
  'limit' => $limit
));

if (!$bookmarks || count($bookmarks) === 0) {
  echo '<!-- Nenhum link encontrado para "' . esc_html($link_category_slug) . '". -->';
  return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>"
  class="container section-container <?php echo esc_attr($custom_class); ?>">
  <header class="section-header text-center">
    <h2 class="section-title"><?php echo esc_html($link_cat->name); ?></h2>

    <?php if (!empty($link_cat->description)): ?>
      <div class="section-description">
        <?php echo wp_kses_post(wpautop($link_cat->description)) ?>
      </div>
    <?php endif; ?>
  </header>

  <ul class="link-list m-0 d-flex flex-wrap justify-content-center gap-4">
    <?php foreach ($bookmarks as $bookmark): ?>
      <li class="link-list-item border rounded-circle overflow-hidden">
        <a class="d-block w-100 h-100 rounded-circle" href="<?php echo esc_url($bookmark->link_url); ?>" target="_blank"
          rel="noopener" title="<?php echo esc_html($bookmark->link_name); ?>"
          style="background-image: url(<?php echo esc_url($bookmark->link_image); ?>);">
          <span class="visually-hidden"><?php echo esc_html($bookmark->link_name); ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>