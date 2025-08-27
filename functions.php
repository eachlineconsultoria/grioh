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
  // administração
  'admin-posts-list.php'
];

foreach ($grioh_includes as $file) {
  $path = GRIOH_INC . '/' . $file;
  if (file_exists($path)) {
    require_once $path;
  } else {
    error_log("GRIOH: arquivo não encontrado: $path");
  }
}
