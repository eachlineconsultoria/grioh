<?php
/**
 * Breadcrumbs com Bootstrap 5 (sem plugin)
 * Compatível com CPT, taxonomias, WooCommerce, arquivos, etc.
 * Autor: você 💚
 */

if (!function_exists('wb_get_primary_category')) {
  function wb_get_primary_category($post_id)
  {
    // Yoast SEO: tenta pegar a categoria primária
    if (class_exists('WPSEO_Primary_Term')) {
      $primary = new WPSEO_Primary_Term('category', $post_id);
      $primary_id = $primary->get_primary_term();
      if ($primary_id && !is_wp_error($primary_id)) {
        $term = get_term($primary_id, 'category');
        if ($term && !is_wp_error($term))
          return $term;
      }
    }
    // fallback: primeira categoria
    $cats = get_the_category($post_id);
    return (!empty($cats)) ? $cats[0] : null;
  }
}

if (!function_exists('wb_term_ancestors')) {
  function wb_term_ancestors($term, $taxonomy)
  {
    $trail = [];
    if ($term && is_taxonomy_hierarchical($taxonomy)) {
      $ancestors = array_reverse(get_ancestors($term->term_id, $taxonomy));
      foreach ($ancestors as $ancestor_id) {
        $trail[] = get_term($ancestor_id, $taxonomy);
      }
    }
    return $trail;
  }
}

if (!function_exists('wb_post_ancestors')) {
  function wb_post_ancestors($post_id)
  {
    $trail = [];
    $parents = array_reverse(get_post_ancestors($post_id));
    foreach ($parents as $pid) {
      $trail[] = get_post($pid);
    }
    return $trail;
  }
}

if (!function_exists('wb_breadcrumb_link')) {
  function wb_breadcrumb_link($url, $label, $is_active = false)
  {
    $label = esc_html($label);
    if ($is_active) {
      return '<li class="breadcrumb-item active" aria-current="page">' . $label . '</li>';
    }
    $url = esc_url($url);
    return '<li class="breadcrumb-item"><a href="' . $url . '">' . $label . '</a></li>';
  }
}

if (!function_exists('wb_bootstrap_breadcrumbs')) {
  function wb_bootstrap_breadcrumbs($args = [])
  {
    // Configs básicas (edite se quiser)
    $cfg = wp_parse_args($args, [
      'show_on_front' => false,                       // mostrar na home?
      'home_label' => __('Início', 'textdomain'),
      'blog_label' => get_the_title(get_option('page_for_posts')) ?: __('Blog', 'textdomain'),
      'cpt_labels' => [],                          // ['produto' => 'Loja'] por exemplo
      'shop_label' => function_exists('wc_get_page_id') ? get_the_title(wc_get_page_id('shop')) : __('Loja', 'textdomain'),
    ]);

    if (is_front_page() && !$cfg['show_on_front'])
      return;

    echo '<nav class="container" aria-label="breadcrumb"><ol class="breadcrumb">';

    // Home
    echo wb_breadcrumb_link(home_url('/'), $cfg['home_label'], false);

    // Página de posts (quando homepage != posts)
    $is_blog_index = is_home() && !is_front_page();
    if ($is_blog_index) {
      echo wb_breadcrumb_link(get_permalink(get_option('page_for_posts')), $cfg['blog_label'], true);
      echo '</ol></nav>';
      return;
    }

    // WooCommerce: Loja
    if (function_exists('is_shop') && is_shop()) {
      $shop_url = get_permalink(wc_get_page_id('shop'));
      echo wb_breadcrumb_link($shop_url, $cfg['shop_label'], true);
      echo '</ol></nav>';
      return;
    }

    // Singular (post, page, CPT)
    if (is_singular()) {
      global $post;

      // Se for Anexo: mostra pai
      if (is_attachment() && $post->post_parent) {
        $anc = get_post($post->post_parent);
        if ($anc) {
          // cadeia de pais do pai
          foreach (wb_post_ancestors($anc->ID) as $p) {
            echo wb_breadcrumb_link(get_permalink($p->ID), get_the_title($p->ID));
          }
          echo wb_breadcrumb_link(get_permalink($anc->ID), get_the_title($anc->ID));
          echo wb_breadcrumb_link(get_permalink($post->ID), get_the_title($post->ID), true);
          echo '</ol></nav>';
          return;
        }
      }

      $ptype = get_post_type($post);
      $ptype_obj = get_post_type_object($ptype);

      // CPT: link para arquivo do post type (se público e tem archive)
      if ($ptype && $ptype !== 'post' && $ptype !== 'page' && $ptype_obj && !empty($ptype_obj->has_archive)) {
        $cpt_label = $cfg['cpt_labels'][$ptype] ?? $ptype_obj->labels->name;
        echo wb_breadcrumb_link(get_post_type_archive_link($ptype), $cpt_label);
      }

      // PAGE com pais
      if (is_page()) {
        foreach (wb_post_ancestors($post->ID) as $p) {
          echo wb_breadcrumb_link(get_permalink($p->ID), get_the_title($p->ID));
        }
        echo wb_breadcrumb_link(get_permalink($post->ID), get_the_title($post->ID), true);
        echo '</ol></nav>';
        return;
      }

      // POST (usa categoria primária)
      if ($ptype === 'post') {
        $primary = wb_get_primary_category($post->ID);
        if ($primary) {
          foreach (wb_term_ancestors($primary, 'category') as $ancestor) {
            echo wb_breadcrumb_link(get_term_link($ancestor), $ancestor->name);
          }
          echo wb_breadcrumb_link(get_term_link($primary), $primary->name);
        } else {
          // opcionalmente: mostrar página de posts
          $posts_page_id = get_option('page_for_posts');
          if ($posts_page_id) {
            echo wb_breadcrumb_link(get_permalink($posts_page_id), $cfg['blog_label']);
          }
        }
        echo wb_breadcrumb_link(get_permalink($post->ID), get_the_title($post->ID), true);
        echo '</ol></nav>';
        return;
      }

      // CPT singular com taxonomia "principal" (tenta uma hierárquica primeiro)
      if ($ptype && $ptype !== 'post' && $ptype !== 'page') {
        $taxes = get_object_taxonomies($ptype, 'objects');
        $pref_term = null;
        $pref_tax = null;

        if (!empty($taxes)) {
          // prioriza taxonomias hierárquicas
          foreach ($taxes as $tax) {
            $terms = get_the_terms($post->ID, $tax->name);
            if (!empty($terms)) {
              $pref_tax = $tax;
              // pega um termo (se houver hierarquia, depois subimos ancestrais)
              $pref_term = array_values($terms)[0];
              if (is_taxonomy_hierarchical($tax->name))
                break;
            }
          }
        }

        if ($pref_term && $pref_tax) {
          foreach (wb_term_ancestors($pref_term, $pref_tax->name) as $anc) {
            echo wb_breadcrumb_link(get_term_link($anc), $anc->name);
          }
          echo wb_breadcrumb_link(get_term_link($pref_term), $pref_term->name);
        }
        echo wb_breadcrumb_link(get_permalink($post->ID), get_the_title($post->ID), true);
        echo '</ol></nav>';
        return;
      }
    }

    // Arquivos de taxonomia (categoria, tag, tax custom)
    if (is_category() || is_tag() || is_tax()) {
      $term = get_queried_object();
      $taxonomy = $term->taxonomy ?? null;

      // WooCommerce: categorias/tags de produto
      if (function_exists('is_product_category') && (is_product_category() || is_product_tag())) {
        $shop_url = get_permalink(wc_get_page_id('shop'));
        echo wb_breadcrumb_link($shop_url, $cfg['shop_label']);
      }

      if ($taxonomy) {
        foreach (wb_term_ancestors($term, $taxonomy) as $anc) {
          echo wb_breadcrumb_link(get_term_link($anc), $anc->name);
        }
      }
      echo wb_breadcrumb_link(get_term_link($term), single_term_title('', false), true);

      // paginação
      if (get_query_var('paged')) {
        echo wb_breadcrumb_link('#', sprintf(__('Página %d', 'textdomain'), get_query_var('paged')), true);
      }

      echo '</ol></nav>';
      return;
    }

    // Arquivo por post type (has_archive)
    if (is_post_type_archive()) {
      $ptype = get_query_var('post_type');
      $ptype_obj = get_post_type_object($ptype);
      $label = $cfg['cpt_labels'][$ptype] ?? ($ptype_obj->labels->name ?? ucfirst($ptype));
      echo wb_breadcrumb_link(get_post_type_archive_link($ptype), $label, true);
      if (get_query_var('paged')) {
        echo wb_breadcrumb_link('#', sprintf(__('Página %d', 'textdomain'), get_query_var('paged')), true);
      }
      echo '</ol></nav>';
      return;
    }

    // Arquivos por data
    if (is_date()) {
      if (is_year()) {
        echo wb_breadcrumb_link(get_year_link(get_query_var('year')), get_query_var('year'), true);
      } elseif (is_month()) {
        echo wb_breadcrumb_link(get_year_link(get_query_var('year')), get_query_var('year'));
        echo wb_breadcrumb_link(get_month_link(get_query_var('year'), get_query_var('monthnum')), single_month_title(' ', false), true);
      } else { // day
        echo wb_breadcrumb_link(get_year_link(get_query_var('year')), get_query_var('year'));
        echo wb_breadcrumb_link(get_month_link(get_query_var('year'), get_query_var('monthnum')), single_month_title(' ', false));
        echo wb_breadcrumb_link(get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day')), get_query_var('day'), true);
      }
      echo '</ol></nav>';
      return;
    }

    // Autor
    if (is_author()) {
      $author = get_queried_object();
      echo wb_breadcrumb_link(get_author_posts_url($author->ID), sprintf(__('Autor: %s', 'textdomain'), $author->display_name), true);
      echo '</ol></nav>';
      return;
    }

    // Busca
    if (is_search()) {
      echo wb_breadcrumb_link(get_search_link(), sprintf(__('Busca: %s', 'textdomain'), get_search_query()), true);
      if (get_query_var('paged')) {
        echo wb_breadcrumb_link('#', sprintf(__('Página %d', 'textdomain'), get_query_var('paged')), true);
      }
      echo '</ol></nav>';
      return;
    }

    // 404
    if (is_404()) {
      echo wb_breadcrumb_link('#', __('Erro 404', 'textdomain'), true);
      echo '</ol></nav>';
      return;
    }

    // fallback: nada além do Home
    echo '</ol></nav>';
  }
}
