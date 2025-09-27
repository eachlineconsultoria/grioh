<?php
define('GRIOH_INC', get_template_directory() . '/inc');

$grioh_includes = [
  // padrão
  'template-tags.php',
  'comments.php',
  'media.php',
  'admin-notice.php',
  // configuração do tema
  'enqueue.php',
  'setup.php',
  'assests.php',
  'navigation.php',
  'render-block.php',
  'pattern.php',
  'sidebar.php',
  'breadcrumb.php',
  'helper.php',
  'video_thumbnai.php',
  // administração
  'admin-posts-list.php',
  // administração
  'links.php'
];

foreach ($grioh_includes as $file) {
  $path = GRIOH_INC . '/' . $file;
  if (file_exists($path)) {
    require_once $path;
  } else {
    error_log("GRIOH: arquivo não encontrado: $path");
  }
}





// ativar os links nativos do wordpress
add_filter('pre_option_link_manager_enabled', '__return_true');
