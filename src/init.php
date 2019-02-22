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
			$this->initRoles();
			$this->initDB();
		}

		/**
			* Gutenberg Block
		**/

		function initGutenbergBlocks() {

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

			register_meta( 'post', 'user_creation_successful_message', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'user_not_found_error', array(
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
				plugins_url( 'src/script/vms-script.js', dirname( __FILE__ ) ),
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
					),
					'user_not_found_error' => array(
							'type' => 'text',
							'source' => 'meta',
							'meta' => 'user_not_found_error'
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
		 				'default' => 'Nazione'
		 			),
		  		'age_placeholder' => array(
		 				'type' => 'string',
		 				'default' => 'Età'
		 			),
		  		'submit_button_label' => array(
		 				'type' => 'string',
		 				'default' => 'Registrati'
		 			),
					'privacy_text' => array(
		 				'type' => 'text',
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
					'user_creation_successful_message' => array(
							'type' => 'text',
							'source' => 'meta',
							'meta' => 'user_creation_successful_message'
					)
		 		),
				'editor_script' => 'vms_backend_script',
				'editor_style' => 'vms_backend_style',
				'style' => 'vms_frontend_style',
				'script' => 'vms_frontend_script',
				'render_callback' => array( $this, 'renderRegistrationBlock' ),
		 ) );


		 //User dashboard block
		 register_block_type( 'vms/vms-plugin-user-dashboard', array(
			 'attributes' => array(
				 'dashboard_title' => array(
					 'type' => 'string',
					 'default' => 'Il tuo profilo'
				 ),
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
				 'nation_placeholder' => array(
					 'type' => 'string',
					 'default' => 'Nazione'
				 ),
				 'age_placeholder' => array(
					 'type' => 'string',
					 'default' => 'Età'
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
				 'password_change_button_label' => array(
					 'type' => 'string',
					 'dafault' => 'Cambio password',
				 ),
				 'update_button_label' => array(
					 'type' => 'string',
					 'dafault' => 'Modifica i tuoi dati',
				 ),
		 ),
		 'editor_script' => 'vms_backend_script',
		 'editor_style' => 'vms_backend_style',
		 'style' => 'vms_frontend_style',
		 'script' => 'vms_frontend_script',
		 'render_callback' => array( $this, 'renderUserDashboardBlock' ),
		));
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

			if ( is_user_logged_in() ) {
				return ;
			}

			$nonce = wp_create_nonce('vms-login');

			$html = '<form class="vms_form vms_login_form" post_id=' . get_the_ID() .'>
									<div class="vms_form_modal">
										<div class="vms_form_modal_content">
											<p></p>
											<button type="button" class="vms_form_button">OK</button>
										</div>
									</div>
									<div class="vms_form_field">'
										. $attributes['email_placeholder'] .
										'<input type="email" name="email" autocomplete="off" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
									 	. $attributes['password_placeholder'] .
										'<input type="password" name="password" />
										<span class="vms_form_error"></span>
									</div>
									<input type="submit" value="' . $attributes['submit_button_label'] . '">
									<input type="hidden" name="vms-login-sec" value="' . $nonce . '">
								</form>';
			return $html;
		}

		function renderRegistrationBlock( $attributes, $content ) {

		 	$nonce = wp_create_nonce('vms-registration');

			$nations = $this->get_nations_list();

			$nations_html = '<select name="nation" >
	      									<option disabled selected value></option>';

			foreach ($nations as $nation) {
	    	$nations_html .= '<option value="' . $nation->id . '">' . $nation->name . '</option>';
	    }
	    $nations_html .= '</select>';

		 	$html = '<form class="vms_form vms_registration_form" post_id=' . get_the_ID() .' autocomplete="off">
									<div class="vms_form_modal">
										<div class="vms_form_modal_content">
											<p></p>
											<button type="button" class="vms_form_button">OK</button>
										</div>
									</div>
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
										'<input type="password" name="password" autocomplete="new-password" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['password2_placeholder'] .
										'<input type="password" name="password2" autocomplete="off" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['nation_placeholder'] .$nations_html.
										'<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['age_placeholder'] .
										'<input type="number" name="age" autocomplete="off"/>
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field textual">
										<input type="checkbox" name="privacy_1"/>
										<span>'
										. $attributes['privacy_text'].
										'</span>
										<span class="vms_form_error"></span>
									</div>
									<input type="submit" value="' . $attributes['submit_button_label'] . '"/>
									<input type="hidden" name="vms-registration-sec" value="' . $nonce . '">
								</form>';
			return $html;
		}

		function renderUserDashboardBlock( $attributes, $content ) {

			if ( !is_user_logged_in() ) {
				return ;
			}

			$user_data = wp_get_current_user();

			$nation_name = $this->get_nation_with_id(get_user_meta(  $user_data->ID, 'nation', true ))->name;

			$html = '<div class="vms_user_dashboard">
								<h1><b>' . $attributes['dashboard_title'] . '</b></h1>
								<table>
									<tr>
										<td>'
										.	$attributes['firstname_placeholder'] .
										':</td>
										<td>'
										.	$user_data->first_name .
										'</td>
										<td>
									</tr>
									<tr>
										<td>'
										.	$attributes['lastname_placeholder'] .
										':</td>
										<td>'
										.	$user_data->last_name .
										'</td>
										<td>
									</tr>
									<tr>
										<td>'
										.	$attributes['email_placeholder'] .
										':</td>
										<td>'
										.	$user_data->user_email .
										'</td>
									</tr>
									<tr>
										<td>'
										.	$attributes['nation_placeholder'] .
										':</td>
										<td>'
										. $nation_name .
										'</td>
									</tr>
									<tr>
										<td>'
										.	$attributes['age_placeholder'] .
										':</td>
										<td>'
										. get_user_meta(  $user_data->ID, 'age', true ) .
										'</td>
									</tr>
								</table>
								<div class="vms_user_dashboard_buttons">
									<button>' . $attributes['update_button_label'] . '</button>
									<button>' . $attributes['password_change_button_label'] . '</button>
								</div>
							</div>
			';

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

					$meta = get_post_meta($post_id);

					if(isset($_POST["security"])) {

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
					 } else {
						 $password = trim($_POST['password']);
					 }

					 if( !$hasError ) {

						 //$user_data = get_user_by('email', $email);

						 //if($user_data) {

							 $credentials  = array(
							 	'user_login'    => $email,
	        			'user_password' => $password,
	        			'remember'      => false
							 );

							 $login =  wp_signon( $credentials, true );

							 if ( ! is_wp_error( $login ) ) {
								 $res = array(
									 'success' => true,
									 'target_page' => get_permalink($meta['target_page'][0])
								 );
							 }
							 else {
								 $res = array(
									 'success' => false,
									 'message' => $login->get_error_message(),
								 );
							 }
					 	 /*}
						 else {
							 $res = array(
								 'success' => false,
								 'message' => $meta['user_not_found_error']
							 );
						 }*/
					 }
					 else {
						 $res = array(
						 	'success' => false,
						 	'errors' => $errors
						 );
					 }
				}
			}
			echo json_encode($res);
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

						//Privacy
						if( trim($_POST['privacy']) == 'false' ) {
							$errors['privacy_error'] =  $meta['privacy_error'];
							$hasError = true;
						} else {
							$privacy = trim($_POST['privacy']);
						}

				    if( !$hasError ) {
							$user_data = array(
								'user_login' => $email,
								'user_pass' => $password,
								'user_email' => $email,
								'first_name' => $firstname,
								'last_name' => $lastname,
								'role' => 'iscritto'
							);

							$user_id = wp_insert_user($user_data);

							if ( ! is_wp_error( $user_id ) ) {
								update_user_meta( $user_id, 'nation', $nation );
								update_user_meta( $user_id, 'age', $age );

								$res = array(
									'success' => true,
									'message' => $meta['user_creation_successful_message'],
									'target_page' => get_permalink($meta['target_page'][0])
								);
							}
							else {
								$res = array(
									'success' => false,
									'message' => $user_id->get_error_message(),
								);
							}

							echo json_encode($res);
				    }
						else {

							$res = array(
								'success' => false,
								'errors' => $errors
							);

							echo json_encode($res);
						}
				  }
				}
		    die();
		}



		/**
		* Custon Role - Partecipant
		**/

		function initRoles() {
			$this->add_partecipant_role();

			add_action( 'show_user_profile', array( $this, 'extra_user_profile_fields') );
			add_action( 'edit_user_profile', array( $this, 'extra_user_profile_fields') );
			add_action( 'personal_options_update', array( $this, 'save_extra_user_profile_fields') );
			add_action( 'edit_user_profile_update', array( $this, 'save_extra_user_profile_fields') );

			add_action( 'after_setup_theme', array( $this, 'remove_admin_bar') );
			add_action( 'admin_init', array( $this, 'block_wp_admin') );
		}

		function remove_admin_bar() {
			if (!current_user_can('administrator') && !is_admin()) {
			  show_admin_bar(false);
			}
		}
		function block_wp_admin() {
			if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
				wp_safe_redirect( home_url() );
				exit;
			}
		}

		function add_partecipant_role() {
			add_role(
				'iscritto',
				__( 'Iscritto' ),
					array(
							'read' => true
					)
			);
		}

		function extra_user_profile_fields( $user ) {

			if (!in_array( 'iscritto', $user->roles, true ) ) {
				return false;
			};

			$nations = $this->get_nations_list();
			$user_nation_id = trim( get_user_meta( $user->ID, 'nation', true ));

			?>
			<h3><?php _e("Extra profile information", "blank"); ?></h3>

			<table class="form-table">
			<tr>
					<th><label for="nation"><?php _e("Nazione"); ?></label></th>
					<td>
						<select name="nation" type=nation id=nation>
							<?php

								foreach ($nations as $nation) {
									?>
									<option value=" <?php echo $nation->id ?> " <?php
										if( $nation->id == $user_nation_id ){
											?>
											selected
											<?php
										}
									?>><?php echo $nation->name ?></option>
									<?php
								}
							?>
							</select>
					</td>
			</tr>
			<tr>
					<th><label for="age"><?php _e("Età"); ?></label></th>
					<td>
							<input type="number" name="age" id="age" value="<?php echo esc_attr( get_user_meta( $user->ID, 'age', true ) ); ?>" class="regular-text" /><br />
					</td>
			</tr>
			</table>
		<?php
		}


		function save_extra_user_profile_fields( $user_id ) {

			if ( !current_user_can( 'edit_user', $user_id ) ) {
				return false;
			}

			$user = get_userdata( $user_id );
			if (!in_array( 'iscritto', $user->roles, true ) ) {
				return;
			};

			update_user_meta( $user_id, 'age', $_POST['age'] );
			update_user_meta( $user_id, 'nation', $_POST['nation'] );

			return true;
		}

		/**
		* DB Management
		**/

		function initDB() {
			register_activation_hook( __FILE__, array( $this, 'generateDB' ) );
			register_activation_hook( __FILE__, array( $this, 'generateDataset' ) );
			//register_deactivation_hook(__FILE__, array( $this, 'dropDB' ));
			//register_uninstall_hook(__FILE__, array( $this, 'dropDB' ));
		}


		function generateDB() {
			global $wpdb;

   		$table_name = $wpdb->prefix . "vms_nations";

			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
  			id mediumint(9) NOT NULL AUTO_INCREMENT,
  			name tinytext NOT NULL,
  			PRIMARY KEY  (id)
			) $charset_collate;";


			$table_name = $wpdb->prefix . "vms_categories";

			$sql .= "CREATE TABLE $table_name (
  			id mediumint(9) NOT NULL AUTO_INCREMENT,
  			name tinytext NOT NULL,
  			PRIMARY KEY  (id)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}


		function generateDataset() {
			global $wpdb;

			//Nations
			require_once (plugin_dir_path(__FILE__). 'utils/nations.php');

			$table_name = $wpdb->prefix . "vms_nations";

			foreach ($nations_array as $nation) {
				$wpdb->insert(
					$table_name,
					array(
						'name' => $nation,
					)
				);
			}

			//Categories
			require_once (plugin_dir_path(__FILE__). 'utils/categories.php');

			$table_name = $wpdb->prefix . "vms_categories";

			foreach ($categories_array as $category) {
				$wpdb->insert(
					$table_name,
					array(
						'name' => $category,
					)
				);
			}
		}

		function clearDB() {
			global $wpdb;

	 		$table_name = $wpdb->prefix . 'vms_nations';
	 		$sql = "DELETE FROM $table_name";

			$wpdb->query($sql);

			$table_name = $wpdb->prefix . 'vms_categories';
	 		$sql = "DELETE FROM $table_name";

	 		$wpdb->query($sql);
		}

		function dropDB() {
			global $wpdb;

	 		$table_name = $wpdb->prefix . 'vms_nations';
	 		$sql = "DROP TABLE IF EXISTS $table_name";

			$wpdb->query($sql);

			$table_name = $wpdb->prefix . 'vms_categories';
			$sql = "DROP TABLE IF EXISTS $table_name";

	 		$wpdb->query($sql);
		}

		/**
		 	* Utilities
		**/

		function get_page_list() {
			$args = array(
				'sort_order' => 'asc',
				'sort_column' => 'post_title',
				'post_type' => 'page',
			);
			return  get_pages($args);
		}

		function get_nations_list() {

			global $wpdb;

			$table_name = $wpdb->prefix . "vms_nations";
			$nations = $wpdb->get_results("SELECT * FROM " . $table_name );
			return $nations;
		}

		function get_nation_with_id($id) {
			global $wpdb;

			$table_name = $wpdb->prefix . "vms_nations";
			$nations = $wpdb->get_row("SELECT name FROM " . $table_name . " WHERE id=" . $id );
			return $nations;
		}

	}

	//Plugin Execution
	new VMS;
}
