/* Site Setup Wizard */

/* JS for Site Setup Wizard Options Page */

// add a default --Add New-- value to selectBox
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
    }).change(function() {
        // Update userSelect based on the new selection
        var userSelect = getUserSelect();
        if(selectBoxId == userSelect.id) {
            updateUserRole(previous);
        }
        previous = this.value;
    });
}

function loadOptionsPage(options) {
    // initialize all DOM elements
    var userSelect = getUserSelect();
    var siteTypeTxt = getSiteTypeTxt();
    var siteCategoryTxt = getSiteCategoryTxt();
    var siteCategoryNoPrefix = document.getElementById("ssw-site-category-no-prefix");
    var bannedSiteAddress = document.getElementById("ssw-banned-site-address");
    var termsOfUse = document.getElementById("ssw-terms-of-use");
    var hideThemes = document.getElementById("ssw-hide-themes");
    var hidePlugins = document.getElementById("ssw-hide-plugins");
    var pluginsPageTxt = document.getElementById("ssw-plugins-page-txt");
    var finishPageTxt = document.getElementById("ssw-finish-page-txt");
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

    var is_debug_mode = options['debug_mode'] ? options['debug_mode'] : false;
    
    // Create a Array for Site Users in order to process form
    var siteUserArray = Object.keys(options.site_user_category);
    
    // load values of userSelect from siteUserArray
    loadSelectFromArray(userSelect, siteUserArray);

    findPreviousSelection(userSelect.id);    
    loadUserRole(options.site_type, options.site_user_category);

    // load remaining options independant values
    siteCategoryNoPrefix.value = options.site_category_no_prefix.join(", ");
    bannedSiteAddress.value = options.banned_site_address.join(", ");
    termsOfUse.innerHTML = options.terms_of_use;
    hideThemes.value = options.hide_themes.join(", ");
    hidePlugins.value = options.hide_plugins.join(", ");
    pluginsPageTxt.innerHTML = options.plugins_page_txt ? options.plugins_page_txt : "";
    finishPageTxt.innerHTML = options.finish_page_txt ? options.finish_page_txt : "";
    privacySelection.checked = options.privacy_selection ? options.privacy_selection : false;

    // Wizard Titles
    step1.value = options.steps_name.step1;
    step2.value = options.steps_name.step2;
    step3.value = options.steps_name.step3;
    step4.value = options.steps_name.step4;
    stepFinish.value = options.steps_name.finish;
    
    // External Plugins
    wpmuMultisitePrivacyPlugin.checked = options.external_plugins.wpmu_multisite_privacy_plugin ? options.external_plugins.wpmu_multisite_privacy_plugin : false;
    wpmuPrettyPlugin.checked = options.external_plugins.wpmu_pretty_plugins ? options.external_plugins.wpmu_pretty_plugins : false;
    wpmuMultisiteThemeManagerPlugin.checked = options.external_plugins.wpmu_multisite_theme_manager ? options.external_plugins.wpmu_multisite_theme_manager : false;
    wpmuNewBlogTemplatePlugin.checked = options.external_plugins.wpmu_new_blog_template ? options.external_plugins.wpmu_new_blog_template : false;

    // Advanced Privacy Options
    privacySelectionTxt.innerHTML = options.advanced_privacy.privacy_selection_txt;
    privateNetworkUsersTxt.value = options.advanced_privacy.private_network_users_txt;
    privateSiteUsersTxt.value = options.advanced_privacy.private_site_users_txt;
    privateAdministratorTxt.value = options.advanced_privacy.private_administrator_txt;

    // User Role Restriction
    userRoleRestriction.checked = options.user_role_restriction ? options.user_role_restriction : false;
    sswNotAvailable.value = options.ssw_not_available;
    sswNotAvailableTxt.innerHTML = options.ssw_not_available_txt;
    
    // Debug Settings
    if(is_debug_mode) {
        debugModeEnable.checked = is_debug_mode;
    }
    else {
        debugModeDisable.checked = true;
    }
    debugMasterUser.checked = options.master_user ? options.master_user : false;
}

function loadUserRole(siteType, siteCategory) {
    var userSelect = getUserSelect();
    var siteTypeTxt = getSiteTypeTxt();
    var siteCategoryTxt = getSiteCategoryTxt();

    showHideAddNew(userSelect);
    loadSiteType(siteType[userSelect.value]);
    loadSiteCategory(siteCategory[userSelect.value]);
}

function showHideAddNew(selectBox) {
    var siteTypeTxt = getSiteTypeTxt();
    var siteCategoryTxt = getSiteCategoryTxt();

    if (selectBox.value=='add_new')
    {
        document.getElementById("add-user-role-input").style.visibility='visible';
        document.getElementById("add-user-role-btn").style.visibility='visible';
        document.getElementById("remove-user-role-btn").style.visibility='hidden';

        // Set dependent Textarea to null
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
            loadSiteType(new_options.site_type[userSelect.value]);
            loadSiteCategory(new_options.site_user_category[userSelect.value]);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
    showHideAddNew(userSelect);
}

function loadSiteType(siteType) {
    // change value of siteTypeSelect based on userSelect value
    var siteTypeTxt = getSiteTypeTxt();
    var siteTypeArray = objToArray(siteType);
    siteTypeTxt.value = '';
    for(var i=0; i<siteTypeArray.length; i++) {
        siteTypeTxt.value += siteTypeArray[i];
        if(i != siteTypeArray.length-1 ) {
            siteTypeTxt.value += '\n';
        }
    }
}
function loadSiteCategory(siteCategory) {
    // change value of siteCategorySelect based on userSelect value
    var siteCategoryTxt = getSiteCategoryTxt();
    var siteCategoryArray = objToArray(siteCategory);
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
            siteUserArray = Object.keys(new_options.site_user_category);
            // load new values of userSelect from siteUserArray
            loadSelectFromArray(userSelect, siteUserArray);
            userSelect.selectedIndex = siteUserArray.length-1;
            loadUserRole(new_options.site_type, new_options.site_user_category);
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
            siteUserArray = Object.keys(new_options.site_user_category);
            // load new values of userSelect from siteUserArray
            loadSelectFromArray(userSelect, siteUserArray);
                userSelect.selectedIndex = siteUserArray.length-1;
            loadUserRole(new_options.site_type, new_options.site_user_category);
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
             loadOptionsPage(new_options);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
}

function saveOptions() {
    var theForm = document.forms['ssw-options-page'];
}

// Load the values first time when the page loads 
window.onload = loadOptionsPage(sswOptions);

/* ENDS JS for Site Setup Wizard Options Page */
