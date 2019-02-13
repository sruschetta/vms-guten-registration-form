(function($) {

  console.log(ajax_login_object);

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
        console.log("error")
      }
    });
  });

})( jQuery );
