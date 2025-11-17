<?php
/**
 * Template Name: Autor
 *
 * Página dedicada ao perfil do autor + listagem de seus posts
 * Este arquivo foi otimizado para:
 * - SEO
 * - Performance
 * - Acessibilidade
 * - Organização e manutenção
 */

get_header();

/**
 * Obtém ID do autor através da query var "author"
 * Esse valor é definido automaticamente pelo WordPress
 */
$author_id = get_query_var('author');

if (!$author_id) {
    echo "<p>Autor não encontrado.</p>";
    get_footer();
    exit;
}

/** @var WP_User $author Objeto completo do autor */
$author = get_userdata($author_id);

/**
 * Coleta os campos extras do autor
 */
$cargo     = get_user_meta($author_id, 'cargo', true);

// Redes sociais
$website   = get_the_author_meta('user_url', $author_id);
$linkedin  = get_user_meta($author_id, 'linkedin', true);
$instagram = get_user_meta($author_id, 'instagram', true);
$twitter   = get_user_meta($author_id, 'twitter', true);
$bluesky   = get_user_meta($author_id, 'bluesky', true);
$facebook  = get_user_meta($author_id, 'facebook', true);
$pinterest = get_user_meta($author_id, 'pinterest', true);
$mastodon  = get_user_meta($author_id, 'mastodon', true);

/** Avatar de alta qualidade */
$avatar = get_avatar_url($author_id, ['size' => 300]);



?>

<main class="container py-5">

  <!-- =============================
       BLOCO: Perfil do Autor
       ============================= -->
  <div class="shadow-sm border p-3 row mb-5 align-items-start">

    <!-- Foto do autor -->
    <figure class="col-md-4 text-center text-md-start mb-4">
      <img 
        src="<?php echo esc_url($avatar); ?>"
        class="rounded w-100 img-fluid object-fit-cover"
        loading="eager"
        fetchpriority="high"
        alt="Foto de <?php echo esc_attr($author->display_name); ?>">
    </figure>

    <!-- Informações textuais -->
    <div class="col-md-8">

      <!-- Nome -->
      <h1 class="mb-1 section-title"><?php echo esc_html($author->display_name); ?></h1>

      <!-- Cargo -->
      <?php if ($cargo): ?>
        <p class="section-description text-muted mb-3"><?php echo esc_html($cargo); ?></p>
      <?php endif; ?>

      <!-- Bio -->
      <?php if ($author->description): ?>
        <p><?php echo esc_html($author->description); ?></p>
      <?php endif; ?>

      <!-- Redes sociais -->
      <div class="d-flex social-author gap-3 mt-3">

        <?php
        /**
         * Lista de redes sociais com ícones
         * Loop reduz repetição e melhora manutenção
         */
        $socials = [
            'website'   => ['url' => $website,   'icon' => 'fa-solid fa-link',       'title' => 'Site'],
            'linkedin'  => ['url' => $linkedin,  'icon' => 'fa-brands fa-linkedin',   'title' => 'LinkedIn'],
            'instagram' => ['url' => $instagram, 'icon' => 'fa-brands fa-instagram',  'title' => 'Instagram'],
            'twitter'   => ['url' => $twitter,   'icon' => 'fa-brands fa-x-twitter',  'title' => 'Twitter/X'],
            'bluesky'   => ['url' => $bluesky,   'icon' => 'fa-brands fa-bluesky',    'title' => 'Bluesky'],
            'facebook'  => ['url' => $facebook,  'icon' => 'fa-brands fa-facebook',   'title' => 'Facebook'],
            'pinterest' => ['url' => $pinterest, 'icon' => 'fa-brands fa-pinterest',  'title' => 'Pinterest'],
            'mastodon'  => ['url' => $mastodon,  'icon' => 'fa-brands fa-mastodon',   'title' => 'Mastodon'],
        ];

        foreach ($socials as $key => $data):
            if (!$data['url']) continue;
        ?>
            <a 
              href="<?php echo esc_url($data['url']); ?>" 
              target="_blank" 
              rel="noopener" 
              class="social-author-<?php echo esc_attr($key); ?>"
              title="<?php echo esc_attr($data['title']); ?>">
                <i class="<?php echo esc_attr($data['icon']); ?> fa-xl"></i>
            </a>
        <?php endforeach; ?>

      </div>
    </div>
  </div>


  <!-- =============================
       BLOCO: Listagem de publicações
       ============================= -->

  <h2 class="pb-4 section-description text-muted">
    Leia as publicações de <?php echo esc_html($author->display_name); ?>
  </h2>

  <?php
  /**
   * Paginação segura para páginas de autor
   */
  $paged  = max(1, get_query_var('paged'));

  /**
   * Query do autor
   */
  $args = [
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'author'         => $author_id,
      'paged'          => $paged,
      'posts_per_page' => get_option('posts_per_page'), // ✨ usa o valor definido no painel WP
  ];

  $author_posts = new WP_Query($args);

  if ($author_posts->have_posts()):
  ?>

    <div class="row g-4">

      <?php while ($author_posts->have_posts()): $author_posts->the_post(); ?>
        
        <!-- Card de post -->
        <article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
          <div class="card h-100 border-0">

            <?php if (has_post_thumbnail()): ?>
              <a href="<?php the_permalink(); ?>" class="d-block overflow-hidden ratio ratio-16x9">
                <?php 
                the_post_thumbnail('large', [
                    'class' => 'h-100 object-fit-cover card-img img-fluid',
                    'alt'   => get_the_title(),
                    'loading' => 'lazy',
                    'decoding' => 'async',
                ]);
                ?>
              </a>
            <?php endif; ?>

            <div class="card-body">

              <header>
                <h3 class="card-title h5 mb-2">
                  <a href="<?php the_permalink(); ?>" class="link-text link-primary">
                    <?php the_title(); ?>
                  </a>
                </h3>
              </header>

              <p class="card-text text-muted small mb-3">
                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
              </p>

              <footer class="footer-card">
                <a href="<?php the_permalink(); ?>" class="link-text link-primary">
                  Leia o case <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </footer>

            </div>
          </div>
        </article>

      <?php endwhile; ?>

    </div>

    <?php
    /**
     * Paginação universal usando o pagination.php
     */
    $wp_query = $author_posts;
    get_template_part('template-parts/pagination');
    ?>

  <?php else: ?>

    <p>Nenhuma publicação encontrada.</p>

  <?php endif;

  wp_reset_postdata();
  ?>


  <!-- CTA e depoimentos -->
  <?php get_template_part('template-parts/section/cta'); ?>
  <?php get_template_part('template-parts/section/testimonial'); ?>

</main>

<?php get_footer(); ?>
