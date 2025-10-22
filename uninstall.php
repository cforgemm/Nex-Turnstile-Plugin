<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Remove plugin options
delete_option( 'ctnf_site_key' );
delete_option( 'ctnf_secret_key' );
delete_option( 'ctnf_theme' );
