/* Custom Javascript for Web Publishing NYU */

/* JS for all button actions */

/* Message text to be displayed on different actions */
var ssw_email_invalid_msg = "Please enter valid email address.";
var ssw_email_unavailable_msg = "There is no user with given email address.";
var ssw_email_other_error_msg = "There was an issue checking availability of email address, please try again.";
var ssw_site_address_invalid_msg = "Site address can not be left blank and can only contain letters, numbers and _(underscore).";
var ssw_site_address_unavailable_msg = "This site address is already taken. Please enter another one.";
var ssw_site_address_banned_msg = "This site address is not allowed. Please enter another one.";
var ssw_site_address_other_error_msg = "There was an issue checking availability of this site address, please try again.";
var ssw_site_title_invalid_msg = "Site title can not be left blank."; 
var ssw_site_privacy_error_msg = "Please select a site privacy option.";
var ssw_theme_error_msg = "Please select a theme.";
var ssw_terms_error_msg = "Please accept the Terms of Use to proceed.";
var ssw_site_processing_step2_msg = "<h6>Please wait while your site address is being reserved. It may take few minutes.</h6>";
var ssw_site_processing_step4_msg = "<h6>Please wait while your site is being prepared. It may take few minutes to do so based on the number of features you selected to activate for your site.</h6>";

/* Function for 'Cancel' button action */
function ssw_js_submit_form_cancel() {

    ssw_js_display_processing(true);

    jQuery.ajax({
        type: "POST", 
        url: ssw_custom_ajax.ajaxurl,
        dataType: "html",
        data: { 
            action: 'ssw_submit_form_cancel', 
            ssw_cancel: 'true', 
            ssw_ajax_nonce: ssw_custom_ajax.ssw_ajax_nonce  
        },
        success: function(html){ 
            document.getElementById('ssw-container-for-ajax').innerHTML = html;
        } 
    });
}
/* ENDS Function for 'Cancel' button action */

/* Function for 'Previous' button action */
function ssw_js_submit_form_previous() {

    ssw_js_display_processing(true);
    ssw_next_stage = document.getElementById('ssw-steps').ssw_previous_stage.value;
    
    jQuery.ajax({
        type: "POST", 
        url: ssw_custom_ajax.ajaxurl,
        dataType: "html",
        data: { 
            action: 'ssw_submit_form_previous', 
            ssw_next_stage: ssw_next_stage, 
            ssw_ajax_nonce: ssw_custom_ajax.ssw_ajax_nonce  
        },
        success: function(html){ 
            document.getElementById('ssw-container-for-ajax').innerHTML = html;
        } 
    });

}
/* ENDS Function for 'Previous' button action */

/* Function for 'Next' button action */
function ssw_js_submit_form_next() {

    var current_stage = document.forms['ssw-steps'].ssw_current_stage.value;
    
    if(current_stage == 'ssw_step2' || current_stage == 'ssw_step4') {
        /* Hiding processing symbol from being displayed to assist with Hotfix for Step2 freeze issue */
        //ssw_js_display_processing(true);
        ssw_js_display_processing_msg(true);
    }

    if(!ssw_js_validate_form(current_stage)) {
        if(current_stage == 'ssw_step2' || current_stage == 'ssw_step4') {
            ssw_js_display_processing(false);
            ssw_js_display_processing_msg(false);
        }
        return false;
    }

    var theForm = document.forms['ssw-steps'];
    ssw_js_add_hidden_input(theForm, 'ssw_ajax_nonce', ssw_custom_ajax.ssw_ajax_nonce);
    ssw_js_add_hidden_input(theForm, 'action', 'ssw_submit_form_next');
    var form = jQuery('#ssw-steps');
    var formData = form.serialize();

    jQuery.ajax({
        type: "POST", 
        url: ssw_custom_ajax.ajaxurl,
        dataType: "html",
        data: formData,
        success: function(html){ 
            document.getElementById('ssw-container-for-ajax').innerHTML = html;
        } 
    });
}
/* ENDS Function for 'Next' button action */

/* Function for 'Skip' button action */
function ssw_js_submit_form_skip() {

    ssw_js_display_processing(true);
    ssw_next_stage = document.getElementById('ssw-steps').ssw_next_stage.value;

    jQuery.ajax({
        type: "POST", 
        url: ssw_custom_ajax.ajaxurl,
        dataType: "html",
        data: { 
            action: 'ssw_submit_form_skip',
            ssw_next_stage: ssw_next_stage,         
            ssw_ajax_nonce: ssw_custom_ajax.ssw_ajax_nonce  
        },
        success: function(html){ 
            document.getElementById('ssw-container-for-ajax').innerHTML = html;
        } 
    });
}
/* ENDS Function for 'Skip' button action */

/* ENDS JS for all button actions */

/* JS for Validating Forms based on current step */
function ssw_js_validate_form(step) {

    if (step == 'ssw_step1') {
        /* Will be used for 2 iteration of plugin for validation from step1 */
        return true;
    }
    else if(step == 'ssw_step2') {
        if (ssw_js_validate_email() & ssw_js_validate_site_address() & ssw_js_validate_title() & ssw_js_validate_terms()) {
            var is_privacy_selection = document.getElementById('ssw-steps').is_privacy_selection.value;
            if(is_privacy_selection == 1) {
                if(ssw_js_validate_privacy()) {
                    if(ssw_js_check_admin_email_exists()) {
                        if(ssw_js_check_domain_available()) {
                            return true;
                        }                
                    }
                }
            }
            else { 
                if(ssw_js_check_admin_email_exists()) {
                    if(ssw_js_check_domain_available()) {
                        return true;
                    }                
                }
            }
        }
    }
    else if(step == 'ssw_step3') {
        if (ssw_validate_theme()) {
            return true;
        }
    }
    else if(step =='ssw_step4') {
        return true;
    }
    else {
        return true;
    }

    /* Return false if none of the above returned true */
    return false;
}

/* Function to validate admin_email */
function ssw_js_validate_email() {

    var email_regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    var email = document.getElementById('ssw-steps').admin_email.value;
    
    if (!email_regex.test(email)) {
        document.getElementById("ssw-validate-email-error-label").innerHTML=ssw_email_invalid_msg;
        document.getElementById("ssw-validate-email-error").style.display="block"; 
        return false;
    }
    else {
        document.getElementById("ssw-validate-email-error").style.display="none";
        return true;
    }
}
/* ENDS Function to validate admin_email */

/* Function to validate site_address */
function ssw_js_validate_site_address() {

    var site_address_regex = /^[a-zA-Z0-9]+[a-zA-Z0-9_]*$/;
    site_address = document.getElementById('ssw-steps').site_address.value;

    if (!site_address_regex.test(site_address)) {
        document.getElementById("ssw-site-address-error-label").innerHTML=ssw_site_address_invalid_msg;
        document.getElementById("ssw-site-address-error").style.display="block"; 
        return false;
    }
    else {
        document.getElementById("ssw-site-address-error").style.display="none";
        return true;
    }
}
/* ENDS Function to validate site_address */

/* Function to validate site_title */
function ssw_js_validate_title() {

    var site_title_regex = /^.+$/;
    site_title = document.getElementById('ssw-steps').site_title.value;

    if (!site_title_regex.test(site_title)) {
        document.getElementById("ssw-site-title-error-label").innerHTML=ssw_site_title_invalid_msg;
        document.getElementById("ssw-site-title-error").style.display="block"; 
        return false;
    }
    else {
        document.getElementById("ssw-site-title-error").style.display="none"; 
        return true;
    }
}
/* ENDS Function to validate site_title */

/* Function to validate site_privacy */
function ssw_js_validate_privacy() {
    
    var privacy_button = document.getElementById('ssw-steps').site_privacy;
    var privacy_button_count = -1;

    for (var i=privacy_button.length-1; i > -1; i--) {
        if (privacy_button[i].checked) {privacy_button_count = i; i = -1;}
    }
    if (privacy_button_count > -1) {         
        document.getElementById("ssw-site-privacy-error").style.display="none"; 
        return true;
    }
    else {
        document.getElementById("ssw-site-privacy-error-label").innerHTML=ssw_site_privacy_error_msg;
        document.getElementById("ssw-site-privacy-error").style.display="block"; 
        return false;
    }
}
/* ENDS Function to validate site_privacy */

/* Function to validate select_theme */
function ssw_js_validate_theme() {
    
    var theme_button = document.getElementById('ssw-steps').select_theme;
    var theme_button_count = -1;

    for (var i=theme_button.length-1; i > -1; i--) {
        if (theme_button[i].checked) {theme_button_count = i; i = -1;}
    }
    if (theme_button_count > -1) {
        document.getElementById("ssw-themes-error").style.display="none"; 
        return true;
    }
    else {
        document.getElementById("ssw-themes-error-label").innerHTML=ssw_theme_error_msg;
        document.getElementById("ssw-themes-error").style.display="block"; 
        return false;
    }
}
/* ENDS Function to validate select_theme */

/* Function to validate site_terms */
function ssw_js_validate_terms() {
    
    var terms_checkbox = document.getElementById('ssw-steps').site_terms;
    
    if (terms_checkbox.checked) {
        document.getElementById("ssw-site-terms-error").style.display="none"; 
        return true;
    }
    else {
        document.getElementById("ssw-site-terms-error-label").innerHTML=ssw_terms_error_msg;
        document.getElementById("ssw-site-terms-error").style.display="block"; 
        return false;
    }
}
/* ENDS Function to validate site_terms */

/* JS for checking availability of site address from wordpress server */
function ssw_js_check_domain_available() {

    var site_exists = '';
    var site_address_bucket = document.getElementById('ssw-steps').site_address_bucket.value;
    var site_address = document.getElementById('ssw-steps').site_address.value;
    site_address = site_address.toLowerCase();
    var site_complete_path = ssw_js_get_site_complete_path();

    /*  AJAX request with aync flag true as we need the response synchrnously for use in the 
        ssw_js_validate_form() and ssw_js_submit_form_next() function 
    */
    jQuery.ajax({
        type: "POST", 
        url: ssw_custom_ajax.ajaxurl,
        dataType: "html",
        async: false,
        data: { 
            action: 'ssw_check_domain_exists',
            site_address_bucket: site_address_bucket,
            site_address: site_address,
            site_complete_path: site_complete_path,
            ssw_ajax_nonce: ssw_custom_ajax.ssw_ajax_nonce  
        },
        success: function(site_exists_value){
            site_exists = site_exists_value;
        } 
    });

    if(site_exists == 2) { //this is a banned site address
        document.getElementById("ssw-site-address-error-label").innerHTML=ssw_site_address_banned_msg;
        document.getElementById("ssw-site-address-error").style.display="block"; 
        return false;
    }
    else if (site_exists == 1) { //site already exists
        document.getElementById("ssw-site-address-error-label").innerHTML=ssw_site_address_unavailable_msg;
        document.getElementById("ssw-site-address-error").style.display="block"; 
        return false;
    }
    else if (site_exists == 0) { //site doesn't exist, good to go
        return true;
    }
    else {
        document.getElementById("ssw-site-address-error-label").innerHTML=ssw_site_address_other_error_msg;
        document.getElementById("ssw-site-address-error").style.display="block";
        return false;   
    }
}
/* ENDS JS for checking availability of site address from wordpress server */

/* JS to check if given admin email address is a registered user of the system */
function ssw_js_check_admin_email_exists() {

    var admin_user_id = '';
    
    /*  AJAX request with aync flag true as we need the response synchrnously for use in the 
        ssw_js_validate_form() and ssw_js_submit_form_next() function 
    */
    jQuery.ajax({
        type: "POST", 
        url: ssw_custom_ajax.ajaxurl,
        dataType: "html",
        async: false,
        data: { 
            action: 'ssw_check_admin_email_exists',
            admin_email: document.getElementById('ssw-steps').admin_email.value,
            ssw_ajax_nonce: ssw_custom_ajax.ssw_ajax_nonce  
        },
        success: function(admin_user_id_value){
            admin_user_id = admin_user_id_value;
        } 
    });

    if(admin_user_id == 0) {
        document.getElementById("ssw-validate-email-error-label").innerHTML=ssw_email_unavailable_msg;
        document.getElementById("ssw-validate-email-error").style.display="block";
        return false;
    }
    else if(admin_user_id > 0) {
        var theForm = document.forms['ssw-steps'];
        ssw_js_add_hidden_input(theForm, 'admin_user_id', admin_user_id);
        return true;
    }
    else {
        document.getElementById("ssw-validate-email-error-label").innerHTML=ssw_email_other_error_msg;
        document.getElementById("ssw-validate-email-error").style.display="block";
        return false;
    }
}
/* ENDS JS to check if given admin email address is a registered user of the system */

/* ENDS JS for Validating Forms based on current step */

/* Function for adding hidden input variables to a form */
function ssw_js_add_hidden_input(theForm, key, value) {

    // Create a hidden input element, and append it to theForm
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = key;
    input.value = value;
    theForm.appendChild(input);
}
/* ENDS Function for adding hidden input variables to a form */

/* Function for submitting first step data */
function ssw_js_submit_first_step(usage) {

    var theForm = document.forms['ssw-steps'];
    ssw_js_add_hidden_input(theForm, 'ssw_site_usage', usage);
    ssw_js_submit_form_next();
}
/* ENDS Function for submitting first step data */

/* Function to get site complete path from site category concatenated with site address */
function ssw_js_get_site_complete_path() {

    var site_address_bucket = document.getElementById('ssw-steps').site_address_bucket.value;
    var site_address = document.getElementById('ssw-steps').site_address.value;
    site_address = site_address.toLowerCase();
    var site_complete_path = '';  

    //Sample value for ssw_custom_ajax.site_address_bucket_none_value: ["Personal", "Personal1", ""];
    var site_address_bucket_none_value = ssw_custom_ajax.site_address_bucket_none_value;

    if (jQuery.inArray(site_address_bucket, site_address_bucket_none_value) < 0 && site_address_bucket != '') {
        site_complete_path = site_address_bucket + '-' + site_address;
    }
    else {
        site_complete_path = site_address;
    }

    return site_complete_path;
}
/* ENDS Function to get site complete path from site category concatenated with site address */

/* Function for displaying complete site address */
function ssw_js_site_address_display() {

    var site_complete_path = ssw_js_get_site_complete_path();
    var current_site_root_address = document.getElementById('ssw-steps').current_site_root_address.value;
    document.getElementById("ssw-site-address-display").innerHTML = current_site_root_address + site_complete_path;
}
/* ENDS Function for displaying complete site address */


/* Function to switch cursor icon between default and processing */
function ssw_js_display_processing(option) {
    var current_stage = document.forms['ssw-steps'].ssw_current_stage.value;
    if(option == true) {
        document.getElementById("ssw-steps").style.cursor="progress"; 
    }
    else {
        document.getElementById("ssw-steps").style.cursor="default"; 
    }
}
/* ENDS Function to switch cursor icon between default and processing */

/* Function to dosplay site processing message */
function ssw_js_display_processing_msg(option) {
    var current_stage = document.forms['ssw-steps'].ssw_current_stage.value;    
    if(option == true) {
        if(current_stage == 'ssw_step2') {
            document.getElementById("ssw-site-processing-label").innerHTML=ssw_site_processing_step2_msg;
            document.getElementById("ssw-site-processing").style.display="block";
        }
        else if(current_stage == 'ssw_step4') {
            document.getElementById("ssw-site-processing-label").innerHTML=ssw_site_processing_step4_msg;
            document.getElementById("ssw-site-processing").style.display="block";
        }
    }
    else {
        if(current_stage == 'ssw_step2' || current_stage == 'ssw_step4') {
            document.getElementById("ssw-site-processing").style.display="none";   
        }
    }
}
/* ENDS Function to dosplay site processing message */
