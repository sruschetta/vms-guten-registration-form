<?php
/**
 * @wordpress-plugin
 * Plugin Name: 			VMS Contest Manager
 * Description:       This is the Verbania Model Show Contest Manager official plugin.
 * Version:           1.0.0
 * Author:            Stefano Ruschetta
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
**/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists('VMS') ) {

	class VMS {

		function __construct() {

			/*if ( ! function_exists( 'register_block_type' ) ) {
				return;
			}*/

			$this->initDB();
			$this->initRoles();
			$this->initGutenbergBlocks();
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

			register_meta( 'post', 'email_match_error', array(
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

			register_meta( 'post', 'birthdate_missing_error', array(
					'show_in_rest' => true,
					'type' => 'string',
					'single' => true,
			) );

			register_meta( 'post', 'invalid_date_error', array(
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
				plugins_url( 'dist/blocks.build.js', __FILE__ ),
				array( 'wp-blocks', 'wp-element', 'wp-editor' )
			);

			wp_register_script(
				'vms_frontend_script',
				plugins_url( 'src/script/vms-script.js', __FILE__  ),
				array( 'jquery')
			);

			wp_localize_script( 'vms_frontend_script', 'ajax_login_object', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' )
			));

			//Register style
			wp_register_style(
				'vms_backend_style',
				plugins_url( './dist/blocks.editor.build.css', __FILE__  ),
				array( 'wp-edit-blocks' )
			);

			wp_register_style(
				'vms_frontend_style',
				plugins_url( './dist/blocks.style.build.css', __FILE__  ),
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
					'email2_placeholder' => array(
							'type' => 'string',
							'default' => 'Conferma email'
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
		  		'birthdate_placeholder' => array(
		 				'type' => 'string',
		 				'default' => 'Data di nascita'
		 			),
					'day_placeholder' => array(
						'type' => 'string',
						'default' => 'Giorno'
					),
					'month_placeholder' => array(
						'type' => 'string',
						'default' => 'Mese'
					),
					'year_placeholder' => array(
						'type' => 'string',
						'default' => 'Anno'
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
					'email_match_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'email_match_error',
						'default' => 'Le email inserite devono coincidere.'
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
		 		 	'birthdate_missing_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'birthdate_missing_error'
		 			),
					'invalid_date_error' => array(
		 				'type' => 'string',
						'source' => 'meta',
						'meta' => 'invalid_date_error'
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
						 'default' => 'Nome'
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
				 'birthdate_placeholder' => array(
					 'type' => 'string',
					 'default' => 'Data di nascita'
				 ),
				 'password_change_button_label' => array(
					 'type' => 'string',
					 'default' => 'Cambio password'
				 ),
				 'update_button_label' => array(
					 'type' => 'string',
					 'default' => 'Modifica i tuoi dati'
				 ),
				 'old_password_placeholder' => array(
					 'type' => 'string',
					 'default' => 'Inserisci la password corrente'
				 ),
				 'new_password_placeholder' => array(
					 'type' => 'string',
					 'default' => 'Inserisci la nuova password'
				 ),
				 'new_password2_placeholder' => array(
					 'type' => 'string',
					 'default' => 'Conferma la nuova password',
				 ),
				 "save_button_label" => array(
					 'type' => 'string',
					 'default' => 'Salva',
				 ),
				 "cancel_button_label" => array(
					'type' => 'string',
					'default' => 'Annulla',
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
				 'nation_missing_error' => array(
					 'type' => 'string',
					 'source' => 'meta',
					 'meta' => 'nation_missing_error'
				 ),
				 'birthdate_missing_error' => array(
					 'type' => 'string',
					 'source' => 'meta',
					 'meta' => 'birthdate_missing_error'
				 ),
				 'invalid_date_error' => array(
					 'type' => 'string',
					 'source' => 'meta',
					 'meta' => 'invalid_date_error'
				 ),
				 'password_missing_error' => array(
					 'type' => 'string',
					 'source' => 'meta',
					 'meta' => 'password_missing_error'
				 ),
				 'password_invalid_error' => array(
					 'type' => 'string',
					 'source' => 'meta',
					 'meta' => 'password_invalid_error'
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
				 )
		 ),
		 'editor_script' => 'vms_backend_script',
		 'editor_style' => 'vms_backend_style',
		 'style' => 'vms_frontend_style',
		 'script' => 'vms_frontend_script',
		 'render_callback' => array( $this, 'renderUserDashboardBlock' ),
		));


		//Models dashboard
		register_block_type( 'vms/vms-plugin-models-dashboard', array(
			'attributes' => array(
				'dashboard_title' => array(
					'type' => 'string',
					'default' => 'I tuoi modelli'
				)
		),
		'editor_script' => 'vms_backend_script',
		'editor_style' => 'vms_backend_style',
		'style' => 'vms_frontend_style',
		'script' => 'vms_frontend_script',
		'render_callback' => array( $this, 'renderModelsDashboardBlock' ),
	 ));


		}


		function registerActions(){
			add_action( 'wp_ajax_vms_login_action', array( $this, 'vms_login_action' ) );
			add_action( 'wp_ajax_nopriv_vms_login_action', array( $this, 'vms_login_action' ) );

			add_action( 'wp_ajax_vms_registration_action', array( $this, 'vms_registration_action' ) );
			add_action( 'wp_ajax_nopriv_vms_registration_action', array( $this, 'vms_registration_action' ) );

			add_action( 'wp_ajax_vms_update_user_action', array( $this, 'vms_update_user_action' ) );
			add_action( 'wp_ajax_vms_update_password_action', array( $this, 'vms_update_password_action' ) );

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
									<div class="vms_modal">
										<div class="vms_modal_content">
											<p></p>
											<button type="button" class="vms_modal_button">OK</button>
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

			//Nations
			$nations = $this->get_nations_list();

			$nations_html = '<select name="nation" >
	      									<option disabled selected value></option>';

			foreach ($nations as $nation) {
	    	$nations_html .= '<option value="' . $nation->id . '">' . $nation->name . '</option>';
	    }
	    $nations_html .= '</select>';

			//Days
			$days_html = '<select name="day">
												<option disabled selected value>' . $attributes['day_placeholder'] . '</option>';

			for ($i = 1; $i <= 31; $i++) {
				$days_html .= '<option value="' . $i . '">' . sprintf("%02d", $i) . '</option>';
			}
			$days_html .= '</select>';

			//Months

			$months_html = '<select name="month" >
												<option disabled selected value>' . $attributes['month_placeholder'] . '</option>';

			for ($i = 1; $i <= 12; $i++) {
				$months_html .= '<option value="' . $i . '">' . sprintf("%02d", $i) . '</option>';
			}
			$months_html .= '</select>';

			//Years

			$years_html = '<select name="year" >
												<option disabled selected value>' . $attributes['year_placeholder'] . '</option>';

			for ($i = 2019; $i >= 1920; $i--) {
				$years_html .= '<option value="' . $i . '">' . $i . '</option>';
			}
			$years_html .= '</select>';


		 	$html = '<form class="vms_form vms_registration_form" post_id=' . get_the_ID() .' autocomplete="off">
									<div class="vms_modal">
										<div class="vms_modal_content">
											<p></p>
											<button type="button" class="vms_modal_button">OK</button>
										</div>
									</div>
									<div class="vms_form_field">'
										. $attributes['firstname_placeholder'] .
										'<input type="text" name="firstname" autocomplete="new-password" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['lastname_placeholder'] .
										'<input type="text" name="lastname" autocomplete="new-password" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['email_placeholder'] .
										'<input type="email" name="email" autocomplete="new-password" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['email2_placeholder'] .
										'<input type="email" name="email2" autocomplete="new-password" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['password_placeholder'] .
										'<input type="password" name="password" autocomplete="new-password" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['password2_placeholder'] .
										'<input type="password" name="password2" autocomplete="new-password" />
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['nation_placeholder'] .$nations_html.
										'<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field">'
										. $attributes['birthdate_placeholder'] .
										'<div class="vms_date">' .
										'<span>'
											. $days_html .
										'</span>
										<span>'
											. $months_html .
										'</span>
										<span>'
										 	.	$years_html .
										'</span>
										<span class="vms_form_error"></span>
									</div>
									<div class="vms_form_field textual fullwidth">
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

			$user_day = get_user_meta(  $user_data->ID, 'day', true );
			$user_month = get_user_meta(  $user_data->ID, 'month', true );
			$user_year = get_user_meta(  $user_data->ID, 'year', true );
			$user_nation = get_user_meta(  $user_data->ID, 'nation', true );

			$update_user_nonce = wp_create_nonce('vms-update-user');
			$update_password_nonce = wp_create_nonce('vms-update-password');

			//Nations
			$nations = $this->get_nations_list();

			$nations_html = '<select name="nation" data-value="'. $user_nation .'">';

			foreach ($nations as $nation) {
				if($nation->id == $user_nation) {
					$nations_html .= '<option value="' . $nation->id . '" selected>' . $nation->name . '</option>';
				} else {
					$nations_html .= '<option value="' . $nation->id . '">' . $nation->name . '</option>';
				}
			}
			$nations_html .= '</select>';

			//Days
			$days_html = '<select name="day" data-value="'. $user_day .'">';

			for ($i = 1; $i <= 31; $i++) {
				if($i == $user_day) {
					$days_html .= '<option value="' . $i . '" selected>' . sprintf("%02d", $i) . '</option>';
				}
				else {
					$days_html .= '<option value="' . $i . '">' . sprintf("%02d", $i) . '</option>';
				}
			}
			$days_html .= '</select>';

			//Months

			$months_html = '<select name="month" data-value="'. $user_month .'">';

			for ($i = 1; $i <= 12; $i++) {
				if($i == $user_month) {
					$months_html .= '<option value="' . $i . '" selected>' . sprintf("%02d", $i) . '</option>';
				}
				else {
					$months_html .= '<option value="' . $i . '">' . sprintf("%02d", $i) . '</option>';
				}
			}
			$months_html .= '</select>';

			//Years

			$years_html = '<select name="year" data-value="'. $user_year .'">';

			for ($i = 2019; $i >= 1920; $i--) {
				if($i == $user_year) {
					$years_html .= '<option value="' . $i . '" selected>' . sprintf("%02d", $i) . '</option>';
				}
				else {
					$years_html .= '<option value="' . $i . '">' . sprintf("%02d", $i) . '</option>';
				}
			}
			$years_html .= '</select>';


			$nation_name = $this->get_nation_with_id($user_nation);

			if(get_locale() == "it_IT") {
				$birthdate = $user_day
										. "/" .
										$user_month
										. "/" .
										$user_year;
				$date_block = '<span>'
												. $days_html .
											'</span>
											<span>'
												. $months_html .
											'</span>
											<span>'
												.	$years_html .
											'</span>';
			}else {
				$birthdate = $user_month
										. "/" .
										$user_day
										. "/" .
										$user_year;
				$date_block = '<span>'
												. $months_html .
											'</span>
											<span>'
												. $day_html .
											'</span>
											<span>'
												.	$years_html .
											'</span>';
			}

			$html = '<div class="vms_user_dashboard">
								<div class="vms_modal">
									<div class="vms_modal_content">
										<form class="vms_form vms_update_user_form" post_id=' . get_the_ID() .' autocomplete="off">
											<div class="vms_form_field">'
												. $attributes['firstname_placeholder'] .
												'<input type="text" name="firstname" autocomplete="new-password"
													data-value="' . $user_data->first_name .'" value="' . $user_data->first_name .'"/>
												<span class="vms_form_error"></span>
											</div>
											<div class="vms_form_field">'
												. $attributes['lastname_placeholder'] .
												'<input type="text" name="lastname" autocomplete="new-password"
												data-value="' . $user_data->last_name .'" value="' . $user_data->last_name .'" />
												<span class="vms_form_error"></span>
											</div>
											<div class="vms_form_field">'
												. $attributes['nation_placeholder'] .$nations_html.
												'<span class="vms_form_error"></span>
											</div>
											<div class="vms_form_field">'
												. $attributes['birthdate_placeholder'] .
												'<div class="vms_date">'
												. $date_block .
												'</div>
												<span class="vms_form_error"></span>
											</div>
											<input type="hidden" name="vms-update-user-sec" value="' . $update_user_nonce . '">
											<input type="submit" value="' . $attributes['save_button_label'] . '"/>
											<button type="button" class="vms_modal_button">'
											 . $attributes['cancel_button_label'] .
											'</button>
										</form>
										<form class="vms_form vms_update_password_form" post_id=' . get_the_ID() .' autocomplete="off">
											<div class="vms_form_field">'
												. $attributes['old_password_placeholder'] .
												'<input type="password" name="old_password" autocomplete="new-password" />
												<span class="vms_form_error"></span>
											</div>
											<div class="vms_form_field">'
												. $attributes['new_password_placeholder'] .
												'<input type="password" name="new_password" autocomplete="new-password" />
												<span class="vms_form_error"></span>
											</div>
											<div class="vms_form_field">'
												. $attributes['new_password2_placeholder'] .
												'<input type="password" name="new_password2" autocomplete="new-password" />
												<span class="vms_form_error"></span>
											</div>
											<input type="hidden" name="vms-update-password-sec" value="' . $update_password_nonce . '">
											<input type="submit" value="' . $attributes['save_button_label'] . '"/>
											<button type="button" class="vms_modal_button">'
											 . $attributes['cancel_button_label'] .
											'</button>
										</form>
									</div>
								</div>
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
										. $nation_name->name .
										'</td>
									</tr>
									<tr>
										<td>'
										.	$attributes['birthdate_placeholder'] .
										':</td>
										<td>'
										. $birthdate .
										'</td>
									</tr>
								</table>
								<div class="vms_user_dashboard_buttons">
									<button class="vms_open_user_update">' . $attributes['update_button_label'] . '</button>
									<button class="vms_open_change_password">' . $attributes['password_change_button_label'] . '</button>
								</div>
							</div>
			';

			return $html;
		}


		function renderModelsDashboardBlock( $attributes, $content ) {

			if ( !is_user_logged_in() ) {
				return ;
			}

			$html = '<div class="vms_models_dashboard">
							 		<h1><b>' . $attributes['dashboard_title'] . '</b></h1>
							 </div>';

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
						 	'errors' => $errors,
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

						//Repeat email

						if( $email ) {
						 if( ( trim($_POST['email2']) === '' ) || ( $_POST['email2'] !== $email ) )  {
							 $errors['email_match_error'] = $meta['email_match_error'];
							 $hasError = true;
						 }
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
				    if( $password ) {
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

				    //Birthdate
				    if( trim($_POST['day']) === '' ||  trim($_POST['month']) === '' || trim($_POST['year']) === '' ) {
				      $errors['birthdate_missing_error'] =  $meta['birthdate_missing_error'];
				      $hasError = true;
				    } else {
				      $day = trim($_POST['day']);
							$month = trim($_POST['month']);
							$year = trim($_POST['year']);

							if(!checkdate($month, $day, $year)){
								$errors['invalid_date_error'] =  $meta['invalid_date_error'];
							 	$hasError = true;
							}
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
								update_user_meta( $user_id, 'day', $day );
								update_user_meta( $user_id, 'month', $month );
								update_user_meta( $user_id, 'year', $year );

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


		//User Update Action

		function vms_update_user_action() {

			check_ajax_referer( 'vms-update-user', 'security' );

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

					//Nation
					if( trim($_POST['nation']) === '' ) {
						$errors['nation_missing_error'] =  $meta['nation_missing_error'];
						$hasError = true;
					} else {
						$nation = trim($_POST['nation']);
					}

					//Birthdate
					if( trim($_POST['day']) === '' ||  trim($_POST['month']) === '' || trim($_POST['year']) === '' ) {
						$errors['birthdate_missing_error'] =  $meta['birthdate_missing_error'];
						$hasError = true;
					} else {
						$day = trim($_POST['day']);
						$month = trim($_POST['month']);
						$year = trim($_POST['year']);

						if(!checkdate($month, $day, $year)){
							$errors['invalid_date_error'] =  $meta['invalid_date_error'];
							$hasError = true;
						}
					}

					if( !$hasError ) {

						$user_data = wp_get_current_user();
						$user_id = $user_data->ID;

						$user_new_data = array(
							'ID' => $user_id,
							'first_name' => $firstname,
							'last_name' => $lastname
						);

						$user_id = wp_update_user( $user_new_data );

						if($user_id) {
							update_user_meta( $user_id, 'nation', $nation );
							update_user_meta( $user_id, 'day', $day );
							update_user_meta( $user_id, 'month', $month );
							update_user_meta( $user_id, 'year', $year );
							$res = array(
								'success' => true,
							);
						}
						else {
							$res = array(
								'success' => false,
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


		//Password Update Action

		function vms_update_password_action() {

			check_ajax_referer( 'vms-update-password', 'security' );

			$post_id = $_POST['post_id'];

			if(isset($post_id)){

				$meta = get_post_meta($post_id);

				if(isset($_POST["security"])) {

					//Old password
					if( trim($_POST['old_password']) === '' ) {
						$errors['old_password_missing_error'] = $meta['password_missing_error'];
						$hasError = true;
					}

					if(!$hasError) {
						$current_user = wp_get_current_user();
						$auth =  wp_authenticate( $current_user->user_login, $_POST['old_password'] );

						if( is_wp_error($auth) ) {
							$errors['old_password_invalid_error'] = $meta['password_invalid_error'];
							$hasError = true;

							$res = array(
								'success' => false,
								'errors' => $errors
							);

							echo json_encode($res);
							die();
						}
					}

					//New password
					if( trim($_POST['new_password']) === '' )  {
						$errors['new_password_missing_error'] =  $meta['password_missing_error'];
						$hasError = true;
					} else if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", trim($_POST['new_password']))) {
						$errors['new_password_format_error'] =  $meta['password_format_error'];
						$hasError = true;
					}
					else {
						$password = trim($_POST['new_password']);
					}

					//Repeat password
					if( $password ) {
						if( ( trim($_POST['new_password2']) === '' ) || ( $_POST['new_password2'] !== $password ) )  {
							$errors['new_password_match_error'] = $meta['password_match_error'];
							$hasError = true;
						}
					}

					if( !$hasError ) {
						$current_user = wp_get_current_user();
						wp_set_password($password, $current_user->ID);
						wp_set_auth_cookie($current_user->ID);
						wp_set_current_user($current_user->ID);
						do_action('wp_login', $current_user->user_login, $current_user);

						$res = array(
							'success' => true,
						);

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
			$user_day = trim( get_user_meta( $user->ID, 'day', true ));
			$user_month = trim( get_user_meta( $user->ID, 'month', true ));
			$user_year = trim( get_user_meta( $user->ID, 'year', true ));
			?>
			<h3><?php _e("Extra profile information", "blank"); ?></h3>

			<table class="form-table">
			<tr>
					<th><label for="nation"><?php _e("Nazione"); ?></label></th>
					<td>
						<select name="nation" type=nation id=nation>
							<option disabled selected value></option>';
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
					<th><label><?php _e("Data di nascita"); ?></label></th>
					<td>
						<select name="day" type=day id=day style="width:100px">
							<option disabled selected value></option>';
							<?php
								for ($i=1; $i <= 31 ; $i++) {
									?>
									<option value=" <?php echo $i ?> " <?php
										if( $i == $user_day ){
											?>
											selected
											<?php
										}
									?>><?php echo sprintf("%02d", $i)  ?></option>
									<?php
								}
							?>
							</select>
							<select name="month" type=month id=month style="width:100px">
								<option disabled selected value></option>';
								<?php
									for ($i=1; $i <= 12 ; $i++) {
										?>
										<option value=" <?php echo $i ?> " <?php
											if( $i == $user_month ){
												?>
												selected
												<?php
											}
										?>><?php echo sprintf("%02d", $i)  ?></option>
										<?php
									}
								?>
								</select>
								<select name="year" type=year id=year style="width:100px">
									<option disabled selected value></option>';
									<?php
										for ($i=2019; $i > 1920 ; $i--) {
											?>
											<option value=" <?php echo $i ?> " <?php
												if( $i == $user_year ){
													?>
													selected
													<?php
												}
											?>><?php echo $i  ?></option>
											<?php
										}
									?>
									</select>
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
				return false;
			};

			if(!checkdate($_POST['month'], $_POST['day'], $_POST['year'])){
				return false;
			}

			update_user_meta( $user_id, 'day', trim($_POST['day']) );
			update_user_meta( $user_id, 'month', trim($_POST['month']) );
			update_user_meta( $user_id, 'year', trim($_POST['year']) );
			update_user_meta( $user_id, 'nation', trim($_POST['nation']) );

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
  			it tinytext NOT NULL,
				en tinytext NOT NULL,
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
			require_once (plugin_dir_path(__FILE__). './src/utils/nations.php');

			$table_name = $wpdb->prefix . "vms_nations";

			foreach ($nations_array as $nation) {
				$wpdb->insert(
					$table_name,
					array(
						'it' => $nation['it'],
						'en' => $nation['en']
					)
				);
			}

			//Categories
			require_once (plugin_dir_path(__FILE__). './src/utils/categories.php');

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

			$nation_locale_id = (get_locale() == "it_IT")? "it" : "en";

			$table_name = $wpdb->prefix . "vms_nations";
			$nations = $wpdb->get_results("SELECT id," . $nation_locale_id .  " AS name FROM " . $table_name );
			return $nations;
		}

		function get_nation_with_id($id) {
			global $wpdb;

			$nation_locale_id = (get_locale() == "it_IT")? "it" : "en";

			$table_name = $wpdb->prefix . "vms_nations";
			$nations = $wpdb->get_row("SELECT id," . $nation_locale_id .  "  AS name FROM " . $table_name . " WHERE id=" . $id );
			return $nations;
		}

	}

	//Plugin Execution
	$vms = new VMS;
}
