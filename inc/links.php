<?php
// [wb_links category="parceiros" limit="6" orderby="rand" show_image="1" show_url="0" show_count="0"]
add_shortcode('wb_links', function ($atts) {
  $a = shortcode_atts([
    'category'    => '',        // slug ou nome da link_category
    'category_id' => '',        // ID da link_category (tem prioridade)
    'limit'       => 6,         // quantidade de itens a exibir
    'orderby'     => 'name',    // name|rating|updated|rand
    'order'       => 'ASC',
    'random'      => '0',       // alternativa: random="1" (ignora order/orderby)
    'show_image'  => '1',       // 1/0 - usa o campo "Imagem do link" (URL) se existir
    'show_url'    => '1',       // 1/0 - exibe a URL do link em texto
    'show_count'  => '0',       // 1/0 - exibe "Exibindo N itens"
    'class'       => 'wb-links',
    'image_size'  => 'thumbnail', // tamanho quando conseguirmos attachment ID
  ], $atts, 'wb_links');

  // Categoria
  $cat_id = 0;
  if (!empty($a['category_id'])) {
    $cat_id = (int) $a['category_id'];
  } elseif (!empty($a['category'])) {
    $term = get_term_by('slug', sanitize_title($a['category']), 'link_category');
    if (!$term) $term = get_term_by('name', $a['category'], 'link_category');
    if ($term && !is_wp_error($term)) $cat_id = (int) $term->term_id;
  }

  // Modo aleatório?
  $randomize = (strtolower($a['orderby']) === 'rand') || ($a['random'] === '1');

  // Busca
  $args = [
    'orderby' => $randomize ? 'name' : $a['orderby'], // 'name' só para ter um ORDER BY válido; vamos embaralhar depois
    'order'   => $randomize ? 'ASC' : $a['order'],
  ];
  if ($cat_id) $args['category'] = (int) $cat_id;
  if (!$randomize) $args['limit'] = (int) $a['limit']; // no aleatório, buscamos tudo para embaralhar

  $links = get_bookmarks($args);
  if (empty($links)) return '';

  if ($randomize) {
    // embaralha e corta para o limite desejado
    shuffle($links);
    $links = array_slice($links, 0, (int) $a['limit']);
  }

  // Render
  ob_start();
  $count = min((int) $a['limit'], count($links));
  ?>
  <div class="<?php echo esc_attr($a['class']); ?>">
    <?php if ($a['show_count'] === '1'): ?>
      <p class="wb-links__count">Exibindo <?php echo (int) $count; ?> itens</p>
    <?php endif; ?>

    <ul class="wb-links__list row list-unstyled">
      <?php foreach ($links as $i => $link):
        if ($i >= (int) $a['limit']) break;

        $url   = $link->link_url;
        $name  = $link->link_name;
        $notes = trim((string) $link->link_notes); // "Notas" (Avançado)
        $alt   = $notes !== '' ? $notes : $name;

        $imgH  = '';
        $imgU  = trim((string) $link->link_image);

        // Tenta mapear URL para attachment (para srcset), mantendo ALT = notas
        $att_id = 0;
        if ($imgU !== '') {
          if (!preg_match('#^https?://#i', $imgU)) {
            $imgU = home_url('/' . ltrim($imgU, '/'));
          }
          $uploads_host = parse_url(wp_get_upload_dir()['baseurl'], PHP_URL_HOST);
          $img_host     = parse_url($imgU, PHP_URL_HOST);
          if ($uploads_host && $img_host && strcasecmp($uploads_host, $img_host) === 0) {
            $clean = preg_replace('#-\d+x\d+(?=\.[a-z]{3,4}$)#i', '', $imgU);
            $maybe = attachment_url_to_postid($clean);
            if ($maybe) $att_id = (int) $maybe;
          }
        }

        if ($a['show_image'] === '1' && $imgU !== '') {
          if ($att_id) {
            $imgH = wp_get_attachment_image($att_id, $a['image_size'], false, [
              'alt' => esc_attr($alt),
              'loading' => 'lazy',
              'decoding'=> 'async',
              'class'   => 'wb-links__img'
            ]);
          } else {
            $imgH = sprintf(
              '<img src="%s" alt="%s" loading="lazy" decoding="async" class="bg-dark img-fluid wb-links__img" />',
              esc_url($imgU),
              esc_attr($alt)
            );
          }
        }
        ?>
        <li class="wb-links__item col-4 col-md mb-3">
          <a class="wb-links__anchor h-100 align-items-center d-flex justify-content-center"
             href="<?php echo esc_url($url); ?>"
             <?php echo $link->link_target ? ' target="'.esc_attr($link->link_target).'" rel="noopener"' : ''; ?>>
            <?php echo $imgH ? $imgH.' ' : ''; ?>
            <?php /* <span class="wb-links__name"><?php echo esc_html($name); ?></span> */ ?>
          </a>

          <?php if ($a['show_url'] === '1'): ?>
            <small class="wb-links__url"><?php echo esc_html($url); ?></small>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php
  return ob_get_clean();
});
