<?php
/**
 * Imagem de destaque para categorias
 *
 * @package Eachline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Campo adicional no formulário de criação de categoria
 */
function eachline_category_add_form_fields() {
	wp_nonce_field( 'eachline_category_image', 'eachline_category_image_nonce' );
	?>
	<div class="form-field term-group">
		<label for="category-image"><?php esc_html_e( 'Imagem da categoria', 'eachline' ); ?></label>
		<input 
			type="url" 
			id="category-image" 
			name="category-image" 
			value="" 
			class="regular-text"
			placeholder="https://example.com/imagem.jpg"
		>
		<p class="description">
			<?php esc_html_e( 'Insira a URL da imagem da categoria (opcional).', 'eachline' ); ?>
		</p>
	</div>
	<?php
}
add_action( 'category_add_form_fields', 'eachline_category_add_form_fields' );

/**
 * Campo adicional no formulário de edição de categoria
 */
function eachline_category_edit_form_fields( $term ) {
	$image = get_term_meta( $term->term_id, 'category-image', true );

	wp_nonce_field( 'eachline_category_image', 'eachline_category_image_nonce' );
	?>
	<tr class="form-field term-group-wrap">
		<th scope="row">
			<label for="category-image"><?php esc_html_e( 'Imagem da categoria', 'eachline' ); ?></label>
		</th>
		<td>
			<input 
				type="url" 
				id="category-image" 
				name="category-image" 
				value="<?php echo esc_attr( $image ); ?>" 
				class="regular-text"
			/>
			<?php if ( $image ) : ?>
				<p>
					<img 
						src="<?php echo esc_url( $image ); ?>" 
						alt="<?php echo esc_attr( $term->name ); ?>" 
						style="max-width:150px;height:auto;border:1px solid #ddd;padding:4px;background:#fff;"
					>
				</p>
			<?php endif; ?>
		</td>
	</tr>
	<?php
}
add_action( 'category_edit_form_fields', 'eachline_category_edit_form_fields' );

/**
 * Salva os metadados com segurança
 */
function eachline_save_category_image( $term_id ) {

	// Permissão mínima
	if ( ! current_user_can( 'manage_categories' ) ) {
		return;
	}

	// Validação de nonce
	if (
		! isset( $_POST['eachline_category_image_nonce'] ) ||
		! wp_verify_nonce( $_POST['eachline_category_image_nonce'], 'eachline_category_image' )
	) {
		return;
	}

	// Salva ou remove
	if ( isset( $_POST['category-image'] ) ) {

		$url = esc_url_raw( wp_unslash( $_POST['category-image'] ) );

		if ( ! empty( $url ) ) {
			update_term_meta( $term_id, 'category-image', $url );
		} else {
			delete_term_meta( $term_id, 'category-image' );
		}
	}
}
add_action( 'created_category', 'eachline_save_category_image' );
add_action( 'edited_category',  'eachline_save_category_image' );

/**
 * Retorna a imagem da categoria (com fallback)
 *
 * @param int|null $term_id
 * @param string   $size
 * @param array    $attrs
 */
function eachline_get_category_image( $term_id = null, $size = 'medium', $attrs = array() ) {

	$term_id = $term_id ?: get_queried_object_id();
	$image   = get_term_meta( $term_id, 'category-image', true );

	// Fallback simples
	if ( empty( $image ) ) {
		return ''; // não imprime nada
	}

	// Se for ID ou URL
	$image_id = attachment_url_to_postid( $image );

	// Classes extras
	$default_attrs = array(
		'class' => 'category-image img-fluid',
		'alt'   => get_term_field( 'name', $term_id ) ?: '',
	);

	$attrs = wp_parse_args( $attrs, $default_attrs );

	// Se conseguir ID da mídia, usa wp_get_attachment_image()
	if ( $image_id ) {
		echo wp_get_attachment_image( $image_id, $size, false, $attrs );
		return;
	}

	// Caso contrário, imprime manualmente
	printf(
		'<img src="%s" class="%s" alt="%s">',
		esc_url( $image ),
		esc_attr( $attrs['class'] ),
		esc_attr( $attrs['alt'] )
	);
}
