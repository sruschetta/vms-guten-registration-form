<?php
if ( !class_exists('VMS_Actions') ) {

  class VMS_Actions {

    private static $instance = null;

    private function __construct() {
    }

    public static function getInstance() {
      if (self::$instance == null)
      {
        self::$instance = new VMS_Actions();
      }

      return self::$instance;
    }

    function registerActions(){
      add_action( 'wp_ajax_vms_login_action', array( $this, 'vms_login_action' ) );
      add_action( 'wp_ajax_nopriv_vms_login_action', array( $this, 'vms_login_action' ) );

      add_action( 'wp_ajax_vms_registration_action', array( $this, 'vms_registration_action' ) );
      add_action( 'wp_ajax_nopriv_vms_registration_action', array( $this, 'vms_registration_action' ) );

      add_action( 'wp_ajax_vms_update_user_action', array( $this, 'vms_update_user_action' ) );
      add_action( 'wp_ajax_vms_update_password_action', array( $this, 'vms_update_password_action' ) );
      add_action( 'wp_ajax_vms_model_action', array( $this, 'vms_model_action' ) );
      add_action( 'wp_ajax_vms_model_delete_action', array( $this, 'vms_model_delete_action' ) );

      add_action( 'wp_ajax_vms_logout_action', array( $this, 'vms_logout_action' ) );

      add_action ( 'wp_ajax_vms_admin_model_delete_action', array( $this, 'vms_admin_model_delete_action') );
      add_action ( 'wp_ajax_vms_admin_model_action', array( $this, 'vms_admin_model_action') );

      add_action ( 'admin_post_vms_receipt_download_action', array( $this, 'vms_receipt_download_action') );

      add_action ( 'admin_post_vms_models_report_action', array( $this, 'vms_models_report_action') );
      add_action ( 'admin_post_vms_category_report_action', array( $this, 'vms_category_report_action') );
      add_action ( 'admin_post_vms_display_download_action', array( $this, 'vms_display_download_action') );
    }


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

                $headers = array('Content-Type: text/html; charset=UTF-8');
                wp_mail( $email, $meta['registration_email_subject'][0], $meta['registration_email_text'][0], $headers);

                $credentials  = array(
                  'user_login'    => $email,
                  'user_password' => $password,
                  'remember'      => false
                );

                $login =  wp_signon( $credentials, true );
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
              update_user_meta( $user_id, 'last_update', date('Y-m-d h:i:sa') );

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

            if( $password === trim($_POST['old_password']) ) {
              $errors['password_different_error'] = $meta['password_different_error'];
              $hasError = true;
            }
            else if( ( trim($_POST['new_password2']) === '' ) || ( $_POST['new_password2'] !== $password ) )  {
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


    //Add/Edit model

    function vms_model_action() {

      check_ajax_referer( 'vms-model', 'security' );

      $post_id = $_POST['post_id'];

      if(isset($post_id)){

        $meta = get_post_meta($post_id);

        //Title
        if( trim($_POST['title']) === '' ) {
          $errors['title_missing_error'] = $meta['title_missing_error'];
          $hasError = true;
        }

        //Category
        if( trim($_POST['category']) === '' ) {
          $errors['category_missing_error'] = $meta['category_missing_error'];
          $hasError = true;
        }

        if( !$hasError ) {

          $current_user = wp_get_current_user();

          if($_POST['model_id']){
            //Model update
            $model = VMS_DB::getInstance()->update_model( $_POST['model_id'], $_POST['title'], $_POST['category'], $current_user->ID );
          }
          else {
            //New Model
            $model = VMS_DB::getInstance()->create_new_model($_POST['title'], $_POST['category'], $current_user->ID );
          }

          update_user_meta( $current_user->ID, 'last_update', date('Y-m-d h:i:sa') );

          $res = array(
            'success' => true,
            'res' => $model
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

      die();
    }

    //Delete model

    function vms_model_delete_action() {

      check_ajax_referer( 'vms-model-delete', 'security' );

      $post_id = $_POST['post_id'];

      if(isset($post_id)){

        if( trim($_POST['model_id']) === '' ) {
          $hasError = true;
        }

        if( !$hasError ) {

          $model = VMS_DB::getInstance()->delete_model( $_POST['model_id'] );

          $current_user = wp_get_current_user();
          update_user_meta( $current_user->ID, 'last_update', date('Y-m-d h:i:sa') );

          $res = array(
            'success' => true,
            'res' => $model
          );

          echo json_encode($res);
        }
        else {
          $res = array(
            'success' => false,
          );

          echo json_encode($res);
        }
      }

      die();
    }

    //Logout

    function vms_logout_action() {

      $current_user = wp_get_current_user();

      if($current_user) {
        wp_logout();

        $res = array(
          'success' => true,
        );

        echo json_encode($res);
      }
      die();
    }


    //Admin - Delete model

    function vms_admin_model_delete_action() {

      if( trim($_POST['model_id']) === '' ) {
        $hasError = true;
      }

      if( !$hasError ) {

        $model = VMS_DB::getInstance()->delete_model( $_POST['model_id'] );

        $res = array(
          'success' => true,
          'res' => $model
        );

        echo json_encode($res);
      }
      else {
        $res = array(
          'success' => false,
        );

        echo json_encode($res);
      }
      die();

    }


    //Admin - Add/Edit model

    function vms_admin_model_action() {

        //Title
        if( trim($_POST['title']) === '' ) {
          $errors['title_missing_error'] = "Il campo Titolo è obbligatorio.";
          $hasError = true;
        }

        //Category
        if( trim($_POST['category']) === '' ) {
          $errors['category_missing_error'] = "Il campo Categoria è obbligatorio.";
          $hasError = true;
        }

        if( !$hasError ) {

          $current_user = wp_get_current_user();

          if($_POST['model_id']){
            //Model update
            $model = VMS_DB::getInstance()->update_model( $_POST['model_id'], $_POST['title'], $_POST['category'], $_POST['user_id'] );
          }
          else {
            //New Model
            $model = VMS_DB::getInstance()->create_new_model($_POST['title'], $_POST['category'], $_POST['user_id'] );
          }

          $res = array(
            'success' => true,
            'res' => $model
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

      die();
    }

    //Receipt action

    function vms_receipt_download_action() {

      $current_user = wp_get_current_user();
      update_user_meta( $current_user->ID, 'last_receipt_download', date('Y-m-d h:i:sa') );

      require_once (plugin_dir_path(__FILE__). '../php/classes/pdf.php');
      generatePDF($current_user, $_POST['locale'], VMS_DB::getInstance()->get_models_list_for_modelist($current_user->ID));

      die();
    }


    //Models report

    function vms_models_report_action() {

      $data = "Email;Nome;Cognome;Nome Modello;Categoria Modello;ID Modello\n";

      $users = get_users(array(
                'role' => 'iscritto',
                ));

      $vms_db = VMS_DB::getInstance();

      foreach ( $users as $user ) {
        $user_data = get_user_meta($user->ID);
        $models = $vms_db->get_models_list_for_modelist($user->ID);

        foreach( $models as $model ) {
          $data .= $user->user_email . ";" . $user_data['first_name'][0] . ";" . $user_data['last_name'][0] . ";"
                 . $model->title . ";" . $model->category . ";" . sprintf('%04d', $model->id) . "\n";
        }
      }

      header('Content-Type: application/csv');
      header('Content-Disposition: attachment; filename="ModelsReport_' . date("d_m_Y_H_i") . '.csv"');
      echo $data;

      die();
    }


    //Category report

    function vms_category_report_action() {

      $cat = $_POST["category"];

      $vms_db = VMS_DB::getInstance();

      $data = "Email;Nome;Cognome;Nome Modello;Categoria Modello;ID Modello\n";

      if($cat == "all") {
        $all_cat = $vms_db->get_categories_list();
        foreach ($all_cat as $cat) {

          $models = $vms_db->get_models_list_for_category($cat->id);
          foreach ($models as $model) {

            $user = get_userdata($model->modelistId);
            $user_data = get_user_meta($user->ID);
            $data .= $user->user_email . ";" . $user_data['first_name'][0] . ";" . $user_data['last_name'][0] . ";"
                   . $model->title . ";" . $model->category . ";" . sprintf('%04d', $model->id) . "\n";
          }
        }
      }
      else {
        $models = $vms_db->get_models_list_for_category($cat);
        foreach ($models as $model) {

          $user = get_userdata($model->modelistId);
          $user_data = get_user_meta($user->ID);
          $data .= $user->user_email . ";" . $user_data['first_name'][0] . ";" . $user_data['last_name'][0] . ";"
                 . $model->title . ";" . $model->category . ";" . sprintf('%04d', $model->id) . "\n";
        }
      }
      header('Content-Type: application/csv');
      header('Content-Disposition: attachment; filename="CategoryReport_' . date("d_m_Y_H_i") . '.csv"');
      echo $data;

      die();
    }

    //Display pdf

    function vms_display_download_action() {

      $vms_db = VMS_DB::getInstance();
      $displays = $vms_db->get_displays_list();

      $res = array();

      foreach ($displays as $display) {

        $user = get_user_meta($display->modelistId);
        $models = $vms_db->get_models_for_display($display->id);
        if(count($models) > 0){
          $current = array(
            "name" => $user['first_name'][0] . " " . $user['last_name'][0],
            "id" => $display->id,
            "models" => $models
          );

          array_push($res, $current);
        }
      }

      require_once (plugin_dir_path(__FILE__). '../php/classes/pdf.php');
      generateDisplays($res);
    }
  }
}
?>
