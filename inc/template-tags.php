<?php
/**
 * Template tags e utilidades
 * @package grioh
 */

// Separador do título
add_filter('document_title_separator', function () { return '|'; });

// Fallback para títulos vazios
add_filter('the_title', function ($title) {
  return $title === '' ? esc_html('...') : wp_kses_post($title);
});

// Schema.org no elemento principal
function grioh_schema_type() {
  $schema = 'https://schema.org/';
  if (is_single())      $type = 'Article';
  elseif (is_author())  $type = 'ProfilePage';
  elseif (is_search())  $type = 'SearchResultsPage';
  else                  $type = 'WebPage';

  echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}

// itemprop=url nos links do menu
add_filter('nav_menu_link_attributes', function ($atts) {
  $atts['itemprop'] = 'url';
  return $atts;
}, 10);

// Shim para wp_body_open (compat)
if (!function_exists('grioh_wp_body_open')) {
  function grioh_wp_body_open() { do_action('wp_body_open'); }
}

// Skip link de acessibilidade
add_action('wp_body_open', function () {
  echo '<a href="#content" class="skip-link screen-reader-text">'
     . esc_html__('Skip to the content', 'grioh')
     . '</a>';
}, 5);

// Link "leia mais" no conteúdo
add_filter('the_content_more_link', function () {
  if (is_admin()) return;
  return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">'
       . sprintf(__('...%s', 'grioh'), '<span class="screen-reader-text"> ' . esc_html(get_the_title()) . '</span>')
       . '</a>';
});

// Link "leia mais" nos excerpts
add_filter('excerpt_more', function ($more) {
  if (is_admin()) return $more;
  return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">'
       . sprintf(__('...%s', 'grioh'), '<span class="screen-reader-text"> ' . esc_html(get_the_title()) . '</span>')
       . '</a>';
});

// Pingback header
add_action('wp_head', function () {
  if (is_singular() && pings_open()) {
    printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
  }
});
