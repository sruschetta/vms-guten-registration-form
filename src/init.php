<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists('VMS') ) {

	class VMS {

		function __construct() {

			if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}

			$this->initGutenbergBlocks();

		}

		/**
			* Gutenberg Block
		**/


		function initGutenbergBlocks() {

			//Register Meta
			add_action( 'init', array( $this, 'registerMeta' ) );

			$this->registerLoginBlock();
			$this->registerActions();

		}

		function registerMeta() {

			register_meta( 'post', 'email_missing_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'email_invalid_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'password_missing_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'target_page', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );
		}


		function registerLoginBlock() {

			//Register scrpits
			wp_register_script(
				'vms_backend_script',
				plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
				array( 'wp-blocks', 'wp-element', 'wp-editor' )
			);

			wp_register_script(
				'vms_frontend_script',
				plugins_url( 'src/script/vms-login.js', dirname( __FILE__ ) ),
				array( 'jquery')
			);

			wp_localize_script( 'vms_frontend_script', 'ajax_login_object', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' )
			));

			//Register style
			wp_register_style(
				'vms_backend_style',
				plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
				array( 'wp-edit-blocks' )
			);

			wp_register_style(
				'vms_frontend_style',
				plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
				array( 'wp-edit-blocks' )
			);

			//Register block

			register_block_type( 'vms/vms-plugin-login-form', array(
				'attributes' => array(
					'email_placeholder' => array(
						'type' => 'string',
						'default' => 'Email',
					),
					'password_placeholder' => array(
						'type' => 'string',
						'default' => 'Password',
					),
					'submit_button_label' => array(
						'type' => 'string',
						'default' => 'Login',
					),
					'pages' => array(
						'type' => 'array',
						'default' => $this->get_page_list()
					),
					'target_page' => array(
						'type' => 'string',
						'source' => 'meta',
						'meta' => 'target_page'
					),
			    'email_missing_error' => array(
						'type' => 'string',
						'default' => 'Il campo email è obbligatorio',
						'source' => 'meta',
						'meta' => 'email_missing_error'
					),
					'email_invalid_error' => array(
						'type' => 'string',
						'default' => 'Il campo email non è valido',
						'source' => 'meta',
						'meta' => 'email_invalid_error'
					),
			    'password_missing_error' => array(
						'type' => 'string',
						'default' => 'Il campo password è obbligatorio',
						'source' => 'meta',
						'meta' => 'password_missing_error'
					)
				),
				'editor_script' => 'vms_backend_script',
				'editor_style' => 'vms_backend_style',
				'style' => 'vms_frontend_style',
				'script' => 'vms_frontend_script',
			  'render_callback' => array( $this, 'renderLoginBlock' ),
				)
			);
		}


		function registerActions(){
			add_action( 'wp_ajax_vms_login_action', array( $this, 'vms_login_action' ) );
			add_action( 'wp_ajax_nopriv_vms_login_action', array( $this, 'vms_login_action' ) );
		}



		/**
		 *  Frontend Rendering
		**/

		function renderLoginBlock( $attributes, $content ) {
			$nonce = wp_create_nonce('vms-login');

			$html = '<form class="vms_form vms_login_form" post_id=' . get_the_ID() .'>
									<div class="vms_form_field">
										<input type="email" name="email" placeholder="' . $attributes['email_placeholder'] . '">
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">
										<input type="text" name="password" placeholder="' . $attributes['password_placeholder'] . '">
										<span class="vms_form_error"></span>
									</div>
									<input type="submit" value="' . $attributes['submit_button_label'] . '">
									<input type="hidden" name="vms-login-sec" value="' . $nonce . '">
								</form>';
			return $html;
		}


		/**
		 *	Ajax actions response
		**/

		//Login
		function vms_login_action(){

		    // First check the nonce, if it fails the function will break

		    check_ajax_referer( 'vms-login', 'security' );

				$post_id = $_POST['post_id'];

				if(isset($post_id)){
					echo json_encode(array('post_meta' => get_post_meta($post_id)));
				}
				die();
		}


		//Registration

		function vms_registration_action(){

		    // First check the nonce, if it fails the function will break
		    check_ajax_referer( 'ajax-login-nonce', 'security' );

		    die("registration action!");
		}

		//add_action( 'wp_ajax_nopriv_vms_registration_action', 'vms_registration_action' );


		/**
		 	* Utilities
		**/

		function get_page_list(){
			$args = array(
				'sort_order' => 'asc',
				'sort_column' => 'post_title',
				'post_type' => 'page',
			);
			return  get_pages($args);
		}

	}

	//Plugin Execution
	new VMS;

}
















/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 **/
/*
function vms_plugin_common_assets() {
	wp_enqueue_style(
		'vms_gluten_registration_form-cgb-style-css',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		array( 'wp-editor' )
	);
}

// Hook: Frontend assets.
add_action( 'enqueue_block_assets', 'vms_plugin_common_assets' );


*/

/**
 * Enqueue Gutenberg block assets for backend editor.
 **/

/*
function vms_plugin_backend_assets() {

	wp_enqueue_script(
		'vms_gluten_registration_form-cgb-block-js',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-element', 'wp-editor' ),
		true
	);

	wp_enqueue_style(
		'vms_gluten_registration_form-cgb-block-editor-css',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' )
	);
}

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'vms_plugin_backend_assets' );
*/



/**
 *	Login block frontend render
 **/

/*
function vms_plugin_login_block_render( $attributes, $content ) {

	//Frontend script

	wp_enqueue_script(
		'vms-plugin-login-frontend-script',
		plugins_url( 'src/script/vms-login.js', dirname( __FILE__ ) ),
		array(),
		true
	);

	wp_localize_script( 'vms-plugin-login-frontend-script', 'ajax_login_object', array(
      'ajaxurl' => admin_url( 'admin-ajax.php' )
  ));
	*/

	//Frontend render
/*
	$nonce = wp_create_nonce('vms-login');

	$html = '<form class="vms_form vms_login_form" post_id=' . get_the_ID() .'>
							<div class="vms_form_field">
								<input type="email" name="email" placeholder="' . $attributes['email_placeholder'] . '">
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">
								<input type="text" name="password" placeholder="' . $attributes['password_placeholder'] . '">
								<span class="vms_form_error"></span>
							</div>
							<input type="submit" value="' . $attributes['submit_button_label'] . '">
							<input type="hidden" name="vms-login-sec" value="' . $nonce . '">
						</form>';
	return $html;
}
*/


/*
function get_page_list(){
	$args = array(
	'sort_order' => 'asc',
	'sort_column' => 'post_title',
	'hierarchical' => 1,
	'exclude' => '',
	'include' => '',
	'meta_key' => '',
	'meta_value' => '',
	'authors' => '',
	'child_of' => 0,
	'parent' => -1,
	'exclude_tree' => '',
	'number' => '',
	'offset' => 0,
	'post_type' => 'page',
	'post_status' => 'publish'
);
return  get_pages($args);
}
*/
/*
function gutenberg_my_block_init() {

		register_meta( 'post', 'email_missing_error', array(
				'show_in_rest' => true,
				'type' => 'string',
				'single' => true,
		) );

		register_meta( 'post', 'email_invalid_error', array(
				'show_in_rest' => true,
				'type' => 'string',
				'single' => true,
		) );

		register_meta( 'post', 'password_missing_error', array(
				'show_in_rest' => true,
				'type' => 'string',
				'single' => true,
		) );

		register_meta( 'post', 'target_page', array(
				'show_in_rest' => true,
				'type' => 'string',
				'single' => true,
		) );
}
add_action( 'init', 'gutenberg_my_block_init' );
*/


/**
 *	Registration block frontend render
 **/
/*
 function vms_plugin_registration_block_render( $attributes, $content ) {

 	//Frontened script
 	wp_enqueue_script(
 		'vms-plugin-registration-frontend-script',
 		plugins_url( 'src/script/vms-registration.js', dirname( __FILE__ ) ),
 		array(),
 		true
 	);

 	//Frontend render

 	$nonce = wp_create_nonce('vms-registration');

 	$html = '<form class="vms_form" post_id=' . get_the_ID() .'>
							<div class="vms_form_field">'
								. $attributes['firstname_placeholder'] .
								'<input type="text" name="firstname" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">'
								. $attributes['lastname_placeholder'] .
								'<input type="text" name="lastname" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">'
								. $attributes['email_placeholder'] .
								'<input type="email" name="email" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">'
								. $attributes['password_placeholder'] .
								'<input type="text" name="password" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">'
								. $attributes['password2_placeholder'] .
								'<input type="text" name="password2" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">'
								. $attributes['nation_placeholder'] .
								'<input type="text" name="nation" />
								<span class="vms_form_error"></span>
							</div>
							<div class="vms_form_field">'
								. $attributes['age_placeholder'] .
								'<input type="number" name="age" />
								<span class="vms_form_error"></span>
							</div>
							<input type="submit" value="' . $attributes['submit_button_label'] . '"/>
							<input type="hidden" name="vms-registration-nonce" value="' . $nonce . '">
						</form>';
 	return $html;
 }

 register_block_type( 'vms/vms-plugin-registration-form', array(
	 'attributes' => array(
	 		'firstname_placeholder' => array(
 				'type' => 'string' ,
 				'default' => 'Nome',
			),
			'lastname_placeholder' => array(
				 'type' => 'string',
				 'default' => 'Cognome'
			),
 		 'email_placeholder' => array(
			  'type' => 'string',
				'default' => 'Email'
 			),
 			'password_placeholder' => array(
				'type' => 'string',
				'default' => 'Password'
			),
 			'password2_placeholder' => array(
				'type' => 'string',
				'default' => 'Conferma password'
			),
 			'nation_placeholder' => array(
				'type' => 'string',
				'default' => 'Nazionalità'
			),
 			'age_placeholder' => array(
				'type' => 'string',
				'default' => 'Età'
			),
 			'submit_button_label' => array(
				'type' => 'string',
				'default' => 'Registrati'
			),
 			'firstname_error' => array(
				'type' => 'string'
			),
		 	'lastname_error' => array(
				'type' => 'string'
			),
		 	'email_missing_error' => array(
				'type' => 'string'
			),
		 	'email_invalid_error' => array(
				'type' => 'string'
			),
		 	'password_missing_error' => array(
				'type' => 'string'
			),
		 	'password_format_error' => array(
				'type' => 'string'
			),
		 	'password_match_error' => array(
				'type' => 'string'
			),
		 	'nation_error' => array(
				'type' => 'string'
			),
		 	'age_error' => array(
				'type' => 'string'
			)
		),
   	'render_callback' => 'vms_plugin_registration_block_render',
) );
