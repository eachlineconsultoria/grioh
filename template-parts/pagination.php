<?php
$total_pages = $cases_query->max_num_pages ?? 1;
$current_page = max(1, $paged ?? 1);

if ($total_pages > 1):
  echo '<nav class="pagination mt-4" aria-label="Paginação">';
  echo '<ul class="pagination-list justify-content-center align-items-center">';

  // Primeira página
  if ($current_page > 1) {
    echo '<li class="page-item me-3">';
    echo '<a class="page-link pagination-text" href="' . esc_url(get_pagenum_link(1)) . '" aria-label="Primeira página">';
    echo '<i class="fa-solid fa-arrow-left-long me-2" aria-hidden="true"></i>';
    echo 'Primeira';
    echo '</a>';
    echo '</li>';
  }

  // Anterior
  if ($current_page > 1) {
    echo '<li class="page-item me-3">';
    echo '<a class="page-link pagination-text" href="' . esc_url(get_pagenum_link($current_page - 1)) . '" aria-label="Página anterior">';
    echo '<i class="fa-solid fa-arrow-left me-2" aria-hidden="true"></i>';
    echo 'Anterior';
    echo '</a>';
    echo '</li>';
  }

  // Links numéricos (sem prev/next automáticos)
  $links = paginate_links(array(
    'total' => $total_pages,
    'current' => $current_page,
    'type' => 'array',
    'end_size' => 1,
    'mid_size' => 2,
    'prev_next' => false, // <- impede duplicação de anterior/próxima
  ));

  if ($links) {
    foreach ($links as $link) {
      $active = strpos($link, 'current') !== false ? 'active' : '';
      echo '<li class="page-item me-3 ' . esc_attr($active) . '">' . wp_kses_post($link) . '</li>';
    }
  }

  // Próxima
  if ($current_page < $total_pages) {
    echo '<li class="page-item me-3">';
    echo '<a class="page-link pagination-text" href="' . esc_url(get_pagenum_link($current_page + 1)) . '" aria-label="Próxima página">';
    echo 'Próxima';
    echo '<i class="fa-solid fa-arrow-right ms-2" aria-hidden="true"></i>';
    echo '</a>';
    echo '</li>';
  }

  // Última página
  if ($current_page < $total_pages) {
    echo '<li class="page-item me-0">';
    echo '<a class="page-link pagination-text" href="' . esc_url(get_pagenum_link($total_pages)) . '" aria-label="Última página"> ';
    echo 'Última';
    echo '<i class="fa-solid fa-arrow-right-long ms-2" aria-hidden="true"></i> ';
    echo '</a>';
    echo '</li> ';
  }

  echo '</ul>';
  echo '<p class="text-center mt-4 small text-muted">Página ' . esc_html($current_page) . ' de ' . esc_html($total_pages) . '</p>';
  echo '</nav>';
endif;
