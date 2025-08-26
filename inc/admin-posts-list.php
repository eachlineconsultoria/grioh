<?php
// 1) Inserir a coluna "Thumb" logo após o checkbox
add_filter('manage_edit-post_columns', function ($columns) {
  $new = [];
  foreach ($columns as $key => $label) {
    $new[$key] = $label;
    if ($key === 'cb') { // após o checkbox
      $new['thumb'] = __('Thumb', 'grioh');
    }
  }
  return $new;
}, 20);

// 2) Preencher a coluna com o thumbnail
add_action('manage_post_posts_custom_column', function ($column, $post_id) {
  if ($column === 'thumb') {
    if (has_post_thumbnail($post_id)) {
      echo get_the_post_thumbnail(
        $post_id,
        'thumbnail',
        ['style' => 'width:60px;height:60px;object-fit:cover;border-radius:6px']
      );
    } else {
      echo '<span style="color:#999">—</span>';
    }
  }
}, 10, 2);

// 3) CSS para ajustar largura
add_action('admin_head', function () {
  $screen = get_current_screen();
  if ($screen && $screen->id === 'edit-post') {
    echo '<style>
          .column-thumb{ width:80px; }
        </style>';
  }
});
