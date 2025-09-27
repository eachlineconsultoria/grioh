<?php
/**
 * Teaser simples e confiável
 * - Alvo: passe 'slug' ou 'page_id' via $args (sem metas na página atual).
 * - Imagem: ACF Image 'teaser_image' (ID/array) > imagem destacada.
 * - ALT: do anexo; fallback = título.
 * - Título/trecho: ACF 'teaser_title' / 'teaser_excerpt' (opcional).
 * - Botão: texto 100% do ACF 'teaser_button_text' (fallback "Saiba mais").
 *
 * $args aceitos:
 *   - slug        (string)  | ex.: 'consultoria'
 *   - page_id     (int)
 *   - show        (string)  | ex.: 'image,title,excerpt,button' (se não passar, mostra tudo)
 *   - link        (string)  | ex.: 'image,title' (se não passar, linka image+title)
 *   - order       (string)  | ex.: 'image,title,excerpt,button' (default)
 *   - class       (string)  | classe extra no <article>
 *   - image_size  (string)  | ex.: 'large' (default)
 *
 * Campos ACF na página-alvo:
 *   - teaser_image         (Image – ID/Array)
 *   - teaser_title         (Text)
 *   - teaser_excerpt       (Text/WYSIWYG curto)
 *   - teaser_button_text   (Text)
 *   - teaser_button_class  (Text) opcional
 */

$defaults = [
  'slug'       => null,
  'page_id'    => null,
  'show'       => '', // se vazio, mostra todos
  'link'       => '', // se vazio, linka image e title
  'order'      => 'image,title,excerpt,button',
  'class'      => 'page-teaser',
  'image_size' => 'large',
];
$args = isset($args) ? array_merge($defaults, $args) : $defaults;

// 1) Resolve página-alvo (slug > page_id > atual)
$post = null;
if (!empty($args['slug'])) {
  $post = get_page_by_path(sanitize_title($args['slug']), OBJECT, 'page');
} elseif (!empty($args['page_id'])) {
  $post = get_post((int)$args['page_id']);
} else {
  $post = get_post(get_the_ID());
}
if (!$post || $post->post_status !== 'publish') return;

$permalink = get_permalink($post);

// 2) ACF/meta overrides (na página-alvo)
$custom_title   = get_post_meta($post->ID, 'teaser_title', true);
$custom_excerpt = get_post_meta($post->ID, 'teaser_excerpt', true);
$btn_text_acf   = trim(get_post_meta($post->ID, 'teaser_button_text', true));
$btn_class_acf  = trim(get_post_meta($post->ID, 'teaser_button_class', true));

// 3) Título
$title = $custom_title ?: get_the_title($post);

// 4) Excerpt/trecho
$parts  = get_extended($post->post_content);
$main   = $parts['main'] ?? '';
$teaser_from_main = '';
if ($main !== '') {
  $teaser_from_main = apply_filters('the_content', $main);
  $teaser_from_main = preg_replace('#<p>\s*<a[^>]*more-link[^>]*>.*?</a>\s*</p>#i', '', $teaser_from_main);
}
if ($custom_excerpt !== '') {
  $allowed = [
    'a'=>['href'=>[], 'title'=>[], 'rel'=>[], 'target'=>[], 'aria-label'=>[]],
    'strong'=>[], 'b'=>[], 'em'=>[], 'i'=>[],
    'p'=>[], 'br'=>[], 'span'=>['class'=>[]],
    'ul'=>[], 'ol'=>[], 'li'=>[]
  ];
  $final_excerpt = wp_kses($custom_excerpt, $allowed);
} elseif ($teaser_from_main !== '') {
  $final_excerpt = $teaser_from_main;
} else {
  $native_excerpt = get_the_excerpt($post);
  $final_excerpt  = $native_excerpt ? wpautop(esc_html($native_excerpt))
                                    : '<p>'.esc_html(wp_trim_words(wp_strip_all_tags($post->post_content), 40, '…')).'</p>';
}

// 5) Imagem (ACF Image > thumb destacada) + ALT
$img_html = '';
$img_id   = 0;

if (function_exists('get_field')) {
  $acf_image = get_field('teaser_image', $post->ID);
  if (is_array($acf_image) && !empty($acf_image['id']))       $img_id = (int)$acf_image['id'];
  elseif (!empty($acf_image) && is_numeric($acf_image))        $img_id = (int)$acf_image;
}
if (!$img_id && has_post_thumbnail($post)) $img_id = get_post_thumbnail_id($post);

$img_alt = $img_id ? (string) get_post_meta($img_id, '_wp_attachment_image_alt', true) : '';
if ($img_alt === '') $img_alt = $title;

if ($img_id) {
  $img_html = wp_get_attachment_image($img_id, $args['image_size'], false, [
    'alt' => esc_attr($img_alt), 'loading'=>'lazy', 'decoding'=>'async'
  ]);
}

// 6) Botão (texto 100% do ACF)
$btn_text  = $btn_text_acf !== '' ? $btn_text_acf : 'Saiba mais';
$btn_class = 'page-teaser__btn ' . ($btn_class_acf !== '' ? $btn_class_acf : 'btn btn-primary');
$btn_aria  = sprintf('Ir para %s', $title);

// 7) Mostrar/Ordenar/Linkar
$allowed = ['image','title','excerpt','button'];

// show: se vazio, mostra todos; se tiver, só o que veio
$show_keys = array_filter(array_map('trim', explode(',', (string)$args['show'])));
$show_map  = [];
if (empty($show_keys)) $show_keys = $allowed;
foreach ($allowed as $k) $show_map[$k] = in_array($k, $show_keys, true);

// link: se vazio, linka image+title; senão, só os informados
$link_keys = array_filter(array_map('trim', explode(',', (string)$args['link'])));
if (empty($link_keys)) $link_keys = ['image','title'];
$link_map = [];
foreach (['image','title'] as $k) $link_map[$k] = in_array($k, $link_keys, true);

// ordem
$order = array_values(array_filter(array_map('trim', explode(',', (string)$args['order'])), function($k) use ($allowed){ return in_array($k, $allowed, true); }));
if (empty($order)) $order = $allowed;

// 8) Monta blocos
$sections = [];

// imagem
if ($show_map['image'] && $img_html) {
  $inner = $img_html;
  if ($link_map['image']) $inner = '<a href="'.esc_url($permalink).'" aria-label="'.esc_attr($title).'" class="page-teaser__media-link">'.$inner.'</a>';
  $sections['image'] = '<div class="page-teaser__media" itemprop="image">'.$inner.'</div>';
}

// título
if ($show_map['title']) {
  $inner = esc_html($title);
  if ($link_map['title']) $inner = '<a href="'.esc_url($permalink).'" rel="bookmark">'.$inner.'</a>';
  $sections['title'] = '<h2 class="page-teaser__title" itemprop="name">'.$inner.'</h2>';
}

// excerpt
if ($show_map['excerpt']) {
  $sections['excerpt'] = '<div class="page-teaser__excerpt" itemprop="description">'.$final_excerpt.'</div>';
}

// botão
if ($show_map['button']) {
  $sections['button'] = '<p class="page-teaser__cta"><a href="'.esc_url($permalink).'" class="'.esc_attr($btn_class).'" aria-label="'.esc_attr($btn_aria).'">'.esc_html($btn_text).'</a></p>';
}

// 9) Render
echo '<article class="'.esc_attr($args['class']).'" itemscope itemtype="https://schema.org/WebPage">';
foreach ($order as $key) {
  if (!empty($sections[$key])) echo $sections[$key];
}
echo '</article>';
