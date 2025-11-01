<?php
/**
 * Imagem de destaque para categorias
 *
 * @package Eachline
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Campo adicional no formulário de criação de categoria
 */
add_action( 'category_add_form_fields', function () {
  wp_nonce_field( 'category_image_meta', 'category_image_meta_nonce' );
  ?>
  <div class="form-field term-group">
    <label for="category-image"><?php esc_html_e( 'Imagem da categoria', 'eachline' ); ?></label>
    <input type="url" id="category-image" name="category-image" value="">
    <p class="description"><?php esc_html_e( 'Insira a URL da imagem da categoria (opcional).', 'eachline' ); ?></p>
  </div>
  <?php
});

/**
 * Campo adicional no formulário de edição de categoria
 */
add_action( 'category_edit_form_fields', function ( $term ) {
  $image = get_term_meta( $term->term_id, 'category-image', true );
  wp_nonce_field( 'category_image_meta', 'category_image_meta_nonce' );
  ?>
  <tr class="form-field term-group-wrap">
    <th scope="row"><label for="category-image"><?php esc_html_e( 'Imagem da categoria', 'eachline' ); ?></label></th>
    <td>
      <input type="url" id="category-image" name="category-image" value="<?php echo esc_attr( $image ); ?>" class="regular-text" />
      <?php if ( $image ) : ?>
        <p><img src="<?php echo esc_url( $image ); ?>" alt="" style="max-width:150px;height:auto;"></p>
      <?php endif; ?>
    </td>
  </tr>
  <?php
});

/**
 * Salvamento seguro dos metadados
 */
$save_cb = function ( $term_id ) {
  if ( ! current_user_can( 'manage_categories' ) ) return;

  if ( ! isset( $_POST['category_image_meta_nonce'] ) ||
       ! wp_verify_nonce( $_POST['category_image_meta_nonce'], 'category_image_meta' ) ) return;

  if ( isset( $_POST['category-image'] ) ) {
    $url = esc_url_raw( wp_unslash( $_POST['category-image'] ) );
    if ( $url ) {
      update_term_meta( $term_id, 'category-image', $url );
    } else {
      delete_term_meta( $term_id, 'category-image' );
    }
  }
};
add_action( 'created_category', $save_cb );
add_action( 'edited_category',  $save_cb );

/**
 * Exibe a imagem da categoria
 */
function eachline_get_category_image( $term_id = null ) {
  $term_id = $term_id ?: get_queried_object_id();
  $image   = get_term_meta( $term_id, 'category-image', true );
  if ( $image ) {
    echo wp_get_attachment_image(
      attachment_url_to_postid( $image ),
      'medium',
      false,
      [ 'class' => 'category-image', 'alt' => '' ]
    );
  }
}
