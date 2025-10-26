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

if (empty($link_category_slug)) {
  echo '<!-- Erro: Parâmetro "link_category_slug" é obrigatório. -->';
  return;
}

$section_id   = $section_id   ?? 'section-' . sanitize_title($link_category_slug);
$custom_class = $custom_class ?? '';
$limit        = (int)($limit ?? 6);
$orderby      = $orderby      ?? 'RAND';

// Busca a categoria
if (!$link_cat = get_term_by('slug', $link_category_slug, 'link_category')) {
  echo '<!-- Categoria de link inválida: ' . esc_html($link_category_slug) . ' -->';
  return;
}

// Busca os links
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

<section id="<?php echo esc_attr($section_id); ?>" class="container section-container <?php echo esc_attr($custom_class); ?>">
<header class="section-header text-center mb-5">
  <h2 class="section-title mb-0"><?php echo esc_html($link_cat->name); ?></h2>

  <?php if (!empty($link_cat->description)): ?>
    <div class="section-description my-0 mx-auto">
      <?php echo wp_kses_post(trim($link_cat->description)); ?>
    </div>
  <?php endif; ?>
</header>

  <ul class="link-list list-unstyled d-flex flex-wrap justify-content-center gap-4 mb-0">
    <?php foreach ($bookmarks as $bookmark): ?>
      <li class="link-list-item border rounded-circle overflow-hidden" aria-label="<?php echo esc_attr($bookmark->link_name); ?>">
        <a href="<?php echo esc_url($bookmark->link_url); ?>"
           class="d-block w-100 h-100 rounded-circle"
           target="_blank" rel="noopener noreferrer"
           style="background-image: url(<?php echo esc_url($bookmark->link_image); ?>);">
          <span class="visually-hidden"><?php echo esc_html($bookmark->link_name); ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
