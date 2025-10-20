<?php
$post_id = get_the_ID();
$modal_id = 'modal-membro-' . $post_id;

// Campos ACF
$twitter = get_field('x_twitter', $post_id);
$linkedin = get_field('linkedin', $post_id);
$pinterest = get_field('pinterest', $post_id);
$bluesky = get_field('bluesky', $post_id);
$facebook = get_field('facebook', $post_id);
$mastodon = get_field('mastodon', $post_id);
$email = get_field('email', $post_id);
?>

<div class="col-md-4">
  <div class="card h-100 text-center membro-card">
    <?php if (has_post_thumbnail()): ?>
      <img src="<?php echo get_the_post_thumbnail_url($post_id, 'medium'); ?>" class="card-img-top"
        alt="<?php the_title(); ?>">
    <?php endif; ?>

    <div class="card-body">
      <h5 class="card-title"><?php the_title(); ?></h5>
      <p class="card-text"><?php echo get_the_excerpt(); ?></p>
      <button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal"
        data-bs-target="#<?php echo esc_attr($modal_id); ?>">
        Ver mais
      </button>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="<?php echo esc_attr($modal_id); ?>" tabindex="-1"
  aria-labelledby="<?php echo esc_attr($modal_id); ?>Label" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="<?php echo esc_attr($modal_id); ?>Label"><?php the_title(); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <?php if (has_post_thumbnail()): ?>
              <img src="<?php echo get_the_post_thumbnail_url($post_id, 'medium'); ?>" class="img-fluid rounded mb-3"
                alt="<?php the_title(); ?>">
            <?php endif; ?>
          </div>
          <div class="col-md-8">
            <p><strong><?php echo get_the_excerpt(); ?></strong></p>
            <div><?php the_content(); ?></div>

            <div class="social-icons mt-3 d-flex gap-3 flex-wrap">
              <?php if ($twitter): ?>
                <a href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="fab fa-x-twitter fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($linkedin): ?>
                <a href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="fab fa-linkedin fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($pinterest): ?>
                <a href="<?php echo esc_url($pinterest); ?>" target="_blank"><i class="fab fa-pinterest fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($bluesky): ?>
                <a href="<?php echo esc_url($bluesky); ?>" target="_blank"><i class="fa-brands fa-bluesky fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($facebook): ?>
                <a href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="fab fa-facebook fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($mastodon): ?>
                <a href="<?php echo esc_url($mastodon); ?>" target="_blank"><i
                    class="fa-brands fa-mastodon fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($email): ?>
                <a href="mailto:<?php echo antispambot($email); ?>"><i class="fa-solid fa-envelope fa-lg"></i></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>