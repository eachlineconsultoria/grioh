<?php
get_header(); ?>

<?php
  // Forma recomendada (slug + name => carrega template-parts/banner/loop-banner.php)
  get_template_part('template-parts/banner/loop', 'banner');
?>
<section id="about" class="container">
  <h2>Sobre nós</h2>
  <?php
// Bloco sincronizado da seção "Sobre"
echo do_blocks( '<!-- wp:block {"ref":32} /-->' );
?>
</section>

<?php get_template_part('nav', 'below'); ?>
<?php get_footer(); ?>