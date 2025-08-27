<?php
/**
 * Archive de categorias: carrega o partial por slug em template-parts/category/{slug}.php
 * Fallback: template-parts/category/default.php → template-parts/default.php
 */

get_header();
?>
<header class="header">
  <h1 class="entry-title" itemprop="name"><?php single_term_title(); ?></h1>
  <div class="archive-meta" itemprop="description">
    <?php
    $desc = get_the_archive_description();
    if ($desc !== '')
      echo wp_kses_post($desc);
    ?>
  </div>
</header>

<div class="row">
  <div class="col-12 col-md-8">

    <?php if (have_posts()): ?>
      <div class="loop-posts row">
        <?php while (have_posts()):
          the_post(); ?>
          <?php
          $term = get_queried_object();
          $slug = !empty($term->slug) ? sanitize_title($term->slug) : '';
          $templates = [];
          if ($slug)
            $templates[] = "template-parts/category/{$slug}.php";
          $templates[] = "template-parts/category/default.php";
          $templates[] = "template-parts/default.php";
          locate_template($templates, true, false);
          ?>
        <?php endwhile; ?>

        <?php get_template_part('template-parts/pagination', 'pagination'); ?>


      </div>
    <?php endif; ?>


  </div>

  <div class="col-12 col-md-4">
    <?php dynamic_sidebar('sidebar-page'); ?>
  </div>
</div>

<?php get_footer(); ?>