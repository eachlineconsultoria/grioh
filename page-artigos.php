<?php
/**
 * Template Name: Artigos
 * Description: Página que exibe os cases de sucesso com paginação opcional.
 */

get_header();
?>

<main id="primary" class="site-main">
  <?php
  require_once get_template_directory() . '/section/hero.php';
  ?>
  
  <div class="container">
    <?php
    global $wp_query;

    if (get_query_var('paged')) {
      $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
      $paged = get_query_var('page');
    } else {
      $paged = 1;
    }

    $limite_de_posts = 9;
    $exibir_paginacao = true;
    include get_template_directory() . '/section/articles.php';
    ?>
  </div>
</main>

<?php
// Chamada para ação final (se aplicável)
require_once get_template_directory() . '/section/cta.php';

get_footer();
?>