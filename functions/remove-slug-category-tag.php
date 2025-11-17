<?php
/**
 * Remove slugs /category/ e /tag/ das URLs – versão segura e otimizada
 *
 * @package Eachline
 */

if (!defined('ABSPATH')) exit;

/**
 * Gera links limpos para categorias e tags
 */
function eachline_clean_tax_links($link, $term_id, $taxonomy) {
    $term = get_term($term_id, $taxonomy);

    if (is_wp_error($term) || empty($term->slug)) {
        return $link;
    }

    return home_url('/' . sanitize_title($term->slug) . '/');
}
add_filter('category_link', fn($l, $id) => eachline_clean_tax_links($l, $id, 'category'), 10, 2);
add_filter('tag_link',       fn($l, $id) => eachline_clean_tax_links($l, $id, 'post_tag'), 10, 2);


/**
 * Regras de reescrita – adicionamos regras explícitas
 */
function eachline_rewrite_rules() {

    // Categorias
    add_rewrite_rule(
        '([^/]+)/?$',
        'index.php?category_name=$matches[1]',
        'top'
    );

    // Tags
    add_rewrite_rule(
        'tag/([^/]+)/?$',
        'index.php?tag=$matches[1]',
        'top'
    );
}
add_action('init', 'eachline_rewrite_rules', 20);


/**
 * Corrige conflitos entre páginas, posts e taxonomias
 */
function eachline_resolve_taxonomy_conflicts($query) {

    if (!isset($query['name']) || isset($query['page'])) {
        return $query;
    }

    $slug = sanitize_title($query['name']);

    // Evita conflito com anexos
    if (isset($query['attachment'])) {
        return $query;
    }

    // Checa categoria
    $cat = get_category_by_slug($slug);
    if ($cat) {
        unset($query['name']);
        $query['category_name'] = $slug;
        return $query;
    }

    // Checa tag
    $tag = get_term_by('slug', $slug, 'post_tag');
    if ($tag) {
        unset($query['name']);
        $query['tag'] = $slug;
        return $query;
    }

    return $query;
}
add_filter('request', 'eachline_resolve_taxonomy_conflicts');


/**
 * Habilita regras verbosas somente onde necessário
 */
add_action('init', function () {
    global $wp_rewrite;
    $wp_rewrite->use_verbose_page_rules = true;
}, 1);


/**
 * Flush automático apenas ao ativar o tema
 */
add_action('after_switch_theme', fn() => flush_rewrite_rules());
