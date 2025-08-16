<?php
// classes bootstrap no menu principal
add_filter('nav_menu_css_class', function ($classes, $item, $args) {
  if (!empty($args->theme_location) && $args->theme_location === 'main-menu') $classes[] = 'nav-item';
  return $classes;
}, 10, 3);

add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
  if (!empty($args->theme_location) && $args->theme_location === 'main-menu') {
    $atts['class'] = (isset($atts['class']) ? $atts['class'].' ' : '') . 'nav-link';
  }
  return $atts;
}, 10, 3);
