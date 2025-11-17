<?php
/**
 * Template parcial para exibir uma seção de links do Link Manager.
 *
 * Espera receber via `$args`:
 * - link_category_slug (string) – obrigatório
 * - section_id (string)
 * - custom_class (string)
 * - limit (int)
 * - orderby (string)
 * - custom_title (string)
 * - custom_description (string)
 */

if (empty($args['link_category_slug'])) {
  echo '<!-- Erro: link_category_slug é obrigatório. -->';
  return;
}

$link_category_slug = sanitize_title($args['link_category_slug']);

$section_id         = sanitize_title($args['section_id'] ?? 'section-' . $link_category_slug);
$custom_class       = esc_attr($args['custom_class'] ?? '');
$limit              = absint($args['limit'] ?? 6);
$orderby            = sanitize_key($args['orderby'] ?? 'RAND');
$custom_title       = sanitize_text_field($args['custom_title'] ?? '');
$custom_description = $args['custom_description'] ?? '';

// 🔎 Busca a categoria
$link_cat = get_term_by('slug', $link_category_slug, 'link_category');
if (!$link_cat) {
  echo '<!-- Categoria não encontrada para slug "' . esc_html($link_category_slug) . '" -->';
  return;
}

// 🔗 Busca os links da categoria
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

// 📌 Título e descrição com fallback
$title       = $custom_title ?: $link_cat->name;
$description = $custom_description ?: $link_cat->description;
?>

<section id="<?php echo esc_attr($section_id); ?>"
         class="container section-container <?php echo $custom_class; ?>"
         role="region"
         aria-labelledby="<?php echo esc_attr($section_id); ?>-title">

  <header class="section-header mb-5">
    <h2 id="<?php echo esc_attr($section_id); ?>-title" class="section-title mb-0">
      <?php echo esc_html($title); ?>
    </h2>

    <?php if (!empty($description)) : ?>
      <div class="section-description my-0">
        <?php echo wp_kses_post(trim($description)); ?>
      </div>
    <?php endif; ?>
  </header>

  <ul class="link-list list-unstyled d-flex flex-wrap justify-content-center gap-4 mb-0">
    <?php foreach ($bookmarks as $bookmark) : ?>
      <?php
        $link_name  = esc_html($bookmark->link_name);
        $link_url   = esc_url($bookmark->link_url);
        $link_image = esc_url($bookmark->link_image);
      ?>
      
      <li class="link-list-item border rounded-circle overflow-hidden"
          aria-label="<?php echo esc_attr($link_name); ?>">

        <a href="<?php echo $link_url; ?>"
           class="d-block w-100 h-100 rounded-circle"
           target="_blank"
           rel="noopener noreferrer"
           style="background-image: url('<?php echo $link_image; ?>');">

          <span class="visually-hidden"><?php echo $link_name; ?></span>
        </a>

      </li>
    <?php endforeach; ?>
  </ul>

</section>
