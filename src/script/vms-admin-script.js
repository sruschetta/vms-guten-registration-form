(function($) {

  $(document).ready(function(){

    $(".vms_admin_delete_model_button").click(function() {

      $('html').addClass('vms_lock');

      var modal = $(this).closest(".vms_admin_models").find(".vms_admin_modal");
      modal.find(".vms_admin_form").css("display", "none");

      var modelForm = modal.find(".vms_admin_delete_form");

      modelForm.css("display", "block");
      modal.addClass("visible");

      var button = modal.find('.vms_admin_close_button');
      button.click(function(){
        modal.removeClass('visible');
        $('html').removeClass('vms_lock');
      });

      var model_id = $(this).attr("data-model-id");

      var button = modal.find('.vms_admin_delete_model_button');

      button.click(function() {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_login_object.ajaxurl,
          data: {
            'action': 'vms_admin_model_delete_action',
            'model_id': model_id,
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

    $(".vms_admin_add_model_button").click(function() {

      $('html').addClass('vms_lock');

      var modal = $(this).closest(".vms_admin_models").find(".vms_admin_modal");
      modal.find(".vms_admin_form").css("display", "none");

      var modelForm = modal.find(".vms_admin_model_form");

      modelForm.css("display", "block");

      modal.find("input[type='text']").val('');
      modal.find("select").val(0).prop('selected', true);

      modal.find('.vms_admin_form_error').removeClass('visible');

      modal.addClass("visible");

      var button = modal.find('.vms_admin_close_button');
      button.click(function(){
        modal.removeClass('visible');
        $('html').removeClass('vms_lock');
      });

      var button = modal.find('.vms_admin_model_button');
      button.click(function() {

        var title = modelForm.find("input[name='title']").val();
        var category = modelForm.find("select[name='category']").val();
        var user_id = modelForm.attr("data-user");

        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_login_object.ajaxurl,
          data: {
            'action': 'vms_admin_model_action',
            'title': title,
            'category': category,
            'user_id' : user_id,
          },
          success: function(data){

            if(data.errors) {

              var errors = data.errors;

              if(errors.title_missing_error){
                var err = modelForm.find('input[name="title"]').siblings('.vms_admin_form_error');
                err.text(errors.title_missing_error);
                err.addClass('visible');
              }
              if(errors.category_missing_error){
                var err = modelForm.find('select[name="category"]').siblings('.vms_admin_form_error');
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
    });

    $(".vms_admin_update_model_button").click(function(){
      console.log("update");

      $('html').addClass('vms_lock');

      var model_id = $(this).attr("data-model-id");

      var modal = $(this).closest(".vms_admin_models").find(".vms_admin_modal");
      modal.find(".vms_admin_form").css("display", "none");

      var modelForm = modal.find(".vms_admin_model_form");

      modelForm.css("display", "block");

      modal.find("input[name='title']").val($(this).attr("data-title"));
      modal.find("select[name='category']").val($(this).attr("data-category-id")).prop('selected', true);

      modal.find('.vms_admin_form_error').removeClass('visible');

      modal.addClass("visible");

      var button = modal.find('.vms_admin_close_button');
      button.click(function(){
        modal.removeClass('visible');
        $('html').removeClass('vms_lock');
      });

      var button = modal.find('.vms_admin_model_button');
      button.click(function() {

        var title = modelForm.find("input[name='title']").val();
        var category = modelForm.find("select[name='category']").val();
        var user_id = modelForm.attr("data-user");

        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_login_object.ajaxurl,
          data: {
            'action': 'vms_admin_model_action',
            'title': title,
            'category': category,
            'user_id' : user_id,
            'model_id' : model_id
          },
          success: function(data){

            if(data.errors) {

              var errors = data.errors;

              if(errors.title_missing_error){
                var err = modelForm.find('input[name="title"]').siblings('.vms_admin_form_error');
                err.text(errors.title_missing_error);
                err.addClass('visible');
              }
              if(errors.category_missing_error){
                var err = modelForm.find('select[name="category"]').siblings('.vms_admin_form_error');
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
    });
  });
})( jQuery );
