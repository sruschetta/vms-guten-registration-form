(function($) {

  $(document).ready(function(){

    $('.vms_form').find('input').focus(function(){
      $(this).next('span').removeClass('visible');
    });



    $('.vms_login_form').submit(function(event){
      event.preventDefault();
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajax_login_object.ajaxurl,
        success: function(data){
                 console.log(data);
        },
        data: {
          'action': 'vms_login_action',
          'security': $(this).find('input[name="vms-login-sec"]').val(),
          'post_id': $(this).attr('post_id')
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
          'nation': form.find('input[name="nation"]').val(),
          'age': form.find('input[name="age"]').val(),
          'security': form.find('input[name="vms-registration-sec"]').val(),
          'post_id': form.attr('post_id'),
        },
        success: function(data){
          if(data.first_name_missing_error){
            var err = form.find('input[name="firstname"]').siblings('.vms_form_error');
            err.text(data.first_name_missing_error);
            err.addClass('visible');
          }
          if(data.last_name_missing_error){
            var err = form.find('input[name="lastname"]').siblings('.vms_form_error');
            err.text(data.last_name_missing_error);
            err.addClass('visible');
          }
          if(data.email_missing_error){
            var err = form.find('input[name="email"]').siblings('.vms_form_error');
            err.text(data.email_missing_error);
            err.addClass('visible');
          }
          if(data.email_invalid_error){
            var err = form.find('input[name="email"]').siblings('.vms_form_error');
            err.text(data.email_invalid_error);
            err.addClass('visible');
          }
          if(data.password_missing_error){
            var err = form.find('input[name="password"]').siblings('.vms_form_error');
            err.text(data.password_missing_error);
            err.addClass('visible');
          }
          if(data.password_format_error){
            var err = form.find('input[name="password"]').siblings('.vms_form_error');
            err.text(data.password_format_error);
            err.addClass('visible');
          }
          if(data.password_match_error){
            var err = form.find('input[name="password2"]').siblings('.vms_form_error');
            err.text(data.password_match_error);
            err.addClass('visible');
          }
          if(data.nation_missing_error){
            var err = form.find('input[name="nation"]').siblings('.vms_form_error');
            err.text(data.nation_missing_error);
            err.addClass('visible');
          }
          if(data.age_missing_error){
            var err = form.find('input[name="age"]').siblings('.vms_form_error');
            err.text(data.age_missing_error);
            err.addClass('visible');
          }
          if(data.privacy_missing_error){
            var err = form.find('input[name="privacy_1"]').siblings('.vms_form_error');
            err.text(data.privacy_missing_error);
            err.addClass('visible');
          }
        },
        error: function(error){
          console.log(error);
        }
      });
    });



  });

})( jQuery );
