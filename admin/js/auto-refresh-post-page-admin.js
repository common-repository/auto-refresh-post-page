    jQuery(function()
    {
        jQuery(document).ready(function()
        {
            jQuery('#cb_global_save_post').on('click', function() {


              var data = {};
            
                jQuery('.js-cb-customization').each(function() {
                  if (jQuery(this).is(':checked')) {
                    var key = jQuery(this).attr('name');
                    var value = jQuery(this).val();
                    data[key] = value;
                  } else {
                    var key = jQuery(this).attr('name');
                    var value = "0";
                    data[key] = value;
                  }
                });
                jQuery('.js-time-field').each(function() {
                  var key = jQuery(this).attr('name');
                  var value = jQuery(this).val();
                  data[key] = value;
                });
                console.log(data);
                // var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
                var nonce_entry = jQuery('input[name="nonce_entry"]').val();
                
                jQuery.ajax({
                  type: 'POST',
                  url:   auto_refresh_post_page.ajaxurl,
                  data: {
                    action: 'ARPP_store_refresh_settings',
                    data:    data,
                    ARPP_nonce: nonce_entry
                  },
                  success: function(response) {
                    jQuery('.sucess_msg').html('Settings saved  ').css('padding', '5px');
                    
                    setTimeout(function(){
                    jQuery('.sucess_msg').html('').css('padding', '0px');
                    }, 1000);
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
              });
        });
    });



  
    
