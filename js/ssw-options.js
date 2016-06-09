/* Site Setup Wizard */

/* JS for Site Setup Wizard Options Page */

var site_user_category = options['site_user_category'];
var site_category_no_prefix = options['site_category_no_prefix'];
var banned_site_address = options['banned_site_address'];
var hide_plugin_category = options['hide_plugin_category'];
var external_plugins = options['external_plugins'];
var wpmu_multisite_privacy_plugin = external_plugins['wpmu_multisite_privacy_plugin'] ? external_plugins['wpmu_multisite_privacy_plugin']: false;
var wpmu_pretty_plugins = external_plugins['wpmu_pretty_plugins'] ? external_plugins['wpmu_pretty_plugins'] : false;
var wpmu_multisite_theme_manager = external_plugins['wpmu_multisite_theme_manager'] ? external_plugins['wpmu_multisite_theme_manager'] : false;
var wpmu_new_blog_template = external_plugins['wpmu_new_blog_template'] ? external_plugins['wpmu_new_blog_template'] : false;

var privacy_selection_txt = options['advanced_privacy']['privacy_selection_txt'];
var private_network_users_txt = options['advanced_privacy']['private_network_users_txt'];
var private_site_users_txt = options['advanced_privacy']['private_site_users_txt'];
var private_administrator_txt = options['advanced_privacy']['private_administrator_txt'];

var user_role_mapping = options['user_role_mapping'];
var site_type = options['site_type'];
var is_user_role_restriction = options['user_role_restriction'] ? options['user_role_restriction'] : false;
var ssw_not_available = options['ssw_not_available'];
var ssw_not_available_txt = options['ssw_not_available_txt'];
var terms_of_use = options['terms_of_use'];
var plugins_page_txt = options['plugins_page_txt'];
var steps_name = options['steps_name'] ? options['steps_name'] : '';
var is_privacy_selection = options['privacy_selection'] ? options['privacy_selection'] : false;
var is_debug_mode = options['debug_mode'] ? options['debug_mode'] : false;
var is_master_user = options['master_user'] ? options['master_user'] : false;

// Create a Array for Site Users in order to process form
var siteUserArray = Object.keys(site_user_category);

// add a default --Select-- value to selectBox
function addNewSelectOption(selectBox) {
    var opt = document.createElement('option');
    opt.value = 'add_new';
    opt.innerHTML = '--Add New--';
    selectBox.appendChild(opt);
}

// function to convert Object to Array 
function objToArray(obj) {
    var arr = Array();
    for(var prop in obj) {
            if(!obj.hasOwnProperty([prop])) { continue; }
            arr.push(obj[prop]);
    }
    return arr;
}

function getUserSelect() {
    var userSelect = document.getElementById("ssw-user-role-select");
    return userSelect;
}

function getSiteTypeTxt() {
    var siteTypeTxt = document.getElementById("ssw-site-type");
    return siteTypeTxt;
}

function getSiteCategoryTxt() {
    var siteCategoryTxt = document.getElementById("ssw-site-category");
    return siteCategoryTxt;
}
function loadSelectFromArray(selectBox, srcArray) {
    selectBox.options.length = 0;
    if(srcArray.length>0) {
        for( var i=0; i<srcArray.length; i++) {
            var opt = document.createElement('option');
            opt.value = srcArray[i];
            opt.innerHTML = srcArray[i];
            selectBox.appendChild(opt);
            if(i == srcArray.length-1) {
                addNewSelectOption(selectBox);
            }
        }
    }
    else {
        addNewSelectOption(selectBox);
    }
}

function findPreviousSelection(selectBoxId) {
    var previous;
    jQuery('#'+selectBoxId).focus(function () {
        // Store the current value on focus, before it changes
        previous = this.value;
        console.log(this.value);
    }).change(function() {
        // Update userSelect based on the new selection
        var userSelect = getUserSelect();
        if(selectBoxId == userSelect.id) {
            updateUserRole(previous);
        }
        previous = this.value;
    });
}

function loadOptionsPage() {
    // add the values to userSelect by default on page load
    var userSelect = getUserSelect();
    var siteTypeTxt = getSiteTypeTxt();
    var siteCategoryTxt = getSiteCategoryTxt();
    var siteCategoryNoPrefix = document.getElementById("ssw-site-category-no-prefix");
    var bannedSiteAddress = document.getElementById("ssw-banned-site-address");
    var termsOfUse = document.getElementById("ssw-terms-of-use");
    var pluginsPageTxt = document.getElementById("ssw-plugins-page-txt");
    var privacySelection = document.getElementById("ssw-privacy-selection");
    var step1 = document.getElementById("ssw-step-1");
    var step2 = document.getElementById("ssw-step-2");
    var step3 = document.getElementById("ssw-step-3");
    var step4 = document.getElementById("ssw-step-4");
    var stepFinish = document.getElementById("ssw-step-finish");
    var wpmuMultisitePrivacyPlugin = document.getElementById("wpmu-multisite-privacy-plugin");
    var wpmuPrettyPlugin = document.getElementById("wpmu-pretty-plugin");
    var wpmuMultisiteThemeManagerPlugin = document.getElementById("wpmu-multisite-theme-manager-plugin");
    var wpmuNewBlogTemplatePlugin = document.getElementById("wpmu-new-blog-template-plugin");
    var privacySelectionTxt = document.getElementById("privacy-selection-txt");
    var privateNetworkUsersTxt = document.getElementById("private-network-users-txt");
    var privateSiteUsersTxt = document.getElementById("private-site-users-txt");
    var privateAdministratorTxt = document.getElementById("private-administrator-txt");
    var userRoleRestriction = document.getElementById("user-role-restriction");
    var sswNotAvailable = document.getElementById("ssw-not-available");
    var sswNotAvailableTxt = document.getElementById("ssw-not-available-txt");    
    var debugModeEnable = document.getElementById("ssw-debug-mode-enable");
    var debugModeDisable = document.getElementById("ssw-debug-mode-disable");
    var debugMasterUser = document.getElementById("ssw-debug-master-user");
    
    // load values of userSelect from siteUserArray
    loadSelectFromArray(userSelect, siteUserArray);

    findPreviousSelection(userSelect.id);    
    loadUserRole();

    // load remaining options independant values
    siteCategoryNoPrefix.value = site_category_no_prefix.join(",");
    bannedSiteAddress.value = banned_site_address.join(",");
    termsOfUse.innerHTML = terms_of_use;
    pluginsPageTxt.innerHTML = plugins_page_txt;
    privacySelection.checked = is_privacy_selection;

    // Wizard Titles
    step1.value = steps_name['step1'];
    step2.value = steps_name['step2'];
    step3.value = steps_name['step3'];
    step4.value = steps_name['step4'];
    stepFinish.value = steps_name['finish'];
    
    // External Plugins
    wpmuMultisitePrivacyPlugin.checked = wpmu_multisite_privacy_plugin;
    wpmuPrettyPlugin.checked = wpmu_pretty_plugins;
    wpmuMultisiteThemeManagerPlugin.checked = wpmu_multisite_theme_manager;
    wpmuNewBlogTemplatePlugin.checked = wpmu_new_blog_template;

    // Advanced Privacy Options
    privacySelectionTxt.innerHTML = privacy_selection_txt;
    privateNetworkUsersTxt.value = private_network_users_txt;
    privateSiteUsersTxt.value = private_site_users_txt;
    privateAdministratorTxt.value = private_administrator_txt;

    // User Role Restriction
    userRoleRestriction.checked = is_user_role_restriction;
    sswNotAvailable.value = ssw_not_available;
    sswNotAvailableTxt.innerHTML = ssw_not_available_txt;
    
    // Debug Settings
    if(is_debug_mode) {
        debugModeEnable.checked = is_debug_mode;
    }
    else {
        debugModeDisable.checked = true;
    }
    debugMasterUser.checked = is_master_user;
}

function loadUserRole() {
    var userSelect = getUserSelect();
    var siteTypeTxt = getSiteTypeTxt();
    var siteCategoryTxt = getSiteCategoryTxt();
    if (userSelect.value=='add_new')
    {
        document.getElementById("add-user-role-input").style.visibility='visible';
        document.getElementById("add-user-role-btn").style.visibility='visible';
        document.getElementById("remove-user-role-btn").style.visibility='hidden';

        // Set remaining select boxes to Add New
        siteTypeTxt.value = '';
        siteCategoryTxt.value = '';
    } 
    else 
    {
        document.getElementById("add-user-role-input").style.visibility='hidden';
        document.getElementById("add-user-role-btn").style.visibility='hidden';
        document.getElementById("remove-user-role-btn").style.visibility='visible';
    }
    loadSiteType(userSelect.value, siteTypeTxt);
        loadSiteCategory(userSelect.value, siteCategoryTxt);
}

function updateUserRole(previousUserSelected) {
    var userSelect = getUserSelect();
    var siteTypeTxt = getSiteTypeTxt();
    var siteCategoryTxt = getSiteCategoryTxt();

    jQuery.ajax({
        type: "POST",
        url: ssw_main_ajax.ajaxurl,
        dataType: "json",
        async: true,
        data: {
            action: 'ssw_save_options',
            update_user_role: previousUserSelected,
            site_type: siteTypeTxt.value,
            site_category: siteCategoryTxt.value,
            ssw_ajax_nonce: ssw_main_ajax.ssw_ajax_nonce
        },
        success: function(new_options) {
            //console.log(new_options);
            var site_user_category = new_options['site_user_category'];
            var site_type = new_options['site_type'];
            console.log('before loadSiteType');
            loadSiteType(userSelect.value, siteTypeTxt);
            loadSiteCategory(userSelect.value, siteCategoryTxt);
            console.log('after loadSiteType');
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });

    if (userSelect.value=='add_new')
    {
        document.getElementById("add-user-role-input").style.visibility='visible';
        document.getElementById("add-user-role-btn").style.visibility='visible';
        document.getElementById("remove-user-role-btn").style.visibility='hidden';

        // Set remaining select boxes to Add New
        siteTypeTxt.value = '';
        siteCategoryTxt.value = '';
    } 
    else 
    {
        document.getElementById("add-user-role-input").style.visibility='hidden';
        document.getElementById("add-user-role-btn").style.visibility='hidden';
        document.getElementById("remove-user-role-btn").style.visibility='visible';
    }
}

function loadSiteType(userSelected, siteTypeTxt) {
    /**
     *  Will be used using Select Box for SiteType input
     */
    // change value of siteTypeSelect based on userSelect value
    console.log('inside loadSiteType');
        var siteTypeUser = site_type[userSelected];
        var siteTypeArray = objToArray(siteTypeUser);
        console.log(siteTypeTxt);
        console.log(siteTypeUser);
        console.log(siteTypeArray);
        siteTypeTxt.value = '';
        for(var i=0; i<siteTypeArray.length; i++) {
            siteTypeTxt.value += siteTypeArray[i];
            if(i != siteTypeArray.length-1 ) {
                siteTypeTxt.value += '\n';
            }
        }
}
function loadSiteCategory(userSelected, siteCategoryTxt) {
    /**
     *  Will be used using Select Box for SiteCategory input
     */
    // change value of siteCategorySelect based on userSelect value
    console.log('inside loadSiteCategory');
        // change value of siteCategorySelect based on userSelect value
        var siteUserCategory = site_user_category[userSelected];
        var siteCategoryArray = objToArray(siteUserCategory);
        siteCategoryTxt.value = '';
        for(var i=0; i<siteCategoryArray.length; i++) {
            siteCategoryTxt.value += siteCategoryArray[i];
            if(i != siteCategoryArray.length-1 ) {
                siteCategoryTxt.value += '\n';
            }
        }
}

function addNewSelectValue(inputTxtId, selectBoxId) {
    var inputTxt = document.getElementById(inputTxtId);
    var selectBox = document.getElementById(selectBoxId);
    var userSelect = getUserSelect();

    if(selectBox == userSelect) {
        if(inputTxt.value != '') {
            saveNewUserRole(selectBox, inputTxt.value);
            inputTxt.value = '';
        }
        else {
            console.log('Please enter a valid User Role');
        }        
    }
}

function saveNewUserRole(userSelect, newUserRole) {
    jQuery.ajax ({
        type: "POST",
        url: ssw_main_ajax.ajaxurl,
        dataType: "json",
        async: true,
        data: {
            action: 'ssw_save_options',
            new_user_role: newUserRole,
            ssw_ajax_nonce: ssw_main_ajax.ssw_ajax_nonce
        },
        success: function(new_options) {
            site_user_category = new_options['site_user_category'];
            siteUserArray = Object.keys(site_user_category);
            // load new values of userSelect from siteUserArray
            loadSelectFromArray(userSelect, siteUserArray);
            userSelect.selectedIndex = siteUserArray.length-1;
            loadUserRole();
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
}

function removeSelectValue(selectBoxId) {
    var selectBox = document.getElementById(selectBoxId);
    var userSelect = getUserSelect();

    if(selectBox == userSelect) {
        var selectedUser = userSelect.options[userSelect.selectedIndex].value;
        removeUserRole(selectBox, selectedUser);
    }
}

function removeUserRole(userSelect, removeUserRole) {
    jQuery.ajax ({
        type: "POST",
        url: ssw_main_ajax.ajaxurl,
        dataType: "json",
        async: "true",
        data: {
            action: 'ssw_save_options',
            remove_user_role: removeUserRole,
            ssw_ajax_nonce: ssw_main_ajax.ssw_ajax_nonce
        },
        success: function(new_options) {
            site_user_category = new_options['site_user_category'];
            siteUserArray = Object.keys(site_user_category);
            // load new values of userSelect from siteUserArray
            loadSelectFromArray(userSelect, siteUserArray);
                userSelect.selectedIndex = siteUserArray.length-1;
            loadUserRole();
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
}

/* Function for adding hidden input variables to a form */
function addHiddenInput(theForm, key, value) {
    // Create a hidden input element, and append it to theForm
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = key;
    input.value = value;
    theForm.appendChild(input);
}

function setDefaultOptions() {
    jQuery.ajax({
        type: "POST",
        url: ssw_main_ajax.ajaxurl,
        dataType: "json",
        async: "true",
        data: {
            action: 'ssw_set_default_options',
            ssw_ajax_nonce: ssw_main_ajax.ssw_ajax_nonce
        },
        success: function(new_options) {
            // loadOptionsPage();
            location.reload(true);

        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
}

function saveOptions() {
    var theForm = document.forms['ssw-options-page'];
    addHiddenInput(theForm, 'ssw-user-roles', siteUserArray);

}

// Load the values first time when the page loads 
window.onload = loadOptionsPage();

/* ENDS JS for Site Setup Wizard Options Page */
