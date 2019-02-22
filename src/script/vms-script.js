(function($) {

  $(document).ready(function(){

    //Forms

    $('.vms_form').find('input, select').focus(function(){
      $(this).siblings('span').removeClass('visible');
    });

    $('.vms_modal_button').click(function(){

      var target = $(this).parent().parent().attr('vms_target_page');
      if( target ) {
        window.open( target, '_self');
      }
      else {
        $(this).parent().parent().removeClass('visible');
        $('html').removeClass('vms_lock');
      }
    });


    $('.vms_login_form').submit(function(event){
      event.preventDefault();

      var form = $(this);

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_login_object.ajaxurl,
        data: {
          'action': 'vms_login_action',
          'email': form.find('input[name="email"]').val(),
          'password': form.find('input[name="password"]').val(),
          'security': form.find('input[name="vms-login-sec"]').val(),
          'post_id': form.attr('post_id')
        },
        success: function(data){
          console.log(data);

          if(data.errors) {

            var errors = data.errors;

            if(errors.email_missing_error){
              var err = form.find('input[name="email"]').siblings('.vms_form_error');
              err.text(errors.email_missing_error);
              err.addClass('visible');
            }
            if(errors.email_invalid_error){
              var err = form.find('input[name="email"]').siblings('.vms_form_error');
              err.text(errors.email_invalid_error);
              err.addClass('visible');
            }
            if(errors.password_missing_error){
              var err = form.find('input[name="password"]').siblings('.vms_form_error');
              err.text(errors.password_missing_error);
              err.addClass('visible');
            }
          }
          else {
            if(data.target_page) {
              window.open( data.target_page, '_self');
            }
            else {
              var modal = form.find('.vms_modal');
              modal.addClass('visible');

              modal.find('.vms_modal_content p').html(data.message);
              $('html').addClass('vms_lock');
            }
          }
        },
        error: function(error){
          console.log(error);
        }
      });
    });

    $('.vms_registration_form').submit(function(event){
      event.preventDefault();

      var form = $(this);

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_login_object.ajaxurl,
        data: {
          'action': 'vms_registration_action',
          'firstname': form.find('input[name="firstname"]').val(),
          'lastname': form.find('input[name="lastname"]').val(),
          'email': form.find('input[name="email"]').val(),
          'password': form.find('input[name="password"]').val(),
          'password2': form.find('input[name="password2"]').val(),
          'nation': form.find('select[name="nation"]').val(),
          'age': form.find('input[name="age"]').val(),
          'privacy': form.find('input[name="privacy_1"]').is(':checked'),
          'security': form.find('input[name="vms-registration-sec"]').val(),
          'post_id': form.attr('post_id'),
        },
        success: function(data){

          if(data.errors) {

            var errors = data.errors;

            if(errors.first_name_missing_error){
              var err = form.find('input[name="firstname"]').siblings('.vms_form_error');
              err.text(errors.first_name_missing_error);
              err.addClass('visible');
            }
            if(errors.last_name_missing_error){
              var err = form.find('input[name="lastname"]').siblings('.vms_form_error');
              err.text(errors.last_name_missing_error);
              err.addClass('visible');
            }
            if(errors.email_missing_error){
              var err = form.find('input[name="email"]').siblings('.vms_form_error');
              err.text(errors.email_missing_error);
              err.addClass('visible');
            }
            if(errors.email_invalid_error){
              var err = form.find('input[name="email"]').siblings('.vms_form_error');
              err.text(errors.email_invalid_error);
              err.addClass('visible');
            }
            if(errors.password_missing_error){
              var err = form.find('input[name="password"]').siblings('.vms_form_error');
              err.text(errors.password_missing_error);
              err.addClass('visible');
            }
            if(errors.password_format_error){
              var err = form.find('input[name="password"]').siblings('.vms_form_error');
              err.text(errors.password_format_error);
              err.addClass('visible');
            }
            if(errors.password_match_error){
              var err = form.find('input[name="password2"]').siblings('.vms_form_error');
              err.text(errors.password_match_error);
              err.addClass('visible');
            }
            if(errors.nation_missing_error){
              var err = form.find('select[name="nation"]').siblings('.vms_form_error');
              err.text(errors.nation_missing_error);
              err.addClass('visible');
            }
            if(errors.age_missing_error){
              var err = form.find('input[name="age"]').siblings('.vms_form_error');
              err.text(errors.age_missing_error);
              err.addClass('visible');
            }
            if(errors.privacy_error){
              var err = form.find('input[name="privacy_1"]').siblings('.vms_form_error');
              err.text(errors.privacy_error);
              err.addClass('visible');
            }
          }
          else {
            var modal = form.find('.vms_modal');
            modal.addClass('visible');
            if(data.target_page) {
              modal.attr('vms_target_page', data.target_page);
            }else {
              modal.removeAttr('vms_target_page');
            }
            modal.find('.vms_modal_content p').html(data.message);
            $('html').addClass('vms_lock');
          }
        },
        error: function(error){
          console.log(error);
        }
      });
    });

    //User dashboard

    $('.vms_open_user_update').click(function(){
      $(this).parent().parent().find(".vms_modal").addClass("visible");
      $('html').addClass('vms_lock');
    });

    $('.vms_user_dashboard .vms_open_change_password').click(function(){
      $(this).parent().parent().find(".vms_modal").addClass("visible");
      $('html').addClass('vms_lock');
    });

  });

})( jQuery );
