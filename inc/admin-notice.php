<?php
/**
 * Aviso administrativo (ex.: mensagem de boas-vindas)
 * Remova este arquivo quando não for mais necessário.
 * @package grioh
 */

add_action('admin_notices', function () {
  if (!current_user_can('manage_options')) return;

  $user_id = get_current_user_id();
  $meta_key = 'grioh_notice_dismissed_12';

  if (get_user_meta($user_id, $meta_key, true)) return;

  // URL para dispensar o aviso
  $dismiss_url = add_query_arg('grioh_dismiss', '1', esc_url_raw($_SERVER['REQUEST_URI']));

  echo '<div class="notice notice-info is-dismissible grioh-admin-notice">'
     . '<p style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;">'
     . wp_kses_post(__('<strong>🏆 Obrigado por usar o tema Grioh (base BlankSlate)!</strong>', 'grioh'))
     . ' <a href="' . esc_url($dismiss_url) . '" class="button-link" style="text-decoration:none"><big>Ⓧ</big></a>'
     . '</p></div>';
});

add_action('admin_init', function () {
  if (isset($_GET['grioh_dismiss']) && current_user_can('manage_options')) {
    add_user_meta(get_current_user_id(), 'grioh_notice_dismissed_12', 'true', true);
  }
});
