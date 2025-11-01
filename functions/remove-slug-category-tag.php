<?php
/**
 * Remove slugs /category/ e /tag/ das URLs (versão segura)
 *
 * @package Eachline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Remove slugs das URLs geradas
 */
add_filter( 'category_link', function ( $link, $term_id ) {
  $term = get_term( $term_id, 'category' );
  if ( ! is_wp_error( $term ) && $term->slug ) {
    $link = home_url( '/' . $term->slug . '/' );
  }
  return $link;
}, 10, 2 );

add_filter( 'tag_link', function ( $link, $term_id ) {
  $term = get_term( $term_id, 'post_tag' );
  if ( ! is_wp_error( $term ) && $term->slug ) {
    $link = home_url( '/' . $term->slug . '/' );
  }
  return $link;
}, 10, 2 );

/**
 * Ajusta as regras de rewrite (com colisão protegida)
 */
add_action( 'init', function () {
  global $wp_rewrite;
  $wp_rewrite->use_verbose_page_rules = true;
}, 1 );

/**
 * Resolver conflitos com páginas/posts de mesmo slug
 */
add_filter( 'request', function ( $query ) {
  if ( isset( $query['attachment'] ) ) return $query;
  if ( isset( $query['name'] ) && ! isset( $query['page'] ) ) {
    $slug = sanitize_title( $query['name'] );

    $category = get_category_by_slug( $slug );
    if ( $category ) {
      unset( $query['name'] );
      $query['category_name'] = $slug;
    }

    $tag = get_term_by( 'slug', $slug, 'post_tag' );
    if ( $tag ) {
      unset( $query['name'] );
      $query['tag'] = $slug;
    }
  }
  return $query;
});

/**
 * Flush apenas quando o tema é ativado
 */
add_action( 'after_switch_theme', function () {
  flush_rewrite_rules();
});
