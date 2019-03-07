(function($) {

  $(document).ready(function(){

    //Forms

    $('.vms_form').find('input, select').focus(function(){
      $(this).siblings('.vms_form_error').removeClass('visible');
      $(this).parent().parent().siblings('.vms_form_error').removeClass('visible');
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
              modal.find('.vms_modal_content p').html(data.message);

              $('html').addClass('vms_lock');
              modal.addClass('visible');

              var button = modal.find('.vms_modal_button');

              button.click( function(){
                  modal.find('.vms_form_error').removeClass('visible');
                  modal.removeClass('visible');
                  $('html').removeClass('vms_lock');
              });
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
          'email2': form.find('input[name="email2"]').val(),
          'password': form.find('input[name="password"]').val(),
          'password2': form.find('input[name="password2"]').val(),
          'nation': form.find('select[name="nation"]').val(),
          'day': form.find('select[name="day"]').val(),
          'month': form.find('select[name="month"]').val(),
          'year': form.find('select[name="year"]').val(),
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
            if(errors.email_match_error){
              var err = form.find('input[name="email2"]').siblings('.vms_form_error');
              err.text(errors.email_match_error);
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
            if(errors.birthdate_missing_error){
              var err = form.find('select[name="year"]').parent().parent().siblings('.vms_form_error');
              err.text(errors.birthdate_missing_error);
              err.addClass('visible');
            }
            if(errors.invalid_date_error){
              var err = form.find('select[name="year"]').parent().parent().siblings('.vms_form_error');
              err.text(errors.invalid_date_error);
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
            modal.find('.vms_modal_content p').html(data.message);

            $('html').addClass('vms_lock');
            modal.addClass('visible');

            var button = modal.find('.vms_modal_button');

            if(data.target_page) {
              button.attr('vms_target_page', data.target_page);
            } else {
              button.removeAttr('vms_target_page');
            }

            button.click(function(){
              var target = $(this).attr('vms_target_page');
              if( target ) {
                window.open( target, '_self');
              }
              else {
                modal.find('.vms_form_error').removeClass('visible');
                modal.removeClass('visible');
                $('html').removeClass('vms_lock');
              }
            });
          }
        },
        error: function(error){
          console.log(error);
        }
      });
    });

    $('.vms_update_user_form').submit(function(event){
      event.preventDefault();

      var form = $(this);

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_login_object.ajaxurl,
        data: {
          'action': 'vms_update_user_action',
          'firstname': form.find('input[name="firstname"]').val(),
          'lastname': form.find('input[name="lastname"]').val(),
          'nation': form.find('select[name="nation"]').val(),
          'day': form.find('select[name="day"]').val(),
          'month': form.find('select[name="month"]').val(),
          'year': form.find('select[name="year"]').val(),
          'security': form.find('input[name="vms-update-user-sec"]').val(),
          'post_id': form.attr('post_id')
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
            if(errors.nation_missing_error){
              var err = form.find('select[name="nation"]').siblings('.vms_form_error');
              err.text(errors.nation_missing_error);
              err.addClass('visible');
            }
            if(errors.birthdate_missing_error){
              var err = form.find('select[name="year"]').parent().parent().siblings('.vms_form_error');
              err.text(errors.birthdate_missing_error);
              err.addClass('visible');
            }
            if(errors.invalid_date_error){
              var err = form.find('select[name="year"]').parent().parent().siblings('.vms_form_error');
              err.text(errors.invalid_date_error);
              err.addClass('visible');
            }
          }
          else {
            location.reload(true);
          }
        },
        error: function(error){
          console.log(error);
        }
      });
    });


    //Update password form
    $('.vms_update_password_form').submit(function(event){

      event.preventDefault();

      var form = $(this);

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_login_object.ajaxurl,
        data: {
          'action': 'vms_update_password_action',
          'old_password': form.find('input[name="old_password"]').val(),
          'new_password': form.find('input[name="new_password"]').val(),
          'new_password2': form.find('input[name="new_password2"]').val(),
          'security': form.find('input[name="vms-update-password-sec"]').val(),
          'post_id': form.attr('post_id')
        },
        success: function(data){

          if(data.errors) {

            var errors = data.errors;

            if(errors.old_password_missing_error){
              var err = form.find('input[name="old_password"]').siblings('.vms_form_error');
              err.text(errors.old_password_missing_error);
              err.addClass('visible');
            }
            if(errors.old_password_invalid_error){
              var err = form.find('input[name="old_password"]').siblings('.vms_form_error');
              err.text(errors.old_password_invalid_error);
              err.addClass('visible');
            }
            if(errors.new_password_missing_error){
              var err = form.find('input[name="new_password"]').siblings('.vms_form_error');
              err.text(errors.new_password_missing_error);
              err.addClass('visible');
            }
            if(errors.new_password_format_error){
              var err = form.find('input[name="new_password"]').siblings('.vms_form_error');
              err.text(errors.new_password_format_error);
              err.addClass('visible');
            }
            if(errors.new_password_match_error){
              var err = form.find('input[name="new_password2"]').siblings('.vms_form_error');
              err.text(errors.new_password_match_error);
              err.addClass('visible');
            }
          }
          else {
            location.reload(true);
          }
        },
        error: function(error){
          console.log(error);
        }
      });
    });


    //Add model form
    $('.vms_model_form').submit(function(event){

      event.preventDefault();

      var form = $(this);

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_login_object.ajaxurl,
        data: {
          'action': 'vms_model_action',
          'id': form.attr("data-model-id"),
          'title': form.find('input[name="title"]').val(),
          'category': form.find('select[name="category"]').val(),
          'security': form.find('input[name="vms-model-sec"]').val(),
          'post_id': form.attr('post_id')
        },
        success: function(data){

          if(data.errors) {

            var errors = data.errors;

            if(errors.title_missing_error){
              var err = form.find('input[name="title"]').siblings('.vms_form_error');
              err.text(errors.title_missing_error);
              err.addClass('visible');
            }
            if(errors.category_missing_error){
              var err = form.find('select[name="category"]').siblings('.vms_form_error');
              err.text(errors.category_missing_error);
              err.addClass('visible');
            }
          }
          else {
            location.reload(true);
          }
        },
        error: function(error){
          console.log(error);
        }
      });
    });




    //User dashboard

    $('.vms_user_dashboard .vms_open_user_update').click(function(){

      $('html').addClass('vms_lock');
      var modal = $(this).parent().parent().find(".vms_modal");
      modal.find(".vms_form").css("display", "none");
      modal.find(".vms_update_user_form").css("display", "block");

      //reset values

      modal.find('.vms_form_error').removeClass('visible');

      modal.find("input[type='text']").each(function(){
        var data = $(this).attr("data-value");
        if(data){
          $(this).val(data);
        }
      });

      modal.find("select").each(function(){
        var data = $(this).attr("data-value");
        if(data){
          $(this).val(data).prop('selected', true);
        }
      });

      modal.addClass("visible");

      var button = modal.find('.vms_modal_button');
      button.click(function(){
        modal.removeClass('visible');
        $('html').removeClass('vms_lock');
      });

    });


    $('.vms_user_dashboard .vms_open_change_password').click(function(){

      $('html').addClass('vms_lock');
      var modal = $(this).parent().parent().find(".vms_modal");
      modal.find(".vms_form").css("display", "none");
      modal.find(".vms_update_password_form").css("display", "block");
      modal.find("input[type='password']").val("");

      modal.addClass("visible");

      modal.find('.vms_form_error').removeClass('visible');

      var button = modal.find('.vms_modal_button');
      button.click(function(){
        modal.removeClass('visible');
        $('html').removeClass('vms_lock');
      });
    });


    //Models dashboard

    $('.vms_models_dashboard .vms_add_model_button').click(function(){

      $('html').addClass('vms_lock');
      var modal = $(this).parent().parent().find(".vms_modal");
      modal.find(".vms_form").css("display", "none");
      modal.find(".vms_model_form").css("display", "block");
      
      modal.find('.vms_form_error').removeClass('visible');

      modal.addClass("visible");

      var button = modal.find('.vms_modal_button');
      button.click(function(){
        modal.removeClass('visible');
        $('html').removeClass('vms_lock');
      });
    });

  });

})( jQuery );
