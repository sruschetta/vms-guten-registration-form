<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function vms_gluten_registration_form_cgb_block_assets() { // phpcs:ignore
	// Styles.
	wp_enqueue_style(
		'vms_gluten_registration_form-cgb-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array( 'wp-editor' ) // Dependency to include the CSS after it.
		// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);
}

// Hook: Frontend assets.
add_action( 'enqueue_block_assets', 'vms_gluten_registration_form_cgb_block_assets' );

/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */

function vms_gluten_registration_form_cgb_editor_assets() { // phpcs:ignore

	// Scripts.
	wp_enqueue_script(
		'vms_gluten_registration_form-cgb-block-js',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		true
	);

	// Styles.
	wp_enqueue_style(
		'vms_gluten_registration_form-cgb-block-editor-css',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' )
	);
}

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'vms_gluten_registration_form_cgb_editor_assets' );



function my_plugin_render_block_latest_post( $attributes, $content ) {

	wp_enqueue_script(
		'vms-frontend-script',
		plugins_url( 'src/script/frontend-script.js', dirname( __FILE__ ) ),
		array(),
		true
	);

	wp_add_action('init', 'ajax_login');



	$nonce = wp_create_nonce('vms-login');
	$html = '<form class="vms_form vms_login_form" method="post">
							<div class="vms_form_field">
								<input type="email" name="email" placeholder="' . $attributes['email_placeholder'] . '">
							</div>
							<div class="vms_form_field">
								<input type="text" name="password" placeholder="' . $attributes['password_placeholder'] . '">
							</div>
							<input type="submit" value="' . $attributes['submit_button_label'] . '">
							<input type="hidden" id="asd" name="asd" value="' . $nonce . '">
						</form>';
	return $html;
}

register_block_type( 'vms/block-vms-gluten-login-form', array(
	'attributes' => array(
		'email_placeholder' => array(
			'type' => 'string',
			'default' => 'Email 2',
		),
		'password_placeholder' => array(
			'type' => 'string',
			'default' => 'Password',
		),
		'submit_button_label' => array(
			'type' => 'string',
			'default' => 'Login',
		),
    'email_missing_error' => array( 'type' => 'string' ),
		'email_invalid_error' => array( 'type' => 'string' ),
    'password_missing_error' => array( 'type' => 'string' ),
	),
  'render_callback' => 'my_plugin_render_block_latest_post',
) );



/*-- Login and Registration Actions ---*/


function vms_login_action(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

		die("login_action");


		/*
    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
		*/
}


function vms_registration_action(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    die("registration action!");
}
