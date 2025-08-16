<?php
// Define versão do tema para cache-busting
define('GRIOH_VERSION', wp_get_theme()->get('Version') ?: '1.0.0');

// Carrega módulos
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/comments.php';
require_once get_template_directory() . '/inc/media.php';
require_once get_template_directory() . '/inc/admin-notice.php';
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/navigation.php';