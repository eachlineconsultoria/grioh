<?php if ( ! function_exists('in_the_loop') || ! in_the_loop() || ! is_main_query() ) { return;} ?>

<?php
// Autor
$author_id   = get_the_author_meta('ID');
$author_url  = get_author_posts_url($author_id);
$author_name = get_the_author();

// Gravatar (tamanho ajustável)
$avatar_html = get_avatar($author_id, 40, '', esc_attr($author_name), ['class' => 'rounded-circle me-2']);

// Categoria (pega a primária do Yoast se houver; senão, a primeira)
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

// Tags (como “tag1, tag2”)
$tags_list = get_the_term_list(get_the_ID(), 'post_tag', '', ', ', '');

?>
<div class="entry-meta d-flex align-items-center gap-2 mb-3">
  <!-- Foto do autor -->
  <span class="author-avatar">
    <?php echo $avatar_html; ?>
  </span>

  <!-- Nome do autor (link para author.php) + categoria + tags -->
  <div class="meta-text d-flex flex-wrap align-items-center">
    <a class="author-link fw-semibold me-2"
       href="<?php echo esc_url($author_url); ?>">
       <?php echo esc_html($author_name); ?>
    </a>

    <?php if ($primary_cat) : ?>
      <span class="text-muted me-2">•</span>
      <a class="post-category me-2"
         href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>">
         <?php echo esc_html($primary_cat->name); ?>
      </a>
    <?php endif; ?>

    <?php if (!empty($tags_list)) : ?>
      <span class="text-muted me-2">•</span>
      <span class="post-tags"><?php echo $tags_list; // já vem com links ?></span>
    <?php endif; ?>
  </div>
</div>
