<?php
/**
 * Custom template tags for Eachline Theme
 *
 * @package Eachline
 */

if (!defined('ABSPATH')) exit;

/* -------------------------------------------------------
 * 1. DATA DO POST
 * ------------------------------------------------------- */
if (!function_exists('eachline_posted_on')) :
    function eachline_posted_on() {

        $published = get_the_date(DATE_W3C);
        $modified  = get_the_modified_date(DATE_W3C);

        // HTML da data (acessível + SEO-friendly)
        $time_html = sprintf(
            '<time class="entry-date published" datetime="%1$s">%2$s</time>',
            esc_attr($published),
            esc_html(get_the_date())
        );

        // Se houve atualização, adiciona segundo <time>
        if ($published !== $modified) {
            $time_html .= sprintf(
                '<time class="updated" datetime="%1$s">%2$s</time>',
                esc_attr($modified),
                esc_html(get_the_modified_date())
            );
        }

        echo '<span class="posted-on">';
        echo sprintf(
            wp_kses(
                __('Posted on %s', 'eachline'),
                ['a' => ['href' => [], 'rel' => []], 'time' => ['datetime' => [], 'class' => []]]
            ),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_html . '</a>'
        );
        echo '</span>';
    }
endif;


/* -------------------------------------------------------
 * 2. AUTOR DO POST
 * ------------------------------------------------------- */
if (!function_exists('eachline_posted_by')) :
    function eachline_posted_by() {

        $author_url = esc_url(get_author_posts_url(get_the_author_meta('ID')));
        $author_name = esc_html(get_the_author());

        echo '<span class="byline">';
        printf(
            wp_kses(
                __('by %s', 'eachline'),
                ['span' => ['class' => []], 'a' => ['href' => [], 'class' => []]]
            ),
            '<span class="author vcard"><a class="url fn n" href="' . $author_url . '">' . $author_name . '</a></span>'
        );
        echo '</span>';
    }
endif;


/* -------------------------------------------------------
 * 3. FOOTER DO POST (categorias, tags, comentários)
 * ------------------------------------------------------- */
if (!function_exists('eachline_entry_footer')) :
    function eachline_entry_footer() {

        if ('post' === get_post_type()) {

            // Categorias
            $categories = get_the_category_list(', ');
            if ($categories) {
                echo '<span class="cat-links">';
                echo sprintf(
                    wp_kses(
                        __('Posted in %s', 'eachline'),
                        ['span' => ['class' => []], 'a' => ['href' => [], 'rel' => []]]
                    ),
                    $categories
                );
                echo '</span>';
            }

            // Tags
            $tags = get_the_tag_list('', ', ');
            if ($tags) {
                echo '<span class="tags-links">';
                echo sprintf(
                    wp_kses(
                        __('Tagged %s', 'eachline'),
                        ['span' => ['class' => []], 'a' => ['href' => [], 'rel' => []]]
                    ),
                    $tags
                );
                echo '</span>';
            }
        }

        // Comentários
        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'eachline'),
                        ['span' => ['class' => []]]
                    ),
                    esc_html(get_the_title())
                )
            );
            echo '</span>';
        }

        // Editar
        edit_post_link(
            sprintf(
                wp_kses(
                    __('Edit <span class="screen-reader-text">%s</span>', 'eachline'),
                    ['span' => ['class' => []]]
                ),
                esc_html(get_the_title())
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;


/* -------------------------------------------------------
 * 4. MINIATURA DO POST (thumbnail)
 * ------------------------------------------------------- */
if (!function_exists('eachline_post_thumbnail')) :
    function eachline_post_thumbnail() {

        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        // Single view
        if (is_singular()) {
            echo '<div class="post-thumbnail">';
            the_post_thumbnail('large', [
                'class' => 'img-fluid',
                'loading' => 'lazy',
                'decoding' => 'async'
            ]);
            echo '</div>';
            return;
        }

        // Lista / arquivo
        $alt = the_title_attribute(['echo' => false]);

        echo '<a class="post-thumbnail" href="' . esc_url(get_permalink()) . '" aria-hidden="true" tabindex="-1">';
        the_post_thumbnail('medium_large', [
            'alt'      => esc_attr($alt),
            'class'    => 'img-fluid',
            'loading'  => 'lazy',
            'decoding' => 'async',
            'fetchpriority' => 'low'
        ]);
        echo '</a>';
    }
endif;


/* -------------------------------------------------------
 * 5. Fallback para wp_body_open (compatibilidade)
 * ------------------------------------------------------- */
if (!function_exists('wp_body_open')) :
    function wp_body_open() {
        do_action('wp_body_open');
    }
endif;
