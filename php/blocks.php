<?php
if ( !class_exists('VMS_Blocks') ) {

  class VMS_Blocks {

    private static $instance = null;

    private function __construct() {
    }

    public static function getInstance() {
      if (self::$instance == null)
      {
        self::$instance = new VMS_Blocks();
      }

      return self::$instance;
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

      register_meta( 'post', 'password_different_error', array(
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

      register_meta( 'post', 'registration_email_subject', array(
          'show_in_rest' => true,
          'type' => 'string',
          'single' => true,
      ) );

      register_meta( 'post', 'registration_email_text', array(
          'show_in_rest' => true,
          'type' => 'string',
          'single' => true,
      ) );

      register_meta( 'post', 'user_not_found_error', array(
          'show_in_rest' => true,
          'type' => 'string',
          'single' => true,
      ) );

      register_meta( 'post', 'category_missing_error', array(
          'show_in_rest' => true,
          'type' => 'string',
          'single' => true,
      ) );

      register_meta( 'post', 'title_missing_error', array(
          'show_in_rest' => true,
          'type' => 'string',
          'single' => true,
      ) );
    }

    function registerBlocks() {

      //Register scripts
      wp_register_script(
        'vms_backend_script',
        plugins_url( '../dist/blocks.build.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-editor' )
      );

      wp_register_script(
        'vms_frontend_script',
        plugins_url( '../src/script/vms-script.js', __FILE__  ),
        array( 'jquery')
      );

      wp_localize_script( 'vms_frontend_script', 'ajax_login_object', array(
          'ajaxurl' => admin_url( 'admin-ajax.php' )
      ));

      //Register style
      wp_register_style(
        'vms_backend_style',
        plugins_url( '../dist/blocks.editor.build.css', __FILE__  ),
        array( 'wp-edit-blocks' )
      );

      wp_register_style(
        'vms_frontend_style',
        plugins_url( '../dist/blocks.style.build.css', __FILE__  ),
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
            'default' => VMS_DB::getInstance()->get_page_list()
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
          ),
          'footer_text' => array(
            'type' => 'string',
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
            'default' => VMS_DB::getInstance()->get_page_list()
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
          ),
          'registration_email_subject' => array(
            'type' => 'text',
            'source' => 'meta',
            'meta' => 'registration_email_subject'
          ),
          'registration_email_text' => array(
            'type' => 'text',
            'source' => 'meta',
            'meta' => 'registration_email_text'
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
         "logout_button_label" => array(
           'type' => 'string',
          'default' => 'Logout',
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
         ),
         'password_different_error' => array(
           'type' => 'string',
           'source' => 'meta',
           'meta' => 'password_different_error'
         ),
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
        ),
        'model_id_label' => array(
          'type' => 'string',
          'default' => 'ID modello'
        ),
        'model_title_label' => array(
          'type' => 'string',
          'default' => 'Titolo'
        ),
        'model_display_label' => array(
          'type' => 'string',
          'default' => 'Display',
        ),
        'model_category_label' => array(
          'type' => 'string',
          'default' => 'Categoria'
        ),
        'model_category_abbreviation_label' => array(
          'type' => 'string',
          'default' => 'Sigla'
        ),
        'add_button_label' => array(
          'type' => 'string',
          'default' => 'Aggiungi un modello'
        ),
        'dialog_header_text' => array(
          'type' => 'string',
          'default' => 'Inserisci i dati del tuo modello.'
        ),
        'save_button_label' => array(
          'type' => 'string',
          'default' => 'Salva'
        ),
        'edit_button_label' => array(
          'type' => 'string',
          'default' => 'Modifica'
        ),
        'cancel_button_label' => array(
          'type' => 'string',
          'default' => 'Annulla'
        ),
        'delete_button_label' => array(
          'type' => 'string',
          'default' => 'Elimina'
        ),
        'delete_header_text' => array(
          'type' => 'string',
          'default' => 'Sei sicuro di voler eliminare questo modello?'
        ),
        'no_models_text' => array(
          'type' => 'string',
          'default' => 'Non hai ancora iscritto modelli. Premi "Aggiungi" per farlo.'
        ),
        'title_missing_error' => array(
          'type' => 'string',
          'source' => 'meta',
          'meta' => 'title_missing_error'
        ),
        'category_missing_error' => array(
          'type' => 'string',
          'source' => 'meta',
          'meta' => 'category_missing_error'
        ),
        'receipt_download_button_label' => array(
          'type' => 'string',
          'default' => 'Scarica ricevuta'
        ),
        'header_text' => array(
          'type' => 'string',
        ),
        'receipt_download_text' => array(
          'type' => 'string',
        )
      ),
      'editor_script' => 'vms_backend_script',
      'editor_style' => 'vms_backend_style',
      'style' => 'vms_frontend_style',
      'script' => 'vms_frontend_script',
      'render_callback' => array( $this, 'renderModelsDashboardBlock' ),
      ));
    }


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
                  <div class="vms_form_buttons">
                    <input type="submit" value="' . $attributes['submit_button_label'] . '">
                    <input type="hidden" name="vms-login-sec" value="' . $nonce . '">
                  </div>
                  <div class="vms_form_footer">'
                    . $attributes['footer_text'] .
                  '</div>
                </form>';
      return $html;
    }


    function renderRegistrationBlock( $attributes, $content ) {

      $nonce = wp_create_nonce('vms-registration');

      //Nations
      $nations = VMS_DB::getInstance()->get_nations_list();

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
                    '<div class="vms_date">
                      <span>'
                        . $days_html .
                      '</span>
                      <span>'
                        . $months_html .
                      '</span>
                      <span>'
                        .	$years_html .
                      '</span>
                    </div>
                    <span class="vms_form_error"></span>
                  </div>
                  <div class="vms_form_field textual fullwidth">
                    <input type="checkbox" name="privacy_1"/>
                    <span>'
                    . $attributes['privacy_text'].
                    '</span>
                    <span class="vms_form_error"></span>
                  </div>
                  <div class="vms_form_buttons">
                    <input type="submit" value="' . $attributes['submit_button_label'] . '"/>
                    <input type="hidden" name="vms-registration-sec" value="' . $nonce . '">
                  </div>
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
      $nations = VMS_DB::getInstance()->get_nations_list();

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


      $nation_name = VMS_DB::getInstance()->get_nation_with_id($user_nation);

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
                      <input type="submit" class="vms_modal_submit_button" value="' . $attributes['save_button_label'] . '"/>
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
                      <div class="vms_modal_buttons">
                        <input type="submit" class="vms_modal_submit_button" value="' . $attributes['save_button_label'] . '"/>
                        <button type="button" class="vms_modal_button">'
                         . $attributes['cancel_button_label'] .
                        '</button>
                      </div>
                    </form>
                  </div>
                </div>
                <h1><b>' . $attributes['dashboard_title'] . '</b></h1>
                <div class="vms_user_dashboard_data">
                  <div class="vms_user_dashboard_data_item">
                    <div class="vms_user_dashboard_data_title">' . $attributes['firstname_placeholder'] . '</div>
                    <div class="vms_user_dashboard_data_content">' . $user_data->first_name . '</div>
                  </div>
                  <div class="vms_user_dashboard_data_item">
                    <div class="vms_user_dashboard_data_title">' .	$attributes['lastname_placeholder'] . '</div>
                    <div class="vms_user_dashboard_data_content">' .	$user_data->last_name . '</div>
                  </div>
                  <div class="vms_user_dashboard_data_item">
                    <div class="vms_user_dashboard_data_title">' .	$attributes['email_placeholder'] . '</div>
                    <div class="vms_user_dashboard_data_content">' . $user_data->user_email . '</div>
                  </div>
                  <div class="vms_user_dashboard_data_item">
                    <div class="vms_user_dashboard_data_title">' .	$attributes['nation_placeholder'] . '</div>
                    <div class="vms_user_dashboard_data_content">' .	$nation_name->name . '</div>
                  </div>
                  <div class="vms_user_dashboard_data_item">
                    <div class="vms_user_dashboard_data_title">' .	$attributes['birthdate_placeholder'] . '</div>
                    <div class="vms_user_dashboard_data_content">' . $birthdate . '</div>
                  </div>
                </div>
                <div class="vms_user_dashboard_buttons">
                  <button class="vms_open_user_update">' . $attributes['update_button_label'] . '</button>
                  <button class="vms_open_change_password">' . $attributes['password_change_button_label'] . '</button>
                  <button class="vms_logout_button">' . $attributes['logout_button_label'] . '</button>
                </div>
              </div>';

      return $html;
    }


    function renderModelsDashboardBlock( $attributes, $content ) {

      if ( !is_user_logged_in() ) {
        return ;
      }

      $user_data = wp_get_current_user();

      //Categories
      $categories = VMS_DB::getInstance()->get_categories_list();

      $categories_html = '<select name="category">';
      $categories_html .= '<option disabled selected value></option>';

      foreach ($categories as $category) {
        $categories_html .= '<option value="' . $category->id . '">' . $category->sigla. ' - ' . $category->name . '</option>';
      }
      $categories_html .= '</select>';

      //Models
      $models = VMS_DB::getInstance()->get_models_list_for_modelist($user_data->ID);

      if(count($models) === 0) {
        $models_html = '<div>'. $attributes['no_models_text'] . '</div>';
      }
      else {

        $models_html = '<div class="vms_models">';

        foreach ($models as $model) {

          $models_html .= '<div class="vms_model_item">
            <div class="vms_model_title">' . ucfirst($model->title) . '</div>
            <div class="vms_model_info">
              <div class="vms_model_info_title">' . $attributes['model_id_label'] . '</div>
              <div class="vms_model_info_text">' . sprintf('%04d', $model->id) . '</div>
            </div>
            <div class="vms_model_info">
              <div class="vms_model_info_title">' . $attributes['model_category_label'] . '</div>
              <div class="vms_model_info_text">' . $model->category . '</div>
            </div>
            <div class="vms_model_info">
              <div class="vms_model_info_title">' . $attributes['model_category_abbreviation_label'] . '</div>
              <div class="vms_model_info_text">' . $model->sigla . '</div>
            </div>';

          if(isset( $model->display)) {
            $models_html .= '<div class="vms_model_info">
                <div class="vms_model_info_title">' . $attributes['model_display_label'] . '</div>
                <div class="vms_model_info_text">' . sprintf('%03d', $model->display) . '</div>
              </div>';
          }
          $models_html .= '<div class="vms_model_buttons">
              <button data-category-id="' . $model->categoryId .
                     '"data-model-id="' . $model->id .
                     '"data-title="' . $model->title .
              '" class="vms_update_model_button">' . $attributes['edit_button_label'] . '</button>
              <button class="vms_delete_model_button" data-model-id="' . $model->id .'">' . $attributes['delete_button_label'] . '</button>
            </div>
          </div>';
        }

        $models_html .= '</div>';
      }

      $model_nonce = wp_create_nonce('vms-model');
      $model_delete_nonce = wp_create_nonce('vms-model-delete');

      $user_data = wp_get_current_user();
      $user_last_update = trim( get_user_meta( $user_data->ID, 'last_update', true ));
      $user_last_receipt_download = trim( get_user_meta( $user_data->ID, 'last_receipt_download', true ));

      if( count($models) > 0 ) {
        if( $user_last_receipt_download > $user_last_update) {
          $receipt_html = '<button type="submit">' . $attributes['receipt_download_button_label'] . '</button>';
        }
        else {
          $receipt_html = '<button class="red" type="submit">' . $attributes['receipt_download_button_label'] . '</button>
                           <div>' . $attributes['receipt_download_text'] . '</div>';
        }
      }

      $html = '<div class="vms_models_dashboard">
                  <div class="vms_modal">
                    <div class="vms_modal_content">
                      <form class="vms_form vms_model_form" post_id=' . get_the_ID() .' autocomplete="off">
                        <div class="vms_form_text">'
                          . $attributes['dialog_header_text'] .
                        '</div>
                        <div class="vms_form_field">'
                          . $attributes['model_title_label'] .
                          '<input type="text" name="title" autocomplete="new-password"/>
                          <span class="vms_form_error"></span>
                        </div>
                        <div class="vms_form_field">'
                          . $attributes['model_category_label'] . $categories_html.
                          '<span class="vms_form_error"></span>
                        </div>
                        <input type="hidden" name="vms-model-sec" value="' . $model_nonce . '">
                        <div class="vms_modal_buttons">
                          <input class="vms_modal_submit_button" type="submit" value="' . $attributes['save_button_label'] . '"/>
                          <button type="button" class="vms_modal_button">'
                           . $attributes['cancel_button_label'] .
                          '</button>
                        </div>
                      </form>
                      <form class="vms_form vms_model_delete_form" post_id=' . get_the_ID() .' autocomplete="off">
                        <div class="vms_form_text">'
                          . $attributes['delete_header_text'] .
                        '</div>
                        <input type="hidden" name="vms-model-delete-sec" value="' . $model_delete_nonce . '">
                        <div class="vms_modal_buttons">
                          <input class="vms_modal_submit_button" type="submit" value="' . $attributes['delete_button_label'] . '"/>
                          <button type="button" class="vms_modal_button">'
                            . $attributes['cancel_button_label'] .
                          '</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <h1><b>' . $attributes['dashboard_title'] . '</b></h1>
                  <form class="vms_models_receipt" method="post" action="' . admin_url( 'admin-post.php' ) . '">
                    <input type="hidden" name="locale" value="' . get_locale() . '">
                    <input type="hidden" name="action" value="vms_receipt_download_action">
                    ' . $attributes['header_text'] . '
                    <div class="vms_models_receipt_buttons">'. $receipt_html . '</div>
                  </form>'
                  . $models_html .
                  '<div class="vms_models_dashboard_buttons">
                    <button class="vms_add_model_button">' . $attributes['add_button_label'] . '</button>
                  </div>
               </div>';

      return $html;
    }

  }
}

?>
