<?php if ( ! function_exists('in_the_loop') || ! in_the_loop() || ! is_main_query() ) { return;} ?>

<?php
// ==== Autor ====
$author_id   = get_the_author_meta('ID');
$author_url  = get_author_posts_url($author_id);
$author_name = get_the_author();

// Gravatar (ajuste o tamanho se quiser)
$avatar_html = get_avatar($author_id, 40, '', esc_attr($author_name), ['class' => 'rounded-circle me-2']);

// ==== Categoria (Yoast primária se existir; senão, primeira) ====
$primary_cat = null;
if (class_exists('WPSEO_Primary_Term')) {
  $primary_term = new WPSEO_Primary_Term('category', get_the_ID());
  $primary_id   = $primary_term->get_primary_term();
  if ($primary_id && !is_wp_error($primary_id)) {
    $primary_cat = get_term($primary_id, 'category');
  }
}
if (!$primary_cat) {
  $cats = get_the_category();
  if (!empty($cats)) {
    $primary_cat = $cats[0];
  }
}

// ==== Tags (HTML já com links) ====
$tags_list = get_the_term_list(get_the_ID(), 'post_tag', '', ', ', '');

// ==== Monta as partes e intercala com "•" ====
$parts = [];

// Autor
$parts[] = sprintf(
  '<a class="author-link fw-semibold" href="%s">%s</a>',
  esc_url($author_url),
  esc_html($author_name)
);

// Categoria
if ($primary_cat) {
  $parts[] = sprintf(
    '<a class="post-category" href="%s">%s</a>',
    esc_url(get_category_link($primary_cat->term_id)),
    esc_html($primary_cat->name)
  );
}

// Tags (já vem com links)
if (!empty($tags_list)) {
  $parts[] = sprintf('<span class="post-tags">%s</span>', $tags_list);
}

// Comentários
if (comments_open()) {
  // mostra contagem (0/1/n) – opcional: troque por texto fixo se preferir
  $count = get_comments_number();
  $label = sprintf(
    _n('%s comentário', '%s comentários', $count, 'grioh'),
    number_format_i18n($count)
  );
  $parts[] = sprintf(
    '<a class="comments-link" href="%s">%s</a>',
    esc_url(get_comments_link()),
    esc_html($label)
  );
}
?>
<div class="entry-meta d-flex align-items-center gap-2 mb-3">
  <span class="author-avatar"><?php echo $avatar_html; ?></span>
  <div class="meta-text d-flex flex-wrap align-items-center">
    <?php
      // imprime as partes com o separador • somente entre itens existentes
      echo implode(
        ' <span class="text-muted mx-2" aria-hidden="true">•</span> ',
        array_filter($parts)
      );
    ?>
  </div>
</div>
