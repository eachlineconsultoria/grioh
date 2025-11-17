<?php 

// SE O arquivo for usado dentro de um template, certifique-se de que $wp_query está no escopo global
global $wp_query;

$total_pages = $wp_query->max_num_pages ?? 1;
$current_page = max(1, get_query_var('paged') ?: 1);

// Monta a base correta dependendo do contexto
if (is_author()) {

    // URL correta para arquivos de autor
    $author_id = get_queried_object_id();
    $base_url = trailingslashit(get_author_posts_url($author_id));
    $base = $base_url . 'page/%#%/';

} elseif (is_category() || is_tax()) {

    // categorias e taxonomias
    $term = get_queried_object();
    $base = trailingslashit(get_term_link($term)) . 'page/%#%/';

} elseif (is_post_type_archive()) {

    // arquivo CPT
    $post_type = get_query_var('post_type');
    $base = trailingslashit(get_post_type_archive_link($post_type)) . 'page/%#%/';

} elseif (is_search()) {

    // busca (usa query string)
    $base = add_query_arg('paged', '%#%');

} else {

    // fallback genérico
    $big = 999999999;
    $base = str_replace($big, '%#%', esc_url(get_pagenum_link($big)));
}

if ($total_pages > 1):

    echo '<nav class="pagination mt-4" aria-label="Paginação">';
    echo '<ul class="pagination-list justify-content-center align-items-center">';

    // Primeira página
    if ($current_page > 1) {
        echo '<li class="page-item me-3">';
        echo '<a class="page-link pagination-text" href="' . esc_url(str_replace('%#%', 1, $base)) . '" aria-label="Primeira página">';
        echo '<i class="fa-solid fa-arrow-left-long me-2" aria-hidden="true"></i> Primeira';
        echo '</a>';
        echo '</li>';
    }

    // Anterior
    if ($current_page > 1) {
        echo '<li class="page-item me-3">';
        echo '<a class="page-link pagination-text" href="' . esc_url(str_replace('%#%', $current_page - 1, $base)) . '" aria-label="Página anterior">';
        echo '<i class="fa-solid fa-arrow-left me-2" aria-hidden="true"></i> Anterior';
        echo '</a>';
        echo '</li>';
    }

    // Links numerados
    $links = paginate_links(array(
        'base'      => $base,
        'format'    => '',
        'current'   => $current_page,
        'total'     => $total_pages,
        'type'      => 'array',
        'end_size'  => 1,
        'mid_size'  => 2,
        'prev_next' => false,
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
        echo '<a class="page-link pagination-text" href="' . esc_url(str_replace('%#%', $current_page + 1, $base)) . '" aria-label="Próxima página">';
        echo 'Próxima <i class="fa-solid fa-arrow-right ms-2" aria-hidden="true"></i>';
        echo '</a>';
        echo '</li>';
    }

    // Última
    if ($current_page < $total_pages) {
        echo '<li class="page-item me-0">';
        echo '<a class="page-link pagination-text" href="' . esc_url(str_replace('%#%', $total_pages, $base)) . '" aria-label="Última página">';
        echo 'Última <i class="fa-solid fa-arrow-right-long ms-2" aria-hidden="true"></i>';
        echo '</a>';
        echo '</li>';
    }

    echo '</ul>';
    echo '<p class="text-center mt-4 small text-muted">Página ' . esc_html($current_page) . ' de ' . esc_html($total_pages) . '</p>';
    echo '</nav>';

endif;
