<?php

if ( !class_exists('VMS_Admin') ) {

  class VMS_Admin {

    private static $instance = null;

    private function __construct() {
    }

    public static function getInstance() {
      if (self::$instance == null)
      {
        self::$instance = new VMS_Admin();
      }

      return self::$instance;
    }

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
      //if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
      //	wp_safe_redirect( home_url() );
      //	exit;
      //}
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

      $nations = VMS_DB::getInstance()->get_nations_list();
      $user_nation_id = trim( get_user_meta( $user->ID, 'nation', true ));
      $user_day = trim( get_user_meta( $user->ID, 'day', true ));
      $user_month = trim( get_user_meta( $user->ID, 'month', true ));
      $user_year = trim( get_user_meta( $user->ID, 'year', true ));

      $categories = VMS_DB::getInstance()->get_categories_list();

      ?>
      <h2><?php _e("Extra profile information", "blank"); ?></h2>
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
      $models = VMS_DB::getInstance()->get_models_list_for_modelist($user->ID);

      $categories_html = '<select name="category">';
      $categories_html .= '<option disabled selected value></option>';

      foreach ($categories as $category) {
        $categories_html .= '<option value="' . $category->id . '">' . $category->sigla. ' - ' . $category->name . '</option>';
      }
      $categories_html .= '</select>';
    ?>
    <h2><?php _e("Models", "blank"); ?></h2>
    <div class="vms_admin_models">
      <table class="vms_admin_table">
        <thead>
          <tr>
              <th>ID</th>
              <th>Titolo</th>
              <th>Categoria</th>
              <th>Sigla</th>
              <th>Display</th>
              <th></th>
          </tr>
        </thead>
        <tbody>
      <?php
        foreach ($models as $model) {

          $display = isset( $model->display)?sprintf('%03d', $model->display):'';

          ?>
          <tr>
            <td><?php echo sprintf('%05d', $model->id) ?></td>
            <td><?php echo $model->title ?></td>
            <td><?php echo $model->category ?></td>
            <td><?php echo $model->sigla ?></td>
            <td><?php echo $display ?></td>
            <td class="buttons">
              <button type="button"
                      class="button vms_admin_update_model_button"
                      data-category-id="<?php echo $model->categoryId ?>"
                      data-model-id="<?php echo $model->id ?>"
                      data-title="<?php echo $model->title ?>"
                      data-user="<?php echo $user->ID ?>">Modifica</button>
              <button type="button"
                      class="button vms_admin_delete_model_button"
                      data-model-id="<?php echo $model->id ?>">Elimina</button>
            </td>
          </tr>
          <?php
        }
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
              <button class="button vms_admin_add_model_button button-primary"
                      type="button">Aggiungi</button>
            </td>
          </tr>
        </tfoot>
        </table>
        <div class="vms_admin_modal">
          <div class="vms_admin_modal_content">
            <div class="vms_admin_form vms_admin_delete_form">
              <div>
                <span>Vuoi eliminare il modello selezionato?</span>
                <div class="vms_admin_modal_buttons">
                  <button type="button" class="button button-primary vms_admin_delete_model_button">Elimina</button>
                  <button type="button" class="button vms_admin_close_button">Annulla</button>
                </div>
              </div>
            </div>
            <div class="vms_admin_form vms_admin_model_form" data-user="<?php echo $user->ID ?>" >
              <div class="vms_admin_form_text">Inserisci i dati del modello.</div>
              <div class="vms_admin_form_field">
                Titolo
                <input type="text" name="title" autocomplete="new-password"/>
                <span class="vms_admin_form_error"></span>
              </div>
              <div class="vms_admin_form_field">Categoria <?php echo $categories_html ?>
                <span class="vms_admin_form_error"></span>
              </div>
              <div class="vms_admin_modal_buttons">
                <button type="button" class="button button-primary vms_admin_model_button">Salva</button>
                <button type="button" class="button vms_admin_close_button">Annulla</button>
              </div>
            </div>
          </div>
        </div>
      </div>
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


    function initAdminScripts() {
      add_action( 'admin_enqueue_scripts', array( $this, 'vms_admin_script_and_style' ) );
    }

    function vms_admin_script_and_style() {

      wp_enqueue_style('vms-admin-styles', plugins_url( '../src/style/vms-admin-style.scss', __FILE__ ));
      wp_enqueue_script('vms-admin-script', plugins_url( '../src/script/vms-admin-script.js', __FILE__ ));

      wp_localize_script( 'vms-admin-script', 'ajax_login_object', array(
          'ajaxurl' => admin_url( 'admin-ajax.php' )
      ));
    }


    /* Settings page */

    function initSettingsPage() {
      add_action( 'admin_menu', array($this, 'vms_admin_page') );
      add_action( 'admin_init', array($this, 'vms_options') );
    }

    function vms_admin_page() {
      add_menu_page( 'VMS Settings', 'VMS Settings', 'manage_options', 'vms-settings', array($this, 'vms_admin_render') );
      add_submenu_page( 'vms-settings', 'Report - Modelli per utente', 'Report - Modelli per utente', 'manage_options', 'vms-report-iscritti', array($this, 'vms_report_iscritti_render') );
    }

    function vms_report_iscritti_render() {


      $users = get_users(array(
              'role' => 'iscritto'
      ));

      foreach( $users as $user) {

        $models = VMS_DB::getInstance()->get_models_list_for_modelist($user->ID);

        if(count($models) > 0) {
          ?>
          <table>
            <tr>
              <th>Nome</th>
              <td>
                <?php echo $user->first_name; ?>
              </td>
            </tr>
            <tr>
              <th>Cognome</th>
              <td>
                <?php echo $user->last_name; ?>
              </td>
            </tr>
          </table>
          <table class="vms_admin_table">
            <thead>
              <tr>
                  <th>ID</th>
                  <th>Titolo</th>
                  <th>Categoria</th>
                  <th>Sigla</th>
                  <th>Display</th>
              </tr>
            </thead>
            <tbody>
          <?php
            foreach ($models as $model) {

              $display = isset( $model->display)?sprintf('%03d', $model->display):'';
              ?>
              <tr>
                <td><?php echo sprintf('%05d', $model->id) ?></td>
                <td><?php echo $model->title ?></td>
                <td><?php echo $model->category ?></td>
                <td><?php echo $model->sigla ?></td>
                <td><?php echo $display ?></td>
              </tr>
              <?php
            }
            ?>
            </tbody>
            <tfoot>
            </tfoot>
          </table>
          <?php
        }
      }
    }

    function vms_admin_render() {
      if ( !current_user_can( 'manage_options' ) )  {
       wp_die( __( 'You do not have sufficient permissions to access this page.', 'sffi' ) );
      }
      ?>
        <form method="post" action="options.php">
          <?php
          settings_fields( 'vms_receipt_it_section' );
          settings_fields( 'vms_receipt_en_section' );
          do_settings_sections( 'vms_admin_render' );
          ?>
          <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
      <?php
    }

    function vms_options() {

      add_settings_section( 'vms_receipt_it_section', 'VMS Ricevuta - Italiano', null, 'vms_admin_render' );

      add_settings_field( 'vms_receipt_title_it', 'Titolo ricevuta', array( $this, 'vms_receipt_title_it_callback'), 'vms_admin_render', 'vms_receipt_it_section' );
      add_settings_field( 'vms_receipt_subtitle_it', 'Sottotitolo ricevuta', array( $this, 'vms_receipt_subtitle_it_callback'), 'vms_admin_render', 'vms_receipt_it_section' );
      add_settings_field( 'vms_receipt_top_text_it', 'Testo superiore', array( $this, 'vms_receipt_top_text_it_callback'), 'vms_admin_render', 'vms_receipt_it_section' );
      add_settings_field( 'vms_receipt_bottom_text_it', 'Testo inferiore', array( $this, 'vms_receipt_bottom_text_it_callback'), 'vms_admin_render', 'vms_receipt_it_section' );
      add_settings_field( 'vms_receipt_model_id_it', 'ID tabella modelli', array( $this, 'vms_receipt_model_id_it_callback'), 'vms_admin_render', 'vms_receipt_it_section' );
      add_settings_field( 'vms_receipt_model_title_it', 'Titolo tabella modelli', array( $this, 'vms_receipt_model_title_it_callback'), 'vms_admin_render', 'vms_receipt_it_section' );
      add_settings_field( 'vms_receipt_model_sigla_it', 'Sigla tabella modelli', array( $this, 'vms_receipt_model_sigla_it_callback'), 'vms_admin_render', 'vms_receipt_it_section' );
      add_settings_field( 'vms_receipt_model_category_it', 'Categoria tabella modelli', array( $this, 'vms_receipt_model_category_it_callback'), 'vms_admin_render', 'vms_receipt_it_section' );
      add_settings_field( 'vms_receipt_model_display_it', 'Display tabella modelli', array( $this, 'vms_receipt_model_display_it_callback'), 'vms_admin_render', 'vms_receipt_it_section' );

      register_setting( 'vms_receipt_it_section', 'vms_receipt_title_it' );
      register_setting( 'vms_receipt_it_section', 'vms_receipt_subtitle_it' );
      register_setting( 'vms_receipt_it_section', 'vms_receipt_top_text_it' );
      register_setting( 'vms_receipt_it_section', 'vms_receipt_bottom_text_it' );
      register_setting( 'vms_receipt_it_section', 'vms_receipt_model_id_it' );
      register_setting( 'vms_receipt_it_section', 'vms_receipt_model_title_it' );
      register_setting( 'vms_receipt_it_section', 'vms_receipt_model_sigla_it' );
      register_setting( 'vms_receipt_it_section', 'vms_receipt_model_category_it' );
      register_setting( 'vms_receipt_it_section', 'vms_receipt_model_display_it' );

      add_settings_section( 'vms_receipt_en_section', 'VMS Ricevuta - English', null, 'vms_admin_render' );

      add_settings_field( 'vms_receipt_title_en', 'Titolo ricevuta', array( $this, 'vms_receipt_title_en_callback'), 'vms_admin_render', 'vms_receipt_en_section' );
      add_settings_field( 'vms_receipt_subtitle_en', 'Sottotitolo ricevuta', array( $this, 'vms_receipt_subtitle_en_callback'), 'vms_admin_render', 'vms_receipt_en_section' );
      add_settings_field( 'vms_receipt_top_text_en', 'Testo superiore', array( $this, 'vms_receipt_top_text_en_callback'), 'vms_admin_render', 'vms_receipt_en_section' );
      add_settings_field( 'vms_receipt_bottom_text_en', 'Testo inferiore', array( $this, 'vms_receipt_bottom_text_en_callback'), 'vms_admin_render', 'vms_receipt_en_section' );
      add_settings_field( 'vms_receipt_model_id_en', 'ID tabella modelli', array( $this, 'vms_receipt_model_id_en_callback'), 'vms_admin_render', 'vms_receipt_en_section' );
      add_settings_field( 'vms_receipt_model_title_en', 'Titolo tabella modelli', array( $this, 'vms_receipt_model_title_en_callback'), 'vms_admin_render', 'vms_receipt_en_section' );
      add_settings_field( 'vms_receipt_model_sigla_en', 'Sigla tabella modelli', array( $this, 'vms_receipt_model_sigla_en_callback'), 'vms_admin_render', 'vms_receipt_en_section' );
      add_settings_field( 'vms_receipt_model_category_en', 'Categoria tabella modelli', array( $this, 'vms_receipt_model_category_en_callback'), 'vms_admin_render', 'vms_receipt_en_section' );
      add_settings_field( 'vms_receipt_model_display_en', 'Display tabella modelli', array( $this, 'vms_receipt_model_display_en_callback'), 'vms_admin_render', 'vms_receipt_en_section' );

      register_setting( 'vms_receipt_en_section', 'vms_receipt_title_en' );
      register_setting( 'vms_receipt_en_section', 'vms_receipt_subtitle_en' );
      register_setting( 'vms_receipt_en_section', 'vms_receipt_top_text_en' );
      register_setting( 'vms_receipt_en_section', 'vms_receipt_bottom_text_en' );
      register_setting( 'vms_receipt_en_section', 'vms_receipt_model_id_en' );
      register_setting( 'vms_receipt_en_section', 'vms_receipt_model_title_en' );
      register_setting( 'vms_receipt_en_section', 'vms_receipt_model_sigla_en' );
      register_setting( 'vms_receipt_en_section', 'vms_receipt_model_category_en' );
      register_setting( 'vms_receipt_en_section', 'vms_receipt_model_display_en' );
    }


    function vms_receipt_title_it_callback() {
    ?>
        <input type="text" id="vms_receipt_title_it" name="vms_receipt_title_it" value="<?php echo get_option( 'vms_receipt_title_it' ); ?>">
    <?php
    }
    function vms_receipt_subtitle_it_callback() {
    ?>
        <input type="text" id="vms_receipt_subtitle_it" name="vms_receipt_subtitle_it" value="<?php echo get_option( 'vms_receipt_subtitle_it' ); ?>">
    <?php
    }
    function vms_receipt_top_text_it_callback() {
    ?>
        <textarea type="text" id="vms_receipt_top_text_it" name="vms_receipt_top_text_it"><?php echo get_option( 'vms_receipt_top_text_it' ); ?></textarea>
    <?php
    }
    function vms_receipt_bottom_text_it_callback() {
    ?>
        <textarea type="text" id="vms_receipt_bottom_text_it" name="vms_receipt_bottom_text_it"><?php echo get_option( 'vms_receipt_bottom_text_it' ); ?></textarea>
    <?php
    }
    function vms_receipt_model_id_it_callback() {
    ?>
        <input type="text" id="vms_receipt_model_id_it" name="vms_receipt_model_id_it" value="<?php echo get_option( 'vms_receipt_model_id_it' ); ?>">
    <?php
    }
    function vms_receipt_model_title_it_callback() {
    ?>
        <input type="text" id="vms_receipt_model_title_it" name="vms_receipt_model_title_it" value="<?php echo get_option( 'vms_receipt_model_title_it' ); ?>">
    <?php
    }
    function vms_receipt_model_sigla_it_callback() {
    ?>
        <input type="text" id="vms_receipt_model_sigla_it" name="vms_receipt_model_sigla_it" value="<?php echo get_option( 'vms_receipt_model_sigla_it' ); ?>">
    <?php
    }
    function vms_receipt_model_category_it_callback() {
    ?>
        <input type="text" id="vms_receipt_model_category_it" name="vms_receipt_model_category_it" value="<?php echo get_option( 'vms_receipt_model_category_it' ); ?>">
    <?php
    }
    function vms_receipt_model_display_it_callback() {
    ?>
        <input type="text" id="vms_receipt_model_display_it" name="vms_receipt_model_display_it" value="<?php echo get_option( 'vms_receipt_model_display_it' ); ?>">
    <?php
    }
    function vms_receipt_title_en_callback() {
    ?>
        <input type="text" id="vms_receipt_title_en" name="vms_receipt_title_en" value="<?php echo get_option( 'vms_receipt_title_en' ); ?>">
    <?php
    }
    function vms_receipt_subtitle_en_callback() {
    ?>
        <input type="text" id="vms_receipt_subtitle_en" name="vms_receipt_subtitle_en" value="<?php echo get_option( 'vms_receipt_subtitle_en' ); ?>">
    <?php
    }
    function vms_receipt_top_text_en_callback() {
    ?>
        <textarea type="text" id="vms_receipt_top_text_en" name="vms_receipt_top_text_en"><?php echo get_option( 'vms_receipt_top_text_en' ); ?></textarea>
    <?php
    }
    function vms_receipt_bottom_text_en_callback() {
    ?>
        <textarea type="text" id="vms_receipt_bottom_text_en" name="vms_receipt_bottom_text_en"><?php echo get_option( 'vms_receipt_bottom_text_en' ); ?></textarea>
    <?php
    }
    function vms_receipt_model_id_en_callback() {
    ?>
        <input type="text" id="vms_receipt_model_id_en" name="vms_receipt_model_id_en" value="<?php echo get_option( 'vms_receipt_model_id_en' ); ?>">
    <?php
    }
    function vms_receipt_model_title_en_callback() {
    ?>
        <input type="text" id="vms_receipt_model_title_en" name="vms_receipt_model_title_en" value="<?php echo get_option( 'vms_receipt_model_title_en' ); ?>">
    <?php
    }
    function vms_receipt_model_sigla_en_callback() {
    ?>
        <input type="text" id="vms_receipt_model_sigla_en" name="vms_receipt_model_sigla_en" value="<?php echo get_option( 'vms_receipt_model_sigla_en' ); ?>">
    <?php
    }
    function vms_receipt_model_category_en_callback() {
    ?>
        <input type="text" id="vms_receipt_model_category_en" name="vms_receipt_model_category_en" value="<?php echo get_option( 'vms_receipt_model_category_en' ); ?>">
    <?php
    }
    function vms_receipt_model_display_en_callback() {
    ?>
        <input type="text" id="vms_receipt_model_display_en" name="vms_receipt_model_display_en" value="<?php echo get_option( 'vms_receipt_model_display_en' ); ?>">
    <?php
    }




  }
}

?>
