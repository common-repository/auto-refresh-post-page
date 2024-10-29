<?php

 /**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://cubixsol.org/
 * @since      1.0.0
 *
 * @package    Auto_refresh_post_page
 * @subpackage auto_refresh_post_page/admin/partials
 *                                                                
 * 
 *  ________      ___  ___      ________      ___      ___    ___  ________       ________      ___          
 * |\   ____\    |\  \|\  \    |\   __  \    |\  \    |\  \  /  /||\   ____\     |\   __  \    |\  \         
 * \ \  \___|    \ \  \\\  \   \ \  \|\ /_   \ \  \   \ \  \/  / /\ \  \___|_    \ \  \|\  \   \ \  \        
 *  \ \  \        \ \  \\\  \   \ \   __  \   \ \  \   \ \    / /  \ \_____  \    \ \  \\\  \   \ \  \       
 *   \ \  \____    \ \  \\\  \   \ \  \|\  \   \ \  \   /     \/    \|____|\  \    \ \  \\\  \   \ \  \____  
 *	  \ \_______\   \ \_______\   \ \_______\   \ \__\ /  /\   \      ____\_\  \    \ \_______\   \ \_______\
 *	   \|_______|    \|_______|    \|_______|    \|__|/__/ /\ __\    |\_________\    \|_______|    \|_______|
 *	   								   			      |__|/ \|__|    \|_________|       
                      																										   
 */
if (!defined('ABSPATH')) {
	exit;
}
 
// Generate a nonce
$nonce = wp_create_nonce('ARPP_store_refresh_settings_nonce');
 ?>


 <h1>Set Refresh Frequency</h1>
 <hr class="cb-divider" />
    <tr>
	    <th style="text-align: left;">
	    <input type="checkbox" class="js-select-all">&nbsp;Select All &nbsp;<input type="number" placeholder="Enter Time in Seconds globallly" class="timeField" id="timeField" min=0 >
	    </th>
	</tr>
		
 <table class="cb-tab-content__table cb-tab-content__table--padding wp-list-table widefatsett fixedsett striped table-view-list pages"><br>&nbsp;
		
    <tr>
	    <td class="check_title setting_head">Enable/Disable</td>
	    <td class="setting_head">Title</td>
	    <td class="setting_head">Seconds</td>
    </tr>

	<?php
	    $args = array(
		    'public' => true
	    );
	  
		$output = 'names'; // names or objects, note names is the default   $number = !empty($value) ? $value : ''; 
		$operator = 'or'; // 'and' or 'or'
		$post_types = get_post_types( $args, $output, $operator );
		  
		foreach ( $post_types as $post_type ) { ?>
			<tr>
				<?php 
				    $array_from_db = get_option( 'ARPP_my_option_name' );

				    if(isset($array_from_db[$post_type]) && $array_from_db[$post_type] == 1 ) {
					    $checkbox="checked";
				    }else{
				        $checkbox = "";
				    }

			        if(isset($array_from_db["duration-".$post_type]) && $array_from_db["duration-".$post_type] != '' ) {
					    $repeat_time=$array_from_db["duration-".$post_type];
				    }else{		
					    $repeat_time = "";
				    }	
				?>
		 
	            <td class="check_title">
				    <input type="checkbox" name="checkbox-<?php echo esc_html($post_type); ?>" value="1"  class="js-cb-customization js-select-single" id="cb-feedback-<?php echo esc_html($post_type); ?>" data-key="feedbackTitle" <?php echo esc_html($checkbox); ?>>
			    </td>
				<td>   
				    <?php echo esc_html($post_type); ?>&nbsp;
			    </td>
				<td>
				    <input type="number" name="duration-<?php echo esc_html($post_type); ?>" value="<?php echo esc_html($repeat_time); ?>" placeholder="Enter Time in Seconds" id="time_set_field"  class="js-time-field" min=0 oninput="checkValue(this)">
	            </td> 
		    </tr>
    <?php } ?> 
 </table>
	 
	  <!-- end of no multilingual div -->
 <br>
 <br>
 <hr class="cb-divider" />
 <input type="hidden" name="nonce_entry" class="nonce_entry" value="<?php echo esc_html($nonce); ?>">
 <!-- <div class="cb-tab-content__sticky-save js-cb-customization-sticky"> -->
 <button type="submit" id="cb_global_save_post" class="">
	<?php echo ( esc_html__( 'Save Post', 'auto-refresh-post-page' ) ); ?>
 </button>

	  <!-- </div> -->
 <div class="sucess_msg" ></div>
 

 <script>



 function checkValue(input) { 
    if (input.value < 0) {
        alert("Please enter a positive number.");
        input.value = 'Enter Time in Seconds';
    }

    if (input.value % 1 !== 0) {
        input.value = Math.floor(input.value);
        alert("Please enter a value without point");
    }
   
    var timeFields = document.querySelectorAll('.js-time-field');

    // Loop through each input field
    timeFields.forEach(function(timeField) {
        timeField.addEventListener('input', function() {
            var checkbox = timeField.previousElement.previousElement;
            checkbox.checked = true; 
        });
    });
 }
	

    // Get the "Select All" checkbox
 var selectAllCheckbox = document.querySelector('.js-select-all');
 selectAllCheckbox.addEventListener('click', 
 function() {
    var checkboxes = document.querySelectorAll('.js-select-single');
    for (var i = 0; i < checkboxes.length; i++) {
        // Set the checked property of the checkbox to the same value as the "Select All" checkbox
        checkboxes[i].checked = selectAllCheckbox.checked;
    }
 });

 document.querySelector(".js-select-all").addEventListener("click", function() {
    if (this.checked) {
        document.querySelector(".timeField").addEventListener("input", function() {
            document.querySelectorAll(".js-time-field").forEach(element => element.value = this.value);
        });
    } else {
         document.querySelector(".timeField").removeEventListener("input", function() {
            document.querySelectorAll(".js-time-field").forEach(element => element.value = this.value);
        });
    }
 });
</script>


