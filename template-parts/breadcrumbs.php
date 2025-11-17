<?php
/**
 * Breadcrumbs acessíveis + schema.org + modular
 * @package Eachline
 */

if ( is_front_page() || is_home() ) return;

global $post;

/**
 * Helper → imprime um item do breadcrumb
 */
function eachline_breadcrumb_item( $label, $url = '', $position = 1, $active = false ) {

    $tag = $active ? 'span' : 'a';
    $aria = $active ? ' aria-current="page"' : '';

    echo '<li class="breadcrumb-item' . ($active? ' active fw-bold':'') . '" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';

    if ( $url && !$active ) {
        echo '<a itemprop="item" href="'.esc_url($url).'"><span itemprop="name">'.esc_html($label).'</span></a>';
    } else {
        echo '<span itemprop="name"'.$aria.'>'.esc_html($label).'</span>';
    }

    echo '<meta itemprop="position" content="'.intval($position).'" />';
    echo '</li>';
}

/**
 * Helper → converte número do mês para texto
 */
function eachline_month_name( $monthnum ) {
    return date_i18n( 'F', mktime(0,0,0,$monthnum,1) ); // traduz automaticamente
}
?>

<nav aria-label="Breadcrumb" class="container mb-3" itemscope itemtype="https://schema.org/BreadcrumbList">
  <ol class="breadcrumb m-0">

    <?php
    // HOME
    eachline_breadcrumb_item( 'Página inicial', home_url('/'), 1 );

    // posição inicial dos próximos itens
    $pos = 2;

    /* ============================================================
     * 1) PÁGINAS (com hierarquia)
     * ============================================================ */
    if ( is_page() ) {

        $anc = array_reverse( get_post_ancestors($post->ID) );

        foreach ($anc as $a) {
            eachline_breadcrumb_item( get_the_title($a), get_permalink($a), $pos++ );
        }

        eachline_breadcrumb_item( get_the_title(), '', $pos, true );
    }

    /* ============================================================
     * 2) POSTS
     * ============================================================ */
    elseif ( is_single() ) {

        $cats = get_the_category();
        if ( $cats ) {
            $main = $cats[0];
            eachline_breadcrumb_item( $main->name, get_category_link($main->term_id), $pos++ );
        }

        eachline_breadcrumb_item( get_the_title(), '', $pos, true );
    }

    /* ============================================================
     * 3) CATEGORIA
     * ============================================================ */
    elseif ( is_category() ) {
        eachline_breadcrumb_item( single_cat_title('', false), '', $pos, true );
    }

    /* ============================================================
     * 4) TAG
     * ============================================================ */
    elseif ( is_tag() ) {
        eachline_breadcrumb_item( single_tag_title('', false), '', $pos, true );
    }

    /* ============================================================
     * 5) ARQUIVOS DE DATA
     * ============================================================ */
    elseif ( is_date() ) {

        $year  = get_query_var('year');
        $month = get_query_var('monthnum');
        $day   = get_query_var('day');

        // ANO
        if ( is_year() ) {
            eachline_breadcrumb_item( "$year", '', $pos, true );
        }

        // MÊS
        elseif ( is_month() ) {
            eachline_breadcrumb_item( $year, get_year_link($year), $pos++ );
            eachline_breadcrumb_item( eachline_month_name($month)." de $year", '', $pos, true );
        }

        // DIA
        elseif ( is_day() ) {
            eachline_breadcrumb_item( $year, get_year_link($year), $pos++ );
            eachline_breadcrumb_item( eachline_month_name($month), get_month_link($year,$month), $pos++ );
            eachline_breadcrumb_item( "$day de ".eachline_month_name($month)." de $year", '', $pos, true );
        }
    }

    /* ============================================================
     * 6) AUTOR
     * ============================================================ */
    elseif ( is_author() ) {
        eachline_breadcrumb_item(
          get_the_author_meta('display_name', get_query_var('author')),
          '',
          $pos,
          true
        );
    }

    /* ============================================================
     * 7) BUSCA
     * ============================================================ */
    elseif ( is_search() ) {
        eachline_breadcrumb_item(
          'Busca por “'.get_search_query().'”',
          '',
          $pos,
          true
        );
    }

    /* ============================================================
     * 8) 404
     * ============================================================ */
    elseif ( is_404() ) {
        eachline_breadcrumb_item( 'Página não encontrada', '', $pos, true );
    }

    ?>
  </ol>
</nav>
