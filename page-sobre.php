<?php

/**
 * Template Name: Sobre
 * @package Eachline
 */

get_header();
?>

<main>
  <?php get_template_part('template-parts/section/hero'); ?>

  <article class="content section-container container">
    <?php the_content(); ?>
  </article>

  <?php get_template_part('template-parts/section/cta'); ?>

  <section class="section-container container">
    <h3 class="section-title">Liderança</h3>
    

    <?php
/**
 * Loop de membros — versão nova usando usuários,
 * mas com estrutura HTML/CSS idêntica ao members.php antigo.
 */

$authors = get_users([
  'meta_key'   => 'show_in_site',
  'meta_value' => 1,
  'orderby'    => 'display_name',
  'order'      => 'ASC'
]);

if (!empty($authors)):
?>

<div class="row g-4">

<?php foreach ($authors as $author): ?>

  <?php
    // Campos do usuário
    $avatar    = get_avatar_url($author->ID, ['size' => 300]);
    $cargo     = get_user_meta($author->ID, 'cargo', true);
    $bio       = get_user_meta($author->ID, 'description', true); // descrição do perfil

    // Redes sociais
    $instagram = get_user_meta($author->ID, 'instagram', true);
    $twitter   = get_user_meta($author->ID, 'twitter', true);
    $linkedin  = get_user_meta($author->ID, 'linkedin', true);
    $pinterest = get_user_meta($author->ID, 'pinterest', true);
    $facebook  = get_user_meta($author->ID, 'facebook', true);
    $mastodon  = get_user_meta($author->ID, 'mastodon', true);
    $bluesky   = get_user_meta($author->ID, 'bluesky', true);
    $email     = $author->user_email;

    // ID único para modal
    $modal_id = 'modal-member-' . $author->ID;
  ?>

  <!-- CARD — sempre igual ao padrão antigo -->
  <div class="col-12 col-md-4">
    <div class="card border-0 h-100 text-center card-member"
         data-bs-toggle="modal"
         data-bs-target="#<?php echo esc_attr($modal_id); ?>">

      <figure class="ratio m-0 ratio-1x1">
        <img src="<?php echo esc_url($avatar); ?>"
             class="card-img-top object-fit-cover img-fluid"
             alt="<?php echo esc_attr($author->display_name); ?>">
      </figure>

      <div class="p-0 pt-3 text-start border-0 card-body">
        <h4 class="card-title mb-0"><?php echo esc_html($author->display_name); ?></h4>

        <?php if ($cargo): ?>
          <p class="card-text"><?php echo esc_html($cargo); ?></p>
        <?php endif; ?>
      </div>

    </div>
  </div>


  <!-- MODAL — igual ao padrão antigo, agora com dados do usuário -->
  <div class="modal fade modal-member"
       id="<?php echo esc_attr($modal_id); ?>"
       tabindex="-1"
       aria-labelledby="<?php echo esc_attr($modal_id); ?>Label"
       aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-body modal-member-body">
          <div class="row">

            <div class="col-md-4">
              <figure class="ratio ratio-1x1 m-0">
                <img src="<?php echo esc_url($avatar); ?>"
                     class="img-fluid rounded h-100 object-fit-cover mb-3"
                     alt="<?php echo esc_attr($author->display_name); ?>">
              </figure>
            </div>

            <div class="col-md-8">

              <div class="modal-header modal-member-header border-0 p-0">
                <h5 class="modal-member-title modal-title"
                    id="<?php echo esc_attr($modal_id); ?>Label">
                  <?php echo esc_html($author->display_name); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>

              <?php if ($cargo): ?>
                <p class="modal-member-role"><?php echo esc_html($cargo); ?></p>
              <?php endif; ?>

              <?php if ($bio): ?>
                <div class="modal-member-content">
                  <?php echo wpautop(esc_html($bio)); ?>
                </div>
              <?php endif; ?>

              <!-- Redes sociais -->
              <div class="modal-social mt-3 d-flex gap-3 flex-wrap">

                <?php if ($instagram): ?>
                  <a href="<?php echo esc_url($instagram); ?>" target="_blank">
                    <i class="fab fa-instagram fa-lg"></i>
                  </a>
                <?php endif; ?>

                <?php if ($twitter): ?>
                  <a href="<?php echo esc_url($twitter); ?>" target="_blank">
                    <i class="fab fa-x-twitter fa-lg"></i>
                  </a>
                <?php endif; ?>

                <?php if ($linkedin): ?>
                  <a href="<?php echo esc_url($linkedin); ?>" target="_blank">
                    <i class="fab fa-linkedin fa-lg"></i>
                  </a>
                <?php endif; ?>

                <?php if ($pinterest): ?>
                  <a href="<?php echo esc_url($pinterest); ?>" target="_blank">
                    <i class="fab fa-pinterest fa-lg"></i>
                  </a>
                <?php endif; ?>

                <?php if ($bluesky): ?>
                  <a href="<?php echo esc_url($bluesky); ?>" target="_blank">
                    <i class="fa-brands fa-bluesky fa-lg"></i>
                  </a>
                <?php endif; ?>

                <?php if ($facebook): ?>
                  <a href="<?php echo esc_url($facebook); ?>" target="_blank">
                    <i class="fab fa-facebook fa-lg"></i>
                  </a>
                <?php endif; ?>

                <?php if ($mastodon): ?>
                  <a href="<?php echo esc_url($mastodon); ?>" target="_blank">
                    <i class="fa-brands fa-mastodon fa-lg"></i>
                  </a>
                <?php endif; ?>

                <?php if ($email): ?>
                  <a href="mailto:<?php echo antispambot($email); ?>">
                    <i class="fa-solid fa-envelope fa-lg"></i>
                  </a>
                <?php endif; ?>

              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

  </div>

<?php endforeach; ?>
</div>

<?php else: ?>

<p class="text-muted text-center my-4">Nenhum membro encontrado.</p>

<?php endif; ?>


  </section>
  <?php

  get_template_part(
    'template-parts/section/section-links',
    null,
    [
      'link_category_slug' => 'premios-e-reconhecimentos',
      'section_id' => 'prizes',
      'custom_class' => 'prizes',
      'limit' => '-1',
    ]
  ); ?>
  <?php

  get_template_part(
    'template-parts/section/section-links',
    null,
    [
      'link_category_slug' => 'parceiros',
      'section_id' => 'partners',
      'custom_class' => 'partners',
      'limit' => 6,
    ]
  ); ?>

</main>

<?php get_footer(); ?>
