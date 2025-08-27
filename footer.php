</main><!-- /#content -->
<style>
  #footer,
  #footer a {
    color: #fff !important
  }
</style>
<footer id="footer" class="py-4 bg-dark border-top">
  <div class="container text-center">
    <a class="mx-auto d-block" href="<?php echo esc_url(home_url('/')); ?>"
      title="Página inicial da <?php echo esc_attr(get_bloginfo('name')); ?>">

      <img src="<?php echo esc_url(get_template_directory_uri() . '/img/logo-full.svg'); ?>"
        alt="<?php echo esc_attr__('Ilustração de uma tartaruga no estilo pixelart vista de cima com as quatro patas abertas, na cor preta, com quatro riscos brancos no casco. Abaixo,está escrito em letras grandes e arredondadas a palavra “GRIOH” e embaixo a palavra “GAMES” em letras menores e espaçadas, ambos os texos em branco.', 'grioh'); ?>"
        title="<?php echo esc_attr(get_bloginfo('name')); ?>" class="d-inline-block align-text-top" />

    </a>
    <?php
    wp_nav_menu([
      'theme_location' => 'main-menu',
      'container' => false,
      'menu_class' => 'navbar',
      'depth' => 2,
      'fallback_cb' => '__return_false',
      'walker' => new Grioh_Bootstrap_Navwalker(),
    ]);
    ?>

    <div class="d-flex justify-content-between">


      <?php
      wp_nav_menu([
        'theme_location' => 'footer-credits',
        'container' => false,
        'menu_class' => 'navbar',
        'depth' => 2,
        'fallback_cb' => '__return_false',
        'walker' => new Grioh_Bootstrap_Navwalker(),
      ]);
      ?>



      <?php if (is_active_sidebar('footer-social')): ?>
        <aside class="sidebar" role="complementary">
          <?php dynamic_sidebar('footer-social'); ?>
        </aside>
      <?php endif; ?>
    </div>



    <div class="d-flex justify-content-between">
      <p>&copy; <?php echo date('Y'); ?> Grioh Games, todos os direitos reservados.</p>

      <a title="Desenvolvido por Wagner Beethoven" href="http://wagnerbeethoven.com.br">Wagner Beethoven</a>
    </div>
  </div>



</footer>

<?php get_template_part('template-parts/modal-search'); ?>


<?php wp_footer(); ?>
<script src="<?php bloginfo('template_url') ?>/js/show-hide-player.js"></script>
</body>

</html>