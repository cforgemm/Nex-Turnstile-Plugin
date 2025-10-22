<?php
/**
 * Plugin Name: Cloudflare Turnstile Add-on for NEX Forms
 * Plugin URI:  https://commerceforge.com
 * Description: Adds Cloudflare Turnstile to NEX Forms; detects official Cloudflare Turnstile plugin keys if available, otherwise uses local settings. Light/dark theme selectable.
 * Version:     1.0.0
 * Author:      Mark B Marquis
 * Author URI:  https://example.com/
 * License:     GPLv2 or later
 * Text Domain: ctnf
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ----------------------------------------------------
 * Load translations
 * ---------------------------------------------------- */
add_action( 'init', function() {
    load_plugin_textdomain( 'ctnf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
});

/* ----------------------------------------------------
 * Detect official plugin keys (try common option names)
 * ---------------------------------------------------- */
function ctnf_get_official_site_key() {
    $candidates = array(
        'cloudflare_turnstile_site_key',
        'cloudflare_turnstile_sitekey',
        'cloudflare_turnstile_site-key',
        'cloudflare_turnstile_sitekey_option',
        'turnstile_site_key',
    );
    foreach ( $candidates as $opt ) {
        $v = get_option( $opt );
        if ( ! empty( $v ) ) {
            return $v;
        }
    }
    $opt = get_option( 'cloudflare_turnstile' );
    if ( ! empty( $opt ) && is_array( $opt ) && ! empty( $opt['site_key'] ) ) {
        return $opt['site_key'];
    }
    return '';
}

function ctnf_get_official_secret_key() {
    $candidates = array(
        'cloudflare_turnstile_secret_key',
        'cloudflare_turnstile_secretkey',
        'cloudflare_turnstile_secret-key',
        'turnstile_secret_key',
    );
    foreach ( $candidates as $opt ) {
        $v = get_option( $opt );
        if ( ! empty( $v ) ) {
            return $v;
        }
    }
    $opt = get_option( 'cloudflare_turnstile' );
    if ( ! empty( $opt ) && is_array( $opt ) && ! empty( $opt['secret_key'] ) ) {
        return $opt['secret_key'];
    }
    return '';
}

/* ----------------------------------------------------
 * Admin settings page
 * ---------------------------------------------------- */
add_action( 'admin_menu', function() {
    add_options_page(
        __( 'Turnstile for NEX Forms', 'ctnf' ),
        __( 'Turnstile for NEX Forms', 'ctnf' ),
        'manage_options',
        'ctnf-settings',
        'ctnf_settings_page'
    );
});

add_action( 'admin_init', function() {
    register_setting( 'ctnf_settings_group', 'ctnf_site_key' );
    register_setting( 'ctnf_settings_group', 'ctnf_secret_key' );
    register_setting( 'ctnf_settings_group', 'ctnf_theme', array( 'default' => 'light' ) );
});

function ctnf_settings_page() {
    $official_site   = ctnf_get_official_site_key();
    $official_secret = ctnf_get_official_secret_key();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Cloudflare Turnstile Add-on for NEX Forms', 'ctnf' ); ?></h1>

        <?php if ( ! empty( $official_site ) || ! empty( $official_secret ) ) : ?>
            <div style="padding:12px;border-left:4px solid #2ea2cc;background:#f1fcff;">
                <strong><?php esc_html_e( 'Detected official Cloudflare Turnstile plugin keys.', 'ctnf' ); ?></strong>
                <p><?php esc_html_e( "This plugin will prefer the official plugin's keys if present. To override, enter your own keys below.", 'ctnf' ); ?></p>
            </div>
            <br/>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php settings_fields( 'ctnf_settings_group' ); do_settings_sections( 'ctnf_settings_group' ); ?>

            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="ctnf_site_key"><?php esc_html_e( 'Site Key', 'ctnf' ); ?></label></th>
                    <td>
                        <input name="ctnf_site_key" id="ctnf_site_key" type="text" value="<?php echo esc_attr( get_option( 'ctnf_site_key' ) ); ?>" class="regular-text" />
                        <p class="description"><?php esc_html_e( "If left empty and the official Cloudflare plugin is active, its site key will be used.", 'ctnf' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ctnf_secret_key"><?php esc_html_e( 'Secret Key', 'ctnf' ); ?></label></th>
                    <td>
                        <input name="ctnf_secret_key" id="ctnf_secret_key" type="text" value="<?php echo esc_attr( get_option( 'ctnf_secret_key' ) ); ?>" class="regular-text" />
                        <p class="description"><?php esc_html_e( "If left empty and the official Cloudflare plugin is active, its secret key will be used.", 'ctnf' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ctnf_theme"><?php esc_html_e( 'Widget theme', 'ctnf' ); ?></label></th>
                    <td>
                        <select name="ctnf_theme" id="ctnf_theme">
                            <option value="light" <?php selected( get_option( 'ctnf_theme', 'light' ), 'light' ); ?>><?php esc_html_e( 'Light', 'ctnf' ); ?></option>
                            <option value="dark" <?php selected( get_option( 'ctnf_theme', 'light' ), 'dark' ); ?>><?php esc_html_e( 'Dark', 'ctnf' ); ?></option>
                        </select>
                        <p class="description"><?php esc_html_e( 'Choose light or dark widget theme.', 'ctnf' ); ?></p>
                    </td>
                </tr>
            </table>

            <?php submit_button( __( 'Save Settings', 'ctnf' ) ); ?>
        </form>
    </div>
    <?php
}

/* ----------------------------------------------------
 * Helpers for active keys
 * ---------------------------------------------------- */
function ctnf_get_site_key() {
    $official = ctnf_get_official_site_key();
    if ( ! empty( $official ) ) {
        return $official;
    }
    return get_option( 'ctnf_site_key', '' );
}

function ctnf_get_secret_key() {
    $official = ctnf_get_official_secret_key();
    if ( ! empty( $official ) ) {
        return $official;
    }
    return get_option( 'ctnf_secret_key', '' );
}

/* ----------------------------------------------------
 * FRONT-END: enqueue and inject widget
 * ---------------------------------------------------- */
add_action( 'wp_enqueue_scripts', function() {
    global $post;
    if ( ! isset( $post ) || empty( $post->post_content ) ) {
        return;
    }
    if ( has_shortcode( $post->post_content, 'NEXForms' ) ) {
        wp_enqueue_script( 'ctnf-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', array(), null, true );
    }
});

add_filter( 'nexforms_render_html', function( $form_html ) {
    $site_key = ctnf_get_site_key();
    $theme    = get_option( 'ctnf_theme', 'light' );

    if ( empty( $site_key ) ) {
        return $form_html;
    }

    $widget = '<div style="text-align:center; margin:15px 0;">
        <div class="cf-turnstile" data-sitekey="' . esc_attr( $site_key ) . '" data-theme="' . esc_attr( $theme ) . '"></div>
    </div>';

    $form_html = preg_replace(
        '/(<button[^>]*type=["\']submit["\'][^>]*>)/i',
        $widget . '$1',
        $form_html,
        1
    );

    return $form_html;
});

/* ----------------------------------------------------
 * Server-side verification
 * ---------------------------------------------------- */
add_filter( 'nexforms_before_email', function( $form_data ) {
    $secret = ctnf_get_secret_key();
    if ( empty( $secret ) ) {
        // allow submission if no secret configured (admin must set it)
        return $form_data;
    }

    $token = isset( $_POST['cf-turnstile-response'] ) ? sanitize_text_field( $_POST['cf-turnstile-response'] ) : '';

    if ( empty( $token ) ) {
        wp_die( esc_html__( 'Turnstile verification failed: no token provided.', 'ctnf' ) );
    }

    $response = wp_remote_post(
        'https://challenges.cloudflare.com/turnstile/v0/siteverify',
        array(
            'body'    => array(
                'secret'   => $secret,
                'response' => $token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
            ),
            'timeout' => 10,
        )
    );

    if ( is_wp_error( $response ) ) {
        wp_die( esc_html__( 'Turnstile verification failed: network error.', 'ctnf' ) );
    }

    $result = json_decode( wp_remote_retrieve_body( $response ), true );
    if ( empty( $result['success'] ) || $result['success'] !== true ) {
        wp_die( esc_html__( 'Turnstile verification failed. Please try again.', 'ctnf' ) );
    }

    return $form_data;
}, 10, 1 );

/* ----------------------------------------------------
 * Client-side fallback: render placeholder widgets if not auto-rendered
 * ---------------------------------------------------- */
add_action( 'wp_footer', function() {
    $theme = get_option( 'ctnf_theme', 'light' );
    ?>
<script>
(function(){
  function tryRender() {
    if (typeof turnstile !== 'undefined' && typeof turnstile.render === 'function') {
      document.querySelectorAll('.cf-turnstile:not([data-rendered])').forEach(function(el){
        try {
          turnstile.render(el, { theme: '<?php echo esc_js( $theme ); ?>' });
          el.setAttribute('data-rendered', '1');
          console.log('✅ Turnstile rendered (<?php echo esc_js( $theme ); ?>)');
        } catch(e) {
          console.warn('Turnstile render error', e);
        }
      });
      return true;
    }
    return false;
  }
  document.addEventListener('DOMContentLoaded', function(){
    if (!tryRender()) {
      setTimeout(tryRender, 700);
      setTimeout(tryRender, 1500);
      setTimeout(tryRender, 3000);
    }
  });
})();
</script>
    <?php
} );
