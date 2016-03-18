/* Site Setup Wizard */

/* JS for Site Setup Wizard Options Page */

var site_address_bucket = options['site_address_bucket'];
var site_address_bucket_none_value = options['site_address_bucket_none_value'];
var banned_site_address = options['banned_site_address'];
var hide_plugin_category = options['hide_plugin_category'];
var external_plugins = options['external_plugins'];
    var wpmu_multisite_privacy_plugin = external_plugins['wpmu_multisite_privacy_plugin'] ? external_plugins['wpmu_multisite_privacy_plugin']: false;
    var wpmu_pretty_plugins = external_plugins['wpmu_pretty_plugins'] ? external_plugins['wpmu_pretty_plugins'] : false;
    var wpmu_multisite_theme_manager = external_plugins['wpmu_multisite_theme_manager'] ? external_plugins['wpmu_multisite_theme_manager'] : false;
    var wpmu_new_blog_template = external_plugins['wpmu_new_blog_template'] ? external_plugins['wpmu_new_blog_template'] : false;
var user_role_mapping = options['user_role_mapping'];
var site_usage = options['site_usage'];
var is_user_role_restriction = options['user_role_restriction'] ? options['user_role_restriction'] : false;
var ssw_not_available = options['ssw_not_available'];
var terms_of_use = options['terms_of_use'];
var plugins_page_note = options['plugins_page_note'];
var steps_name = options['steps_name'] ? options['steps_name'] : '';
var is_privacy_selection = options['privacy_selection'] ? options['privacy_selection'] : false;
var is_debug_mode = options['debug_mode'] ? options['debug_mode'] : false;
var is_master_user = options['master_user'] ? options['master_user'] : false;

console.log(options);

// add a default --Select-- value to selectBox
function add_new_select_option(selectBox) {
    var opt = document.createElement('option');
    opt.value = 'add_new';
    opt.innerHTML = '--Add New--';
    selectBox.appendChild(opt);
}

function options_page() {
    // add the values to userSelect by default on page load
    var userSelect = document.getElementById("ssw-user-role");
    var siteCategoryNonePrefix = document.getElementById("ssw-site-category-none-prefix");
    var bannedSiteAddress = document.getElementById("ssw-banned-site-address");
    var termsOfUse = document.getElementById("ssw-terms-of-use");
    var pluginsPageNote = document.getElementById("ssw-plugins-page-note");
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
    var debugModeEnable = document.getElementById("ssw-debug-mode-enable");
    var debugModeDisable = document.getElementById("ssw-debug-mode-disable");
    var debugMasterUser = document.getElementById("ssw-debug-master-user");
    for(var siteAddressBucketUser in site_address_bucket) {
        // skip loop if property is from prototype
        if(!site_address_bucket.hasOwnProperty([siteAddressBucketUser])) { continue; }
        var opt = document.createElement('option');
        opt.value = siteAddressBucketUser;
        opt.innerHTML = siteAddressBucketUser;
        userSelect.appendChild(opt);
    }
    add_new_select_option(userSelect);
    ssw_user_role();

    // load remaining options independant values
    siteCategoryNonePrefix.value = site_address_bucket_none_value.join(" ");
    bannedSiteAddress.value = banned_site_address.join(" ");
    termsOfUse.innerHTML = terms_of_use;
    pluginsPageNote.innerHTML = plugins_page_note;
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
    
    // Debug Settings
    if(is_debug_mode) {
        debugModeEnable.checked = is_debug_mode;
    }
    else {
        debugModeDisable.checked = true;
    }
        debugMasterUser.checked = is_master_user;
}

function ssw_user_role() {
    var userSelect = document.getElementById("ssw-user-role");
    var siteUsageSelect = document.getElementById("ssw-site-usage");
    var siteCategorySelect = document.getElementById("ssw-site-category");
    if (userSelect.value=='add_new')
    {
        document.getElementById("add-user-role-input").style.visibility='visible';
        document.getElementById("add-user-role-btn").style.visibility='visible';

        // Set remaining select boxes to Add New
        document.getElementById("ssw-site-category").value='add_new';
        document.getElementById("ssw-site-usage").value='add_new';
    } 
    else 
    {
        document.getElementById("add-user-role-input").style.visibility='hidden';
        document.getElementById("add-user-role-btn").style.visibility='hidden';

        // change value of siteUsageSelect based on userSelect value
        var siteUsageUser = site_usage[userSelect.value];
        siteUsageSelect.options.length = 0;
        for(var prop in siteUsageUser) {
            if(!siteUsageUser.hasOwnProperty([prop])) { continue; }
            var opt = document.createElement('option');
            opt.value = prop;
            opt.innerHTML = siteUsageUser[prop];
            siteUsageSelect.appendChild(opt);
        }
        add_new_select_option(siteUsageSelect);

        // change value of siteCategorySelect based on userSelect value
        var siteCategoryUser = site_address_bucket[userSelect.value];
        siteCategorySelect.options.length = 0;
        for(var prop in siteCategoryUser) {
            if(!siteCategoryUser.hasOwnProperty([prop])) { continue; }
            var opt = document.createElement('option');
            opt.value = prop;
            opt.innerHTML = siteCategoryUser[prop];
            siteCategorySelect.appendChild(opt);
        }
        add_new_select_option(siteCategorySelect);
    }

    // trigger change function for siteCategorySelect and siteUsageSelect
    ssw_site_usage();
    ssw_site_category();
}

function ssw_site_usage() {
    if (document.getElementById("ssw-site-usage").value=='add_new')
    {        
        document.getElementById("add-site-usage-input").style.visibility='visible';
        document.getElementById("add-site-usage-btn").style.visibility='visible';

        // Set remaining select boxes to Add New
        document.getElementById("ssw-site-category").value='add_new';
    } 
    else 
    { 
        document.getElementById("add-site-usage-input").style.visibility='hidden';
        document.getElementById("add-site-usage-btn").style.visibility='hidden';
    }; 
}

function ssw_site_category() {
    if (document.getElementById("ssw-site-category").value=='add_new')
    {
        document.getElementById("add-site-category-input").style.visibility='visible';
        document.getElementById("add-site-category-btn").style.visibility='visible';
    } 
    else 
    { 
        document.getElementById("add-site-category-input").style.visibility='hidden';
        document.getElementById("add-site-category-btn").style.visibility='hidden';
    }; 
}


function ssw_add_new_value(inputTxtId, selectBoxId) {
    var inputTxt = document.getElementById(inputTxtId);
    var selectBox = document.getElementById(selectBoxId);
    var userSelect = document.getElementById("ssw-user-role");

var arr = Object.keys(options['site_address_bucket']).map(function (selectedUser) {return options['site_address_bucket'][selectedUser]});
    if(selectBox != userSelect) {
        var selectedUser = userSelect.options[userSelect.selectedIndex].value;
        if(selectBox.value == 'ssw-site-usage') {
            options['site_usage'][selectedUser][inputTxt.value.replace(/ /g, "_")] = inputTxt.value;
        }
        if(selectBox.value == 'ssw-site-category') {
            //options['site_address_bucket'][selectedUser][inputTxt.value] = inputTxt.value;


        }
    }

console.log(arr);


    
/*    var opt = document.createElement('option');
    opt.value = inputTxt.value.replace(/ /g,"_");
    opt.innerHTML = inputTxt.value;
    selectBox.appendChild(opt);
*/
    

    //console.log(site_usage); 
    console.log(site_address_bucket);
}

// Load the values first time when the page loads 
window.onload = options_page();

/* ENDS JS for Site Setup Wizard Options Page */
