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
			$this->registerMeta();
			$this->registerBlocks();
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

			register_meta( 'post', 'first_name_missing_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'last_name_missing_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'password_invalid_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'password_match_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'password_format_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'nation_missing_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'age_missing_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'privacy_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

		}

		function registerBlocks() {

			//Register scripts
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

			//Login block

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

			//Registration block

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
		  		'first_name_missing_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'default' => 'Il campo nome è obbligatorio',
						'meta' => 'first_name_missing_error'
		 			),
		 		 	'last_name_missing_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'last_name_missing_error'
		 			),
		 		 	'email_missing_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'email_missing_error'
		 			),
		 		 	'email_invalid_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'email_invalid_error'
		 			),
		 		 	'password_missing_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'password_missing_error'
		 			),
		 		 	'password_format_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'password_format_error'
		 			),
		 		 	'password_match_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'password_match_error'
		 			),
		 		 	'nation_missing_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'nation_missing_error'
		 			),
		 		 	'age_missing_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'age_missing_error'
		 			),
					'privacy_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'privacy_error'
		 			)
		 		),
				'editor_script' => 'vms_backend_script',
				'editor_style' => 'vms_backend_style',
				'style' => 'vms_frontend_style',
				'script' => 'vms_frontend_script',
				'render_callback' => array( $this, 'renderRegistrationBlock' ),
		 ) );
		}


		function registerActions(){
			add_action( 'wp_ajax_vms_login_action', array( $this, 'vms_login_action' ) );
			add_action( 'wp_ajax_nopriv_vms_login_action', array( $this, 'vms_login_action' ) );

			add_action( 'wp_ajax_vms_registration_action', array( $this, 'vms_registration_action' ) );
			add_action( 'wp_ajax_nopriv_vms_registration_action', array( $this, 'vms_registration_action' ) );
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

		function renderRegistrationBlock( $attributes, $content ) {

		 	$nonce = wp_create_nonce('vms-registration');

		 	$html = '<form class="vms_form vms_registration_form" post_id=' . get_the_ID() .' autocomplete="off">
									<div class="vms_form_field">'
										. $attributes['firstname_placeholder'] .
										'<input type="text" name="firstname" autocomplete="off" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['lastname_placeholder'] .
										'<input type="text" name="lastname" autocomplete="off" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['email_placeholder'] .
										'<input type="email" name="email" autocomplete="off" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['password_placeholder'] .
										'<input type="password" name="password" autocomplete="off" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['password2_placeholder'] .
										'<input type="password" name="password2" autocomplete="off" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['nation_placeholder'] .
										'<input type="text" name="nation" autocomplete="off" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['age_placeholder'] .
										'<input type="number" name="age" autocomplete="off"/>
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field textual">
										<input type="checkbox" name="privacy_1" />
										<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
										sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam,
										quis nostrud exercitation ullamco laboris nisi ut aliquip
										ex ea commodo consequat. <a href="http://google.com">Duis aute irure dolor in reprehenderit</a>
										in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</span>
										<span class="vms_form_error"></span>
									</div>
									<input type="submit" value="' . $attributes['submit_button_label'] . '"/>
									<input type="hidden" name="vms-registration-sec" value="' . $nonce . '">
								</form>';
			return $html;
		}

		/**
		 *	Ajax actions response
		**/

		//Login
		function vms_login_action(){

		    check_ajax_referer( 'vms-login', 'security' );

				$post_id = $_POST['post_id'];

				if(isset($post_id)){
					echo json_encode(array('post_meta' => get_post_meta($post_id)));
				}
				die();
		}


		//Registration

		function vms_registration_action(){

		    check_ajax_referer( 'vms-registration', 'security' );

				$post_id = $_POST['post_id'];

				if(isset($post_id)){

					$meta = get_post_meta($post_id);

					if(isset($_POST["security"])) {

				    //First Name
				    if( trim($_POST['firstname']) === '' ) {
				      $errors['first_name_missing_error'] = $meta['first_name_missing_error'];
				      $hasError = true;
				    } else {
				      $firstname = trim($_POST['firstname']);
				    }

				    //Last Name
				    if( trim($_POST['lastname']) === '' ) {
				      $errors['last_name_missing_error'] =  $meta['last_name_missing_error'];
				      $hasError = true;
				    } else {
				      $lastname = trim($_POST['lastname']);
				    }

				    //Email
				    if( trim($_POST['email']) === '' )  {
				      $errors['email_missing_error'] =  $meta['email_missing_error'];
				      $hasError = true;
				    } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
				      $errors['email_invalid_error'] =  $meta['email_invalid_error'];
				      $hasError = true;
				    } else {
				      $email = trim($_POST['email']);
				    }

				    //Password
				    if( trim($_POST['password']) === '' )  {
				      $errors['password_missing_error'] =  $meta['password_missing_error'];
				      $hasError = true;
				    } else if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", trim($_POST['password']))) {
				      $errors['password_format_error'] =  $meta['password_format_error'];
				      $hasError = true;
				    }
				    else {
				      $password = trim($_POST['password']);
				    }

				    //Repeat password
				    if( !$passwordError && $password ) {
				      if( ( trim($_POST['password2']) === '' ) || ( $_POST['password2'] !== $password ) )  {
				        $errors['password_match_error'] = $meta['password_match_error'];
				        $hasError = true;
				      }
				    }

				    //Nation
				    if( trim($_POST['nation']) === '' ) {
				      $errors['nation_missing_error'] =  $meta['nation_missing_error'];
				      $hasError = true;
				    } else {
				      $nation = trim($_POST['nation']);
				    }

				    //Age
				    if( trim($_POST['age']) === '' ) {
				      $errors['age_missing_error'] =  $meta['age_missing_error'];
				      $hasError = true;
				    } else {
				      $age = trim($_POST['age']);
				    }

				    if(!$hasError){
							echo json_encode("tutto regolare!");
				    }
						else {
							echo json_encode($errors);
						}
				  }
				}
		    die();
		}


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
