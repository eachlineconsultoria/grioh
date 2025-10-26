<?php
// Protege se o arquivo for chamado direto
if (empty($loop_args) || !is_array($loop_args)) {
  echo '<!-- Erro: parâmetros do loop não definidos. -->';
  return;
}

$query = new WP_Query($loop_args);

if ($query->have_posts()): ?>
  <div class="row">
    <?php while ($query->have_posts()): $query->the_post(); ?>
      <?php
      $permalink = get_permalink();
      $title     = get_the_title();
      $author    = get_the_author();
      $date      = get_the_date('d/m/Y');
      $excerpt   = get_the_excerpt();
      ?>
      <div class="col-12 col-md-4 mb-5 mb-md-0">
        <article <?php post_class('card border rounded h-100'); ?> aria-labelledby="post-<?php the_ID(); ?>-title">

          <figure class="m-0 card-container">
            <a href="<?php echo esc_url($permalink); ?>" class="d-block">
              <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium_large', [
                  'class' => 'img-fluid card-image object-fit-cover rounded-top w-100',
                  'alt'   => esc_attr($title)
                ]); ?>
              <?php else: ?>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/card-default.jpg'); ?>"
                     class="img-fluid card-image rounded-top w-100"
                     alt="Imagem padrão para o artigo <?php echo esc_attr($title); ?>">
              <?php endif; ?>
            </a>
          </figure>

          <div class="card-body p-3">
            <h3 id="post-<?php the_ID(); ?>-title" class="card-title mb-1">
              <a href="<?php echo esc_url($permalink); ?>" class="card-link">
                <?php echo esc_html($title); ?>
              </a>
            </h3>
            <p class="card-meta mb-2">
              Por <strong><?php echo esc_html($author); ?></strong> &bull;
              <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html($date); ?></time>
            </p>
            <p class="card-excerpt mb-0"><?php echo esc_html($excerpt); ?></p>
          </div>

          <footer class="border-0 card-footer">
            <a href="<?php echo esc_url($permalink); ?>" class="card-link link-text link-primary">
              Leia o texto <i class="ms-2 fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
          </footer>
        </article>
      </div>
    <?php endwhile;
    wp_reset_postdata(); ?>
  </div>
<?php endif; ?>
