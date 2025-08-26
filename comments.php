<?php
if ( post_password_required() ) { return; }

$commenter = wp_get_current_commenter();
$req       = get_option('require_name_email');
$aria_req  = $req ? ' aria-required="true" required' : '';
$author_v  = esc_attr($commenter['comment_author']);
$email_v   = esc_attr($commenter['comment_author_email']);
$is_logged = is_user_logged_in();

$open_fieldset  = '<fieldset class="comment-fieldset"><legend class="h5 mb-3">' . esc_html__('Escreva seu comentário', 'grioh') . '</legend>';
$close_fieldset = '</fieldset>';

/**
 * Campos (2 → 3). Sem URL.
 * Abrimos o <fieldset> no primeiro campo visível:
 * - Convidado: abre no "author"
 * - Logado: abre no "comment"
 */
$fields = [
  'author' => (!$is_logged ? $open_fieldset : '') . '
    <div class="mb-3">
      <label for="author">' . esc_html__('Nome', 'grioh') . '</label>
      <input id="author" name="author" type="text" value="' . $author_v . '"' . $aria_req . '
             placeholder="' . esc_attr__('Como podemos te chamar?', 'grioh') . '">
    </div>',
  'email' => '
    <div class="mb-3">
      <label for="email">' . esc_html__('Email', 'grioh') . '</label>
      <input id="email" name="email" type="email" value="' . $email_v . '"' . $aria_req . '
             placeholder="' . esc_attr__('Qual é o seu email?', 'grioh') . '">
    </div>',
];

// Textarea (4). Se o usuário estiver logado, abrimos o fieldset aqui.
$comment_field =
  ($is_logged ? $open_fieldset : '') . '
  <div class="mb-3">
    <label for="comment">' . esc_html__('Comentário', 'grioh') . '</label>
    <textarea id="comment" name="comment" rows="6" aria-required="true" required
              placeholder="' . esc_attr__('Escreva seu comentário nesse espaço.', 'grioh') . '"></textarea>
  </div>';

/**
 * Força a ordem: author (2) → email (3) → comment (4) → cookies (5)
 * Mesmo que algum plugin/tema tente mover.
 */
add_filter('comment_form_fields', function ($fields_in) {
  $order = ['author','email','comment','cookies'];
  $out = [];
  foreach ($order as $k) {
    if (isset($fields_in[$k])) { $out[$k] = $fields_in[$k]; unset($fields_in[$k]); }
  }
  // quaisquer campos restantes vão para o final
  return $out + $fields_in;
}, 999);

$args = [
  'title_reply'          => '',
  'comment_notes_before' => '', // remove aviso padrão
  'comment_notes_after'  => '',
  'fields'               => apply_filters('comment_form_default_fields', $fields), // mantém "cookies" se ativo
  'comment_field'        => $comment_field,
  'label_submit'         => __('Enviar comentário', 'grioh'),
  'submit_button'        => '<button name="%1$s" type="submit" id="%2$s">%4$s</button>', // (6)
  // fecha o fieldset depois do botão
  'submit_field'         => '<div class="mt-3">%1$s %2$s</div>' . $close_fieldset,

  // Mensagem para usuário logado (aparece acima dos campos)
  'logged_in_as'         => $is_logged ? sprintf(
    '<p class="logged-in-as">%s</p>',
    sprintf(
      __('Você está logado como %1$s. <a href="%2$s">Sair?</a>', 'grioh'),
      '<a href="' . esc_url(admin_url('profile.php')) . '">' . esc_html(wp_get_current_user()->display_name) . '</a>',
      esc_url(wp_logout_url(get_permalink()))
    )
  ) : '',
];

comment_form($args);

// opcional: remover o filtro depois, se preferir
// remove_filter('comment_form_fields', 'grioh_forced_order', 999);
