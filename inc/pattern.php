<?php 
// [pattern id="123"]  -> renderiza um Padrão Sincronizado (wp_block) pelo ID
add_shortcode('pattern', function($atts){
  $id = isset($atts['id']) ? intval($atts['id']) : 0;
  if (!$id) return '';

  $block = get_post($id);
  if (!$block || $block->post_type !== 'wp_block') return '';

  // Renderiza o bloco sincronizado via do_blocks
  $comment = '<!-- wp:block {"ref":'.$id.'} /-->';
  return do_blocks($comment);
});
