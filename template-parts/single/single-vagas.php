<?php
/**
 * Template: single-vagas.php
 * Exibe posts padrão (post_type=post) que estejam na categoria "vagas"
 */

get_header();

/* -----------------------------
 * Helpers
 * ----------------------------- */
if (!function_exists('wb_acf_to_text')) {
  function wb_acf_to_text($v) {
    if ($v === null || $v === false || $v === '') return '';
    if (is_object($v)) {
      if (isset($v->name))       return (string) $v->name;        // WP_Term
      if (isset($v->post_title)) return (string) $v->post_title;  // WP_Post
      return method_exists($v, '__toString') ? (string)$v : '';
    }
    if (is_array($v)) {
      if (isset($v['label']) && is_string($v['label'])) return $v['label'];
      if (isset($v['value']) && is_string($v['value'])) return $v['value'];
      if (isset($v['name'])  && is_string($v['name']))  return $v['name'];
      $parts = [];
      foreach ($v as $item) {
        if (is_object($item)) {
          if (isset($item->name)) $parts[] = (string)$item->name;
          elseif (isset($item->post_title)) $parts[] = (string)$item->post_title;
        } elseif (is_array($item)) {
          if (isset($item['label']))      $parts[] = (string)$item['label'];
          elseif (isset($item['name']))   $parts[] = (string)$item['name'];
          elseif (isset($item['value']))  $parts[] = (string)$item['value'];
        } else {
          $parts[] = (string)$item;
        }
      }
      $parts = array_filter($parts, fn($s) => $s !== '');
      return implode(', ', $parts);
    }
    return (string)$v;
  }
}

if (!function_exists('wb_money_range')) {
  function wb_money_range($min, $max) {
    $min = is_numeric($min) ? (int)$min : 0;
    $max = is_numeric($max) ? (int)$max : 0;
    if (!$min && !$max) return '';
    $a = $min ? 'R$ '.number_format($min, 0, ',', '.') : '';
    $b = $max ? 'R$ '.number_format($max, 0, ',', '.') : '';
    return trim($a.($a && $b ? ' – ' : '').$b);
  }
}

?>

<main id="primary" class="site-main container single-vaga">

<?php if (have_posts()) : while (have_posts()) : the_post();

  $post_id   = get_the_ID();
  $title     = get_the_title();
  $permalink = get_permalink();

  // --------- ACF (com fallback) ----------
  $team      = function_exists('get_field') ? wb_acf_to_text(get_field('job_team', $post_id))        : '';
  $seniority = function_exists('get_field') ? wb_acf_to_text(get_field('job_seniority', $post_id))   : '';
  $type      = function_exists('get_field') ? wb_acf_to_text(get_field('job_type', $post_id))        : '';
  $location  = function_exists('get_field') ? wb_acf_to_text(get_field('job_location', $post_id))    : '';
  $sal_min   = function_exists('get_field') ? get_field('job_salary_min', $post_id) : '';
  $sal_max   = function_exists('get_field') ? get_field('job_salary_max', $post_id) : '';
  $salary    = wb_money_range($sal_min, $sal_max);

  $apply_url = $permalink;
  if (function_exists('get_field')) {
    $maybe = trim((string) get_field('job_apply_url', $post_id));
    if ($maybe !== '') $apply_url = $maybe;
  }

  // --------- Imagem da vaga (ACF > destacada) ----------
  $img_id = 0;
  if (function_exists('get_field')) {
    $acf_img = get_field('job_image', $post_id); // pode vir ID ou Array
    if (is_array($acf_img) && !empty($acf_img['id'])) $img_id = (int)$acf_img['id'];
    elseif (!empty($acf_img) && is_numeric($acf_img))  $img_id = (int)$acf_img;
  }
  if (!$img_id && has_post_thumbnail($post_id)) $img_id = get_post_thumbnail_id($post_id);

  $alt = $img_id ? (string) get_post_meta($img_id, '_wp_attachment_image_alt', true) : '';
  if ($alt === '') $alt = $title;

  $img_html = $img_id ? wp_get_attachment_image(
    $img_id, 'large', false,
    ['alt'=>esc_attr($alt), 'loading'=>'lazy', 'decoding'=>'async', 'class'=>'vaga__img']
  ) : '';

  // --------- Monta a linha de meta só com o que existir ----------
  $meta_parts = array_filter([$team, $seniority, $type, $location, $salary]);
  ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class('vaga'); ?> itemscope itemtype="https://schema.org/JobPosting">
    <header class="vaga__header">
      <h1 class="vaga__title" itemprop="title"><?php echo esc_html($title); ?></h1>

      <?php if (!empty($meta_parts)) : ?>
        <p class="vaga__meta">
          <?php echo esc_html(implode(' • ', $meta_parts)); ?>
        </p>
      <?php endif; ?>

      <?php if ($img_html): ?>
        <div class="vaga__media"><?php echo $img_html; ?></div>
      <?php endif; ?>

      <p class="vaga__cta">
        <a class="btn btn-primary" href="<?php echo esc_url($apply_url); ?>">Candidatar-se</a>
      </p>
    </header>

    <div class="vaga__content" itemprop="description">
      <?php
        // conteúdo do post (descrição da vaga) com formatação padrão
        the_content();

        // Se não houver conteúdo, mostra um fallback curto
        if (trim(strip_tags(get_the_content())) === '') {
          echo wpautop( esc_html__('Detalhes da vaga em breve. Para se candidatar, use o botão acima.', 'seutema') );
        }
      ?>
    </div>

    <footer class="vaga__footer">
      <?php
        // Reexibir CTA no final, se quiser
        echo '<p class="vaga__cta"><a class="btn btn-primary" href="'. esc_url($apply_url) .'">Candidatar-se</a></p>';
      ?>
    </footer>

    <!-- JSON-LD (SEO) com o que existir -->
    <?php
      $desc_ld = wp_strip_all_tags( get_the_content() );
      $desc_ld = $desc_ld ? mb_substr($desc_ld, 0, 2000) : $title;
      $posted  = get_the_date('c', $post_id);

      $org_name = get_bloginfo('name');
      $job_ld = [
        '@context' => 'https://schema.org',
        '@type'    => 'JobPosting',
        'title'    => $title,
        'description' => $desc_ld,
        'datePosted'  => $posted,
        'hiringOrganization' => [
          '@type' => 'Organization',
          'name'  => $org_name,
        ],
        'employmentType' => $type ?: 'FULL_TIME',
        'applicantLocationRequirements' => [
          '@type' => 'Country',
          'name'  => 'BR'
        ],
        'jobLocationType' => (stripos($location, 'remoto') !== false) ? 'TELECOMMUTE' : 'ON_SITE',
        'jobLocation' => [
          '@type' => 'Place',
          'address' => [
            '@type' => 'PostalAddress',
            'addressCountry' => 'BR',
            'addressLocality' => $location ?: 'Brasil'
          ]
        ],
        'url' => $permalink,
      ];

      // Salary (quando existir)
      if ($sal_min || $sal_max) {
        $job_ld['baseSalary'] = [
          '@type' => 'MonetaryAmount',
          'currency' => 'BRL',
          'value' => [
            '@type' => 'QuantitativeValue',
            'minValue' => (int)$sal_min ?: null,
            'maxValue' => (int)$sal_max ?: null,
            'unitText' => 'MONTH'
          ]
        ];
      }
    ?>
    <script type="application/ld+json">
      <?php echo wp_json_encode($job_ld, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT); ?>
    </script>
  </article>

<?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
