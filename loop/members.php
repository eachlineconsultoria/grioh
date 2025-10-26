<?php
$post_id = get_the_ID();
$modal_id = 'modal-member-' . $post_id;

// Campos ACF
$bluesky = get_field('bluesky', $post_id);
$email = get_field('email', $post_id);
$facebook = get_field('facebook', $post_id);
$instagram = get_field('instagram', $post_id);
$linkedin = get_field('linkedin', $post_id);
$mastodon = get_field('mastodon', $post_id);
$pinterest = get_field('pinterest', $post_id);
$twitter = get_field('x_twitter', $post_id);
?>

<div class="col-12 col-md-4">
  <div class="card border-0 h-100 text-center card-member" data-bs-toggle="modal"
    data-bs-target="#<?php echo esc_attr($modal_id); ?>">
    <?php if (has_post_thumbnail()): ?>
      <img src="<?php echo get_the_post_thumbnail_url($post_id, 'medium'); ?>" class="card-img-top"
        alt="<?php the_title(); ?>">
    <?php endif; ?>

    <div class="p-0 pt-3 text-start card-body">
      <h4 class="card-title mb-0 "><?php the_title(); ?></h4>
      <p class="card-text"><?php echo get_the_excerpt(); ?></p>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade modal-member" id="<?php echo esc_attr($modal_id); ?>" tabindex="-1"
  aria-labelledby="<?php echo esc_attr($modal_id); ?>Label" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-body  modal-member-body">
        <div class="row">
          <div class="col-md-4">
            <?php if (has_post_thumbnail()): ?>
              <img src="<?php echo get_the_post_thumbnail_url($post_id, 'medium'); ?>" class="img-fluid rounded h-100 object-fit-cover mb-3"
                alt="<?php the_title(); ?>">
            <?php endif; ?>
          </div>
          <div class="col-md-8">

            <div class="modal-header modal-member-header border-0 p-0">
              <h5 class="modal-member-title modal-title" id="<?php echo esc_attr($modal_id); ?>Label"><?php the_title(); ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>


            <p class="modal-member-role"><?php echo get_the_excerpt(); ?></p>
            <div class="modal-member-content"><?php the_content(); ?></div>

            <div class="modal-social mt-3 d-flex gap-3 flex-wrap">
              <?php if ($instagram): ?>
                <a class="modal-social-instagram" href="<?php echo esc_url($instagram); ?>" target="_blank"><i class="fab fa-instagram fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($twitter): ?>
                <a class="modal-social-twitter" href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="fab fa-x-twitter fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($linkedin): ?>
                <a class="modal-social-linkedin" href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="fab fa-linkedin fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($pinterest): ?>
                <a class="modal-social-pinterest" href="<?php echo esc_url($pinterest); ?>" target="_blank"><i class="fab fa-pinterest fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($bluesky): ?>
                <a class="modal-social-bluesky" href="<?php echo esc_url($bluesky); ?>" target="_blank"><i class="fa-brands fa-bluesky fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($facebook): ?>
                <a class="modal-social-facebook" href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="fab fa-facebook fa-lg"></i></a>
              <?php endif; ?>
              <?php if ($mastodon): ?>
                <a class="modal-social-mastodon" href="<?php echo esc_url($mastodon); ?>" target="_blank"><i
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