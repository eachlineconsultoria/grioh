<?php
// Campo na tela de adicionar categoria
add_action('category_add_form_fields', function () {
  ?>
  <div class="form-field term-group">
    <label for="category-image">Imagem da categoria</label>
    <input type="text" id="category-image" name="category-image" value="">
    <p class="description">Insira a URL da imagem ou deixe em branco para usar a padrão.</p>
  </div>
  <?php
});

// Campo na tela de editar categoria
add_action('category_edit_form_fields', function ($term) {
  $image = get_term_meta($term->term_id, 'category-image', true);
  ?>
  <tr class="form-field term-group-wrap">
    <th scope="row"><label for="category-image">Imagem da categoria</label></th>
    <td>
      <input type="text" id="category-image" name="category-image" value="<?php echo esc_attr($image); ?>">
      <p class="description">Insira a URL da imagem ou deixe em branco para usar a padrão.</p>
    </td>
  </tr>
  <?php
});

// Salva o campo
add_action('created_category', function ($term_id) {
  if (isset($_POST['category-image'])) {
    update_term_meta($term_id, 'category-image', esc_url_raw($_POST['category-image']));
  }
});
add_action('edited_category', function ($term_id) {
  if (isset($_POST['category-image'])) {
    update_term_meta($term_id, 'category-image', esc_url_raw($_POST['category-image']));
  }
});
