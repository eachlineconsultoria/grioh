<?php
/**
 * Comentários: scripts, contadores e pings
 * @package grioh
 */

// Enfileira o JS de respostas encadeadas (WP core)
add_action('comment_form_before', function () {
  if (get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
});

// Template para pings/trackbacks (use em wp_list_comments: 'type=pings' => grioh_custom_pings)
function grioh_custom_pings($comment) { ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <?php echo esc_url( comment_author_link() ); ?>
  </li>
<?php }

// Conta apenas comentários "comment" (exclui pings) no front
add_filter('get_comments_number', function ($count) {
  if (is_admin()) return $count;
  $comments = get_comments([
    'status'  => 'approve',
    'post_id' => get_the_ID(),
  ]);
  $by_type = separate_comments($comments);
  return isset($by_type['comment']) ? count($by_type['comment']) : 0;
}, 0);
