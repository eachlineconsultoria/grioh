<?php
/**
 * Campos extras no perfil do usuário (cargo e redes sociais)
 *
 * @package Eachline
 */

if (!defined('ABSPATH')) exit;

/**
 * Lista de campos extras (mapeamento centralizado)
 */
function eachline_user_fields_map() {
    return [
        'cargo'     => ['label' => 'Cargo',      'sanitize' => 'text'],
        'linkedin'  => ['label' => 'LinkedIn',   'sanitize' => 'url'],
        'instagram' => ['label' => 'Instagram',  'sanitize' => 'url'],
        'twitter'   => ['label' => 'Twitter / X','sanitize' => 'url'],
        'bluesky'   => ['label' => 'Bluesky',    'sanitize' => 'url'],
        'facebook'  => ['label' => 'Facebook',   'sanitize' => 'url'],
        'pinterest' => ['label' => 'Pinterest',  'sanitize' => 'url'],
        'mastodon'  => ['label' => 'Mastodon',   'sanitize' => 'url'],
    ];
}


/**
 * Exibe campos extras no perfil do usuário
 */
function eachline_user_extra_fields($user) {

    $fields = eachline_user_fields_map();
    wp_nonce_field('eachline_user_extra_fields_nonce', 'eachline_user_extra_fields_nonce');

    echo '<h2>' . esc_html__('Informações Extras', 'eachline') . '</h2>';
    echo '<table class="form-table">';

    foreach ($fields as $key => $field) :
        $value = get_user_meta($user->ID, $key, true);
?>
        <tr>
            <th><label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($field['label']); ?></label></th>
            <td>
                <input 
                    type="<?php echo $field['sanitize'] === 'url' ? 'url' : 'text'; ?>"
                    name="<?php echo esc_attr($key); ?>" 
                    id="<?php echo esc_attr($key); ?>"
                    class="regular-text"
                    value="<?php echo esc_attr($value); ?>">
            </td>
        </tr>
<?php
    endforeach;

    // Checkbox "mostrar no site"
    $show_in_site = get_user_meta($user->ID, 'show_in_site', true);
?>
        <tr>
            <th><label for="show_in_site">Exibir no site?</label></th>
            <td>
                <label>
                    <input type="checkbox" name="show_in_site" id="show_in_site" value="1" <?php checked($show_in_site, 1); ?>>
                    <span class="description">Mostrar este usuário na página "Sobre"</span>
                </label>
            </td>
        </tr>

    </table>
<?php
}
add_action('show_user_profile', 'eachline_user_extra_fields');
add_action('edit_user_profile', 'eachline_user_extra_fields');


/**
 * Salva campos extras
 */
function eachline_save_user_extra_fields($user_id) {

    // Permissão
    if (!current_user_can('edit_user', $user_id)) {
        return;
    }

    // Segurança
    if (!isset($_POST['eachline_user_extra_fields_nonce']) ||
        !wp_verify_nonce($_POST['eachline_user_extra_fields_nonce'], 'eachline_user_extra_fields_nonce')) {
        return;
    }

    $fields = eachline_user_fields_map();

    foreach ($fields as $key => $field) {
        $value = $_POST[$key] ?? '';

        switch ($field['sanitize']) {
            case 'url':
                $value = esc_url_raw($value);
                break;
            default:
                $value = sanitize_text_field($value);
        }

        update_user_meta($user_id, $key, $value);
    }

    // Checkbox
    update_user_meta($user_id, 'show_in_site', isset($_POST['show_in_site']) ? 1 : 0);
}
add_action('personal_options_update', 'eachline_save_user_extra_fields');
add_action('edit_user_profile_update', 'eachline_save_user_extra_fields');
