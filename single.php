<?php get_header(); ?>

<?php if (have_posts()):
  while (have_posts()):
    the_post();

    // Obter a primeira categoria do post
    $category = get_the_category();
    $category_slug = (!empty($category)) ? $category[0]->slug : 'default';

    // Lista de slugs válidos
    $valid_templates = ['blog', 'vagas', 'jogos', 'podcast'];

    // Verifica se o slug da categoria está na lista, senão usa 'default'
    $template_slug = in_array($category_slug, $valid_templates) ? $category_slug : 'default';

    // Carrega o template correspondente
    get_template_part("template-parts/single/single", $template_slug);
?>

    <?php if (comments_open() && !post_password_required()) {
      comments_template('', true);
    } ?>

<?php endwhile; endif; ?>

<footer class="footer">
  <?php get_template_part('nav', 'below-single'); ?>
</footer>

<?php get_footer(); ?>
