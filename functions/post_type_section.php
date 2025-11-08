<?php /*function registrar_cpt_secoes()
{
  $labels = array(
    'name' => 'Seções',
    'singular_name' => 'Seção',
  );

  $args = array(
    'labels' => $labels,
    'public' => false,             // 🔒 não acessível publicamente
    'show_ui' => true,              // ✅ aparece no painel
    'show_in_menu' => true,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => false,
    'exclude_from_search' => true,
    'publicly_queryable' => false,
    'rewrite' => false,
    'menu_icon' => 'dashicons-layout',

    // ✳️ Configurações para usar o editor moderno
    'show_in_rest' => true,              // ✅ habilita o Gutenberg
    'rest_base' => 'secoes',          // endpoint da API REST
    'supports' => array(
      'title',
      'editor',          // habilita editor de blocos
      'thumbnail',
      'excerpt',
      'revisions',
      'custom-fields',   // habilita campos personalizados nativos
      'page-attributes'
    ),
  );

  register_post_type('secoes', $args);
}
add_action('init', 'registrar_cpt_secoes');


function registrar_taxonomia_secoes()
{
  $labels = array(
    'name' => 'Categorias de Seções',
    'singular_name' => 'Categoria de Seção',
  );

  $args = array(
  'public' => false,
  'show_ui' => true,
  'show_in_menu' => true,
  'show_in_rest' => true,     
  'menu_icon' => 'dashicons-screenoptions',
  'supports' => [ 'title', 'editor', 'thumbnail', 'revisions' ],
  'capability_type' => 'page',
  'map_meta_cap' => true,);

  register_taxonomy('secao_categoria', array('secoes'), $args);
}
add_action('init', 'registrar_taxonomia_secoes');
*/ ?>