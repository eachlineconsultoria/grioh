<?php
/**
 * Funções principais do tema Grioh
 */
define('GRIOH_INC', get_template_directory() . '/inc');

$grioh_includes = [
  'template-tags.php',
  'comments.php',
  'media.php',
  'admin-notice.php',
  'enqueue.php',
  'setup.php',
  'assests.php',
  'navigation.php',
  'render-block.php'
];

foreach ($grioh_includes as $file) {
  $path = GRIOH_INC . '/' . $file;
  if (file_exists($path)) {
    require_once $path;
  } else {
    error_log("GRIOH: arquivo não encontrado: $path");
  }
}
