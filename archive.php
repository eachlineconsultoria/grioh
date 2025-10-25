<?php
/*
Template Name: Arquivos
*/

get_header(); ?>

<div id="main-content" class="main-content">

  <?php
  if (is_front_page() && twentyfourteen_has_featured_posts()) {
    // Include the featured content template.
    get_template_part('featured-content');
  }
  ?>
  <div id="primary" class="content-area">
    <div id="content" class="site-content container" role="main">

      <?php
      // Start the Loop.
      while (have_posts()):
        the_post();

        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <?php
          // Page thumbnail and title.
          the_post_thumbnail();
          the_title('<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->');
          ?>

          <div class="entry-content">
            <?php the_content(); ?>

            <?php get_search_form(); ?>

            <h2>Archives by Month:</h2>
            <ul>
              <?php wp_get_archives('type=monthly'); ?>
            </ul>
            <h2>Páginas:</h2>
            <ul>
                <?php wp_list_pages('title_li='); ?>
            </ul>

            <h2>Archives by Subject:</h2>
            <ul>
              <?php wp_list_categories(); ?>
            </ul>
            <h2>Autores:</h2>
            <ul>
              <?php wp_list_authors('show_fullname=1&optioncount=1&orderby=post_count'); ?>
            </ul>

            <?php edit_post_link(__('Edit', 'twentyfourteen'), '<span class="edit-link">', '</span>'); ?>

          </div><!-- .entry-content -->
        </article><!-- #post-## -->

        <?php

        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) {
          comments_template();
        }
      endwhile;
      ?>


    </div><!-- #content -->
  </div><!-- #primary -->
  <?php get_sidebar('content'); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();