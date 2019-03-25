(function($) {

  $(document).ready(function(){

    $(".vms_admin_delete_model_button").click(function(){

      $('html').addClass('vms_lock');

      var modal = $(this).closest(".vms_admin_models").find(".vms_admin_modal");
      modal.find(".vms_admin_form").css("display", "none");

      var modelForm = modal.find(".vms_model_delete_form");

      modelForm.css("display", "block");
      modelForm.attr("data-model-id", $(this).attr("data-model-id"));

      modal.addClass("visible");

      var button = modal.find('.vms_admin_close_button');
      button.click(function(){
        modal.removeClass('visible');
        $('html').removeClass('vms_lock');
      });

      var button = modal.find('.vms_admin_delete_model_button');
      button.click(function(){

        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_login_object.ajaxurl,
          data: {
            'action': 'vms_model_delete_action',
            'model_id': form.attr("data-model-id"),
            'security': form.find('input[name="vms-model-delete-sec"]').val(),
            'post_id': form.attr('post_id')
          },
          success: function(data){

            if(data.success){
              location.reload(true);
            }
          },
          error: function(error){
            console.log(error);
          }
        });

      });
    });

    $(".vms_admin_delete_form").submit(function(event){
      event.preventDefault();
      console.log("asdasdasd");
    });





    $(".vms_admin_add_model_button").click(function(){
      console.log("add");
    });

    $(".vms_admin_update_model_button").click(function(){
      console.log("update");
    });

  });
})( jQuery );
