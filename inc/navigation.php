<?php
/**
 * Navegação otimizada para Bootstrap 5
 * @package grioh
 */

if ( ! class_exists( 'Grioh_Bootstrap_Navwalker' ) ) {
  class Grioh_Bootstrap_Navwalker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
      $indent  = str_repeat( "\t", $depth );
      $submenu = ( $depth > 0 ) ? ' sub-menu' : '';
      $output .= "\n$indent<ul class=\"dropdown-menu$submenu\" aria-labelledby=\"" . esc_attr( $this->current_parent_id ?? '' ) . "\">\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
      $indent  = str_repeat( "\t", $depth );
      $output .= "$indent</ul>\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
      $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

      $classes   = empty( $item->classes ) ? [] : (array) $item->classes;
      $classes[] = 'menu-item-' . $item->ID;

      $is_active   = in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) || in_array( 'current-menu-parent', $classes, true );
      $has_children = in_array( 'menu-item-has-children', $classes, true );

      // Classes <li>
      $li_classes = ['nav-item'];
      if ( $has_children && $depth === 0 ) {
        $li_classes[] = 'dropdown';
      }
      if ( $is_active ) {
        $li_classes[] = 'active';
      }

      $li_class_str = ' class="' . esc_attr( implode( ' ', $li_classes ) ) . '"';
      $output      .= $indent . '<li' . $li_class_str . '>';

      // Link attrs
      $atts           = [];
      $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
      $atts['target'] = ! empty( $item->target ) ? $item->target : '';
      $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
      $atts['href']   = ! empty( $item->url ) ? $item->url : '';

      $link_classes = $depth === 0 ? ['nav-link'] : ['dropdown-item'];

      if ( $has_children && $depth === 0 ) {
        $link_classes[]     = 'dropdown-toggle';
        $atts['data-bs-toggle'] = 'dropdown';
        $atts['aria-expanded']  = 'false';
        // id para aria-labelledby no <ul>
        $this->current_parent_id = 'dropdown-' . $item->ID;
        $atts['id'] = $this->current_parent_id;
        // Evita navegação imediata em toques (opcional, remova se não quiser)
        if ( empty( $item->url ) || $item->url === '#' ) {
          $atts['href'] = '#';
          $atts['role'] = 'button';
        }
      }

      if ( $is_active && $depth === 0 ) {
        $link_classes[] = 'active';
        $atts['aria-current'] = 'page';
      }

      $atts['class'] = implode( ' ', $link_classes );

      $attributes = '';
      foreach ( $atts as $attr => $value ) {
        if ( is_scalar( $value ) && $value !== '' ) {
          $value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
          $attributes .= ' ' . $attr . '="' . $value . '"';
        }
      }

      $title = apply_filters( 'the_title', $item->title, $item->ID );
      $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

      $item_output  = $args->before ?? '';
      $item_output .= '<a' . $attributes . '>';
      $item_output .= $args->link_before ?? '';
      $item_output .= $title;
      $item_output .= $args->link_after ?? '';
      $item_output .= '</a>';
      $item_output .= $args->after ?? '';

      $output .= $item_output;
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
      $output .= "</li>\n";
    }
  }
}

/**
 * Aplica o walker e classes Bootstrap automaticamente no local 'main-menu'
 */
add_filter( 'wp_nav_menu_args', function( $args ) {
  if ( isset( $args['theme_location'] ) && $args['theme_location'] === 'main-menu' ) {
    $args['container']   = false;
    $args['depth']       = 2; // dropdown de 1 nível (recomendado no Navbar)
    $args['menu_class']  = $args['menu_class'] ?? 'navbar-nav ms-auto mb-2 mb-lg-0';
    $args['fallback_cb'] = '__return_false';
    // Walker
    if ( empty( $args['walker'] ) ) {
      $args['walker'] = new Grioh_Bootstrap_Navwalker();
    }
  }
  return $args;
}, 20 );

/**
 * (Opcional) Ajusta classes em <li>/<a> caso o walker não esteja ativo
 */
add_filter('nav_menu_css_class', function ($classes, $item, $args) {
  if (!empty($args->theme_location) && $args->theme_location === 'main-menu') {
    if ( ! in_array('nav-item', $classes, true) ) $classes[] = 'nav-item';
    if ( in_array('menu-item-has-children', $classes, true) && $args->depth === 2 ) {
      $classes[] = 'dropdown';
    }
  }
  return $classes;
}, 10, 3);

add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
  if (!empty($args->theme_location) && $args->theme_location === 'main-menu') {
    $class = $atts['class'] ?? '';
    if ( strpos($class, 'nav-link') === false ) {
      $class = trim($class . ' nav-link');
    }
    $atts['class'] = $class;
  }
  return $atts;
}, 10, 3);
