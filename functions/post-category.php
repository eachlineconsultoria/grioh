<?php
function eachline_posts_by_category(
  $slug,
  $title = '',
  $post_type = 'post',
  $limit = 3,
  $show_text_block = false,
  $text_block = '',
  $show_link = false,
  $link_label = 'Ver todos'
) {
  $args = [
    'post_type'      => $post_type,
    'posts_per_page' => $limit,
    'category_name'  => $slug,
  ];

  $query = new WP_Query($args);

  if ($query->have_posts()) :
    $category = get_category_by_slug($slug);
    $category_link = $category ? get_category_link($category->term_id) : '#';

    echo "<section id='$slug' class='container section-container section-posts $slug'>";

    // Header
    if ($title || $show_link) {
      echo "<header class='section-header d-flex justify-content-between align-items-center'>";
      if ($title) echo "<h2 class='section-title m-0'>$title</h2>";
      if ($show_link && $category) {
        echo "<a href='" . esc_url($category_link) . "' class='link-text link-secondary'>$link_label<i class='fa-solid fa-arrow-right ms-1'></i></a>";
      }
      echo "</header>";
    }

    // Texto opcional
    if ($show_text_block && !empty($text_block)) {
      echo "<div class='section-text mb-4'>$text_block</div>";
    }

    // Loop dinâmico
    echo '<div class="post-list row">';
    while ($query->have_posts()) : $query->the_post();

      /**
       * Aqui vem a mágica:
       * Primeiro tenta carregar um template específico para a categoria.
       * Se não encontrar, carrega o padrão pelo post_type.
       * Se ainda assim não houver, cai no fallback 'content.php'.
       */
      $template_paths = [
        "template-parts/loop/{$slug}.php",
        "template-parts/content-{$post_type}.php",
        "template-parts/content.php",
      ];

      $template_found = false;
      foreach ($template_paths as $template) {
        $path = locate_template($template);
        if ($path) {
          include $path;
          $template_found = true;
          break;
        }
      }

      if (!$template_found) {
        // Fallback definitivo
        echo '<article><h3>' . get_the_title() . '</h3></article>';
      }

    endwhile;
    echo '</div>'; // .post-list

    echo '</section>';
  endif;

  wp_reset_postdata();
}
?>
