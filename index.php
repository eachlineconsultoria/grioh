<?php get_header(); ?>

<section class="intro" id="intro">
  <div class="container">
    <?php
    get_template_part('template-parts/page_teaser/teaser', null, [
      'slug' => 'consultoria',
      'show' => 'image,title, excerpt,button',
      'link' => 'image,title',
      'order' => 'image,title,excerpt,button',
    ]);
    ?>
  </div>
</section>

<section class="partners" id="partners">
  <div class="container">
    <?php
    get_template_part('template-parts/page_teaser/teaser', null, [
      'slug' => 'parceiros',
      'show' => 'image,title, excerpt',
      'link' => 'image,title',
      'order' => 'image,title,excerpt',
    ]);
    ?>
<?php echo do_shortcode('[wb_links category="parceiros" limit="4" orderby="rand" show_image="1" show_url="0" show_count="0"]'); ?>
    <?php
    get_template_part('template-parts/page_teaser/teaser', null, [
      'slug' => 'parceiros',
      'show' => 'button',
      'link' => 'title',
      'order' => 'button',
    ]);
    ?>
  </div>
</section>
<?php /*
get_template_part('template-parts/banner/content', 'content'); */ ?>

<!-- <section id="about">
  <div class="container">
    <h2>Sobre nós</h2>
    <?php dynamic_sidebar(index: 'about-us-area'); ?>
  </div>
</section>

<section id="games">
  <div class="container">
    <header class="d-flex justify-content-between align-items-center">
      <h2>Jogos</h2>
      <a href="<?php bloginfo('url'); ?>/jogos">Conheça todos os jogos</a>
    </header>
    <?php
    get_template_part(
      'template-parts/loop/games',
      null,
      [
        'category' => 'jogos',
        'posts_per_page' => 2,
        'category__not_in' => [6]
      ]
    );
    ?>

  </div>
</section>

<section id="services">
  <div class="container">
    <header class="d-flex justify-content-between align-items-center">
      <h2>Consultoria</h2>
      <a href="<?php bloginfo('url'); ?>/jogos">Conheça nossos clientes</a>
    </header>

    <?php dynamic_sidebar('service-area'); ?>

    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contato'))); ?>">Fale Conosco</a>

    <div class="clients">
      <?php get_template_part('template-parts/loop/clients', null, ['category' => 'clientes', 'posts_per_page' => 3, 'category__not_in' => [6]]); ?>
    </div>
  </div>
</section>

<section id="podcast">
  <div class="container">
    <header class="d-flex justify-content-between align-items-center">
      <h2>Podcast</h2>
      <a href="<?php bloginfo('url'); ?>/jogos">Ouça todos os episódios</a>
    </header>

    <?php
    get_template_part(
      'template-parts/loop/podcast',
      null,
      [
        'category' => 'podcast',
        'posts_per_page' => 3,
        'category__not_in' => [6]
      ]
    );
    ?>

  </div>
</section>

<section id="blog">
  <div class="container">
    <header class="d-flex justify-content-between align-items-center">
      <h2>Blog</h2>
      <a href="<?php bloginfo('url'); ?>/jogos">Leia todas as publicações</a>
    </header>

    <?php
    get_template_part(
      'template-parts/loop/blog',
      null,
      [
        'category' => 'blog',
        'posts_per_page' => 3,
        'category__not_in' => [6]
      ]
    );
    ?>

  </div>
</section> -->


<?php /* get_template_part('nav', 'below');*/ ?>
<?php get_footer(); ?>