<?php
function grioh_register_sidebars()
{
  $sidebars = [
    [
      'name' => __('CTA 1 (index)', 'grioh'),
      'id' => 'cta-1',
      'description' => __('', 'grioh'),
    ],
    [
      'name' => __('Consultoria (Index)', 'grioh'),
      'id' => 'service-area',
      'description' => __('Espaço para inserir os blocos sincronizado da seção: Consultoria', 'grioh'),
    ],
    [
      'name' => __('Redes sociais (Rodapé)', 'grioh'),
      'id' => 'footer-social',
      'description' => __('Espaço para inserir os links das redes sociais do rodapé', 'grioh'),
    ],
    [
      'name' => __('Sidebar páginas', 'grioh'),
      'id' => 'sidebar-page',
      'description' => __('Espaço para inserir os widgets nas páginas', 'grioh'),
    ],

  ];

  foreach ($sidebars as $sb) {
    register_sidebar(array_merge([
      'before_widget' => '<div id="%1$s" class="widget %2$s mb-4">',
      'after_widget' => '</div>',
      'before_title' => '<h2 class="widget-title h5 mb-3">',
      'after_title' => '</h2>',
    ], $sb));
  }
}
add_action('widgets_init', 'grioh_register_sidebars');
