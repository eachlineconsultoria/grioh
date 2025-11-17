<?php
/**
 * Funções auxiliares para melhorar classes do <body> e headers nativos.
 *
 * @package Eachline
 */

if (!defined('ABSPATH')) exit;

/**
 * Otimiza classes aplicadas ao <body>
 *
 * @param array $classes
 * @return array
 */
function eachline_body_classes($classes) {

    // 🔹 Adiciona "hfeed" para páginas de arquivo (não-singulares)
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // 🔹 Adiciona "no-sidebar" se a sidebar estiver desativada
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    // 🔹 Tema filho / dev tools
    if (is_child_theme()) {
        $classes[] = 'child-theme-active';
    }

    return $classes;
}
add_filter('body_class', 'eachline_body_classes');


/**
 * Adiciona tag de pingback em páginas que aceitam trackbacks.
 * Mantido por compatibilidade com RSS, apps antigos e indexadores.
 */
function eachline_pingback_header() {

    if (!is_singular() || !pings_open()) {
        return; // early return → melhor performance
    }

    printf(
        '<link rel="pingback" href="%s" />' . PHP_EOL,
        esc_url(get_bloginfo('pingback_url'))
    );
}
add_action('wp_head', 'eachline_pingback_header');
