<?php
/**
 * template-parts/loop/vagas.php
 *
 * Lista posts (padrão: categoria 'vagas') exibindo:
 * - Imagem ACF 'job_image' (ID/Array) com fallback para destacada
 * - Título com link
 * - Excerpt com fallback
 * - Metadados ACF normalizados: job_team, job_seniority, job_location, faixa salarial
 * - Botão "Candidatar-se" (ACF 'job_apply_url' ou permalink)
 *
 * Chamada:
 * get_template_part('template-parts/loop/vagas', null, [
 *   'category' => 'vagas',  // slug
 *   'limit'    => 6,
 *   'heading'  => 'Vagas abertas', // opcional
 * ]);
 */

/* -----------------------------
 * Util: normaliza valores do ACF
 * ----------------------------- */
if (!function_exists('wb_acf_to_text')) {
  function wb_acf_to_text($v) {
    if ($v === null || $v === false || $v === '') return '';
    if (is_object($v)) {
      if (isset($v->name))       return (string) $v->name;        // WP_Term
      if (isset($v->post_title)) return (string) $v->post_title;  // WP_Post
      return method_exists($v, '__toString') ? (string) $v : '';
    }
    if (is_array($v)) {
      if (isset($v['label']) && is_string($v['label'])) return $v['label'];
      if (isset($v['value']) && is_string($v['value'])) return $v['value'];
      if (isset($v['name'])  && is_string($v['name']))  return $v['name'];
      $parts = [];
      foreach ($v as $item) {
        if (is_object($item)) {
          if (isset($item->name))         $parts[] = (string) $item->name;
          elseif (isset($item->post_title)) $parts[] = (string) $item->post_title;
        } elseif (is_array($item)) {
          if (isset($item['label']))      $parts[] = (string) $item['label'];
          elseif (isset($item['name']))   $parts[] = (string) $item['name'];
          elseif (isset($item['value']))  $parts[] = (string) $item['value'];
        } else {
          $parts[] = (string) $item;
        }
      }
      $parts = array_filter($parts, fn($s) => $s !== '');
      return implode(', ', $parts);
    }
    return (string) $v;
  }
}

/* -----------------------------
 * Args e defaults
 * ----------------------------- */
$defaults = [
  'category' => 'vagas', // slug
  'limit'    => 6,
  'heading'  => '',      // ex.: 'Vagas abertas'
];
$args = isset($args) ? array_merge($defaults, $args) : $defaults;

// Monta query
$q_args = [
  'post_type'           => 'post',
  'post_status'         => 'publish',
  'ignore_sticky_posts' => true,
  'posts_per_page'      => (int) $args['limit'],
];
if (!empty($args['category'])) {
  $q_args['category_name'] = sanitize_title($args['category']);
}

$q = new WP_Query($q_args);

if ($q->have_posts()) : ?>
  <section class="lista-vagas">
    <?php if (!empty($args['heading'])): ?>
      <h2 class="lista-vagas__heading"><?php echo esc_html($args['heading']); ?></h2>
    <?php endif; ?>

    <ul class="list-group list-group-flush lista-vagas__grid">
      <?php while ($q->have_posts()) : $q->the_post();
        $permalink = get_permalink();
        $title     = get_the_title();

        // Excerpt com fallback
        $excerpt = get_the_excerpt();
        if (!$excerpt) {
          $excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 26, '…' );
        }

        // ACF (normalizados p/ string)
        // $team      = function_exists('get_field') ? wb_acf_to_text( get_field('job_team') )        : '';
        // $seniority = function_exists('get_field') ? wb_acf_to_text( get_field('job_seniority') )   : '';
        $location  = function_exists('get_field') ? wb_acf_to_text( get_field('job_location') )    : '';
        //$sal_min_v = function_exists('get_field') ? get_field('job_salary_min') : '';
        //$sal_max_v = function_exists('get_field') ? get_field('job_salary_max') : '';
        //$sal_min   = (is_numeric($sal_min_v) ? (int) $sal_min_v : 0);
        //$sal_max   = (is_numeric($sal_max_v) ? (int) $sal_max_v : 0);

        // Formata faixa salarial (pt-BR)
        $sal_txt = '';
        // if ($sal_min || $sal_max) {
        //   $min = $sal_min ? 'R$ '.number_format($sal_min, 0, ',', '.') : '';
        //   $max = $sal_max ? 'R$ '.number_format($sal_max, 0, ',', '.') : '';
        //   $sal_txt = trim($min.($min && $max ? ' – ' : '').$max);
        // }

        // Imagem: ACF job_image > destacada
        $img_id = 0;
        if (function_exists('get_field')) {
          $acf_img = get_field('job_image'); // pode ser ID ou Array conforme Return
          if (is_array($acf_img) && !empty($acf_img['id'])) $img_id = (int) $acf_img['id'];
          elseif (!empty($acf_img) && is_numeric($acf_img))  $img_id = (int) $acf_img;
        }
        if (!$img_id && has_post_thumbnail()) $img_id = get_post_thumbnail_id();

        $alt = $img_id ? (string) get_post_meta($img_id, '_wp_attachment_image_alt', true) : '';
        if ($alt === '') $alt = $title;

        $img_html = $img_id ? wp_get_attachment_image(
          $img_id, 'large', false,
          ['alt'=>esc_attr($alt), 'loading'=>'lazy', 'decoding'=>'async', 'class'=>'vaga__img']
        ) : '';

        // Botão "Candidatar-se": URL do ACF ou permalink
        $apply_url = $permalink;
        if (function_exists('get_field')) {
          $apply = trim((string) get_field('job_apply_url'));
          if ($apply !== '') $apply_url = $apply;
        }

        // Monta metadados
        $meta_parts = array_filter([$location]);
        $meta_line  = implode(' • ', $meta_parts);
        ?>
        <li  class="px-0 list-group-item vaga">
          <div class="d-flex justify-content-between"><?php if ($img_html): ?>
            <a href="<?php echo esc_url($permalink); ?>" class="vaga__media" aria-label="<?php echo esc_attr($title); ?>">
              <?php echo $img_html; ?>
            </a>
          <?php endif; ?>

          <div>
            <h3 class="vaga__titulo">
            <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
          </h3>

          <?php  if ($meta_line !== ''): ?>
            <p class="vaga__meta"><?php echo esc_html($meta_line); ?></p>
          <?php endif; ?>
          </div>

          <div class="vaga__excerpt">
            <?php //echo wpautop( esc_html( $excerpt ) ); ?>
          </div>

          <p class="vaga__cta">
            <a class="btn btn-primary" href="<?php echo esc_url($apply_url); ?>">Candidatar-se</a>
          </p>
       </div> </li>
      <?php endwhile; ?>
    </ul>

    <?php wp_reset_postdata(); ?>
  </section>
<?php else: ?>
  <p class="lista-vagas__empty">Não há vagas no momento.</p>
<?php endif; ?>
