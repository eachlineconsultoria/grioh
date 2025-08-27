<?php
if ( ! defined('ABSPATH') ) { exit; }
global $wp_query;

$total = (int) $wp_query->max_num_pages;
if ( $total < 2 ) { return; }

$current = max(1, get_query_var('paged') ?: get_query_var('page') ?: 1);

// Números (sempre exibidos)
$links = paginate_links([
  'base'      => str_replace(999999999, '%#%', esc_url( get_pagenum_link(999999999) )),
  'format'    => '',
  'current'   => $current,
  'total'     => $total,
  'type'      => 'array',
  'mid_size'  => 2,
  'end_size'  => 1,
  'prev_next' => false, // prev/next faremos manualmente
]);
?>
<nav class="pagination" role="navigation" aria-label="Paginação">
  <ul class="pagination-list">
    <?php
    // (intermediária/última) – link para Primeira e Anterior
    if ( $current > 1 ) {
      echo '<li class="first-page"><a href="' . esc_url( get_pagenum_link(1) ) . '" rel="first">Primeira página</a></li>';
      echo '<li class="prev-page"><a href="' . esc_url( get_pagenum_link($current - 1) ) . '" rel="prev">&larr; Página anterior</a></li>';
    }

    // Números
    if ( $links ) {
      foreach ( $links as $link ) {
        echo '<li class="page-num">' . $link . '</li>';
      }
    }

    // (primeira/intermediária) – link para Próxima e Última
    if ( $current < $total ) {
      echo '<li class="next-page"><a href="' . esc_url( get_pagenum_link($current + 1) ) . '" rel="next">Próxima página &rarr;</a></li>';
      echo '<li class="last-page"><a href="' . esc_url( get_pagenum_link($total) ) . '" rel="last">Última página</a></li>';
    }
    ?>
  </ul>
</nav>
