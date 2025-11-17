<?php
/**
 * Walker Universal — Header + Footer
 * Mantém exatamente a estrutura desejada para ambos.
 *
 * @package Eachline
 */

class Eachline_Universal_Navwalker extends Walker_Nav_Menu {

    /**
     * Remove suporte a submenus (seus menus são flat)
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_lvl( &$output, $depth = 0, $args = null ) {}

    /**
     * Início do item <li>
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        // Classes WP + nav-item
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'nav-item';

        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';
        }

        $class_names = implode(' ', array_map('esc_attr', $classes));

        // Abre o <li>
        $output .= sprintf(
            '<li id="menu-item-%1$d" class="%2$s" itemprop="itemListElement" itemscope itemtype="https://schema.org/SiteNavigationElement">',
            $item->ID,
            $class_names
        );

        // Atributos do link
        $atts = [
            'href'     => esc_url($item->url),
            'class'    => 'nav-link',
            'itemprop' => 'url',
        ];

        if ($item->current) {
            $atts['aria-current'] = 'page';
        }

        // Constrói atributos
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= sprintf(' %s="%s"', esc_attr($attr), esc_attr($value));
            }
        }

        // Texto
        $title = sprintf('<span itemprop="name">%s</span>', esc_html($item->title));

        // <a>
        $output .= sprintf('<a %s>%s</a>', $attributes, $title);
    }

    /**
     * Fecha item </li>
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}
