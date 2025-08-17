<?php
/**
 * Renderiza o primeiro bloco de uma página que combine por nome do bloco e/ou anchor.
 *
 * @param int    $post_id   ID da página/post que contém o bloco
 * @param string $block_name Ex.: 'core/cover', 'core/group' (opcional)
 * @param string $anchor     Anchor do bloco (em "Configurações avançadas" do bloco) (opcional)
 * @return string HTML renderizado do bloco (ou string vazia)
 */
function grioh_render_block_from_post($post_id, $block_name = '', $anchor = '')
{
  $content = get_post_field('post_content', $post_id);
  if (!$content)
    return '';

  $blocks = parse_blocks($content);

  // busca recursiva
  $find = function ($blocks) use (&$find, $block_name, $anchor) {
    foreach ($blocks as $block) {
      $name_ok = $block_name ? ($block['blockName'] === $block_name) : true;
      $anchor_ok = $anchor ? (isset($block['attrs']['anchor']) && $block['attrs']['anchor'] === $anchor) : true;

      if ($name_ok && $anchor_ok) {
        return render_block($block);
      }

      if (!empty($block['innerBlocks'])) {
        $inner = $find($block['innerBlocks']);
        if ($inner)
          return $inner;
      }
    }
    return '';
  };

  return $find($blocks);
}
