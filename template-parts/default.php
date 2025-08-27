<?php if ( ! function_exists('in_the_loop') || ! in_the_loop() || ! is_main_query() ) { return;} ?>

<?php
/**
 * Fallback global para listagens (categories, tags, taxonomias, etc.)
 * Caminho: template-parts/default.php
 */

$post_id    = get_the_ID();
$permalink  = get_permalink();
$title      = get_the_title();
$date_iso   = get_the_date('c');
$date_human = get_the_date('d/m/Y');
?>
<article <?php post_class('mb-4'); ?> itemscope itemtype="https://schema.org/Article">
  <div class="card h-100">
    <?php if (has_post_thumbnail()): ?>
      <a href="<?php echo esc_url($permalink); ?>" class="d-block" aria-label="<?php echo esc_attr($title); ?>" itemprop="url">
        <?php
          $thumb_id = get_post_thumbnail_id();
          $alt      = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);

          the_post_thumbnail('large', [
            'class'   => 'card-img-top img-fluid',
            'alt'     => $alt ?: $title,
            'loading' => 'lazy',
          ]);
        ?>
      </a>
    <?php endif; ?>

    <div class="card-body">
      <h2 class="h4 card-title" itemprop="headline">
        <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
      </h2>

      <div class="entry-meta d-flex flex-wrap gap-2 small text-muted mb-2">
        <span class="byline">
          <?php
          $author_link = get_author_posts_url(get_the_author_meta('ID'));
          $author_name = get_the_author();
          printf(
            /* translators: %s: author name */
            esc_html__('Por %s', 'grioh'),
            '<a href="'.esc_url($author_link).'" rel="author" class="text-reset">'.esc_html($author_name).'</a>'
          );
          ?>
        </span>

        <span class="mx-1">•</span>
        <time datetime="<?php echo esc_attr($date_iso); ?>" itemprop="datePublished">
          <?php echo esc_html($date_human); ?>
        </time>

        <?php
        $cats = get_the_category_list(', ');
        if ($cats) {
          echo '<span class="mx-1">•</span><span class="cat-links">'.$cats.'</span>';
        }

        $tags = get_the_tag_list('', ', ');
        if ($tags) {
          echo '<span class="mx-1">•</span><span class="tag-links">'.$tags.'</span>';
        }
        ?>
      </div>

      <div class="entry-summary" itemprop="description">
        <?php the_excerpt(); ?>
      </div>

      <a class="stretched-link mt-2 d-inline-flex align-items-center" href="<?php echo esc_url($permalink); ?>">
        <?php esc_html_e('Ler mais', 'grioh'); ?>
        <i aria-hidden="true" class="ms-1 bi bi-arrow-right-short"></i>
      </a>
    </div>
  </div>
</article>
