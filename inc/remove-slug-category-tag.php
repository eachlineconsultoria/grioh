<?php // Remove /category/ da URL
function remover_slug_categoria($category_link, $category_id)
{
  $category = get_category($category_id);
  if ($category->parent == 0) {
    $category_link = str_replace('/category/', '/', $category_link);
  }
  return $category_link;
}
add_filter('category_link', 'remover_slug_categoria', 10, 2);

// Remove /tag/ da URL
function remover_slug_tag($tag_link, $tag_id)
{
  $tag = get_tag($tag_id);
  return str_replace('/tag/', '/', $tag_link);
}
add_filter('tag_link', 'remover_slug_tag', 10, 2);

// Reescreve regras para categoria e tag sem prefixo
function rewrite_sem_prefixo()
{
  add_rewrite_rule('^(.+?)$', 'index.php?category_name=$matches[1]', 'top');
  add_rewrite_rule('^(.+?)$', 'index.php?tag=$matches[1]', 'top');
}
add_action('init', 'rewrite_sem_prefixo');

// Corrige conflitos com páginas que tenham o mesmo nome de categoria/tag
function evitar_conflitos_cat_tag($query)
{
  if (!is_admin() && $query->is_main_query()) {
    if ($query->is_category || $query->is_tag) {
      $query->set('name', '');
    }
  }
}
add_action('pre_get_posts', 'evitar_conflitos_cat_tag');
