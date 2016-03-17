/* Site Setup Wizard */

/* JS for Site Setup Wizard Options Page */

var site_address_bucket = options['site_address_bucket'];
var site_address_bucket_none_value = options['site_address_bucket_none_value'];
var banned_site_address = options['banned_site_address'];
var hide_plugin_category = options['hide_plugin_category'];
var external_plugins = options['external_plugins'];
var restricted_user_roles = options['restricted_user_roles'];
var site_usage = options['site_usage'];
var is_site_usage_display_common = options['site_usage_display_common'];
var ssw_not_available = options['ssw_not_available'];
var terms_of_use = options['terms_of_use'];
var steps_name = options['steps_name'];
var is_privacy_selection = options['privacy_selection'];
var is_debug_mode = options['debug_mode'];
var is_master_user = options['master_user'];

console.log(site_address_bucket);

// add a default --Select-- value to selectBox
function add_new_select_option(selectBox) {
    var opt = document.createElement('option');
    opt.value = 'add_new';
    opt.innerHTML = '--Add New--';
    selectBox.appendChild(opt);
}

function options_page() {
    console.log(options);
    // add the values to userSelect by default on page load
    var userSelect = document.getElementById("ssw-user-role");
    var siteCategoryNonePrefix = document.getElementById("ssw-site-category-none-prefix");
    var bannedSiteAddress = document.getElementById("ssw-banned-site-address");
    var termsOfUse = document.getElementById("ssw-terms-of-use");
    var privacySelection = document.getElementById("ssw-privacy-selection");
    var sswFinish = document.getElementById("ssw-finish");
    var wpmuMultisitePrivacyPlugin = document.getElementById("wpmu-multisite-privacy-plugin");
    var wpmuPrettyPlugin = document.getElementById("wpmu-pretty-plugin");
    var wpmuMultisiteThemeManagerPlugin = document.getElementById("wpmu-multisite-theme-manager-plugin");
    var wpmuMultisiteNewBlogTemplatePlugin = document.getElementById("wpmu-multisite-new-blog-template-plugin");
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

    console.log(site_address_bucket_none_value);

    // load remaining options independant values
    siteCategoryNonePrefix.value = site_address_bucket_none_value.join(" ");
    bannedSiteAddress.value = banned_site_address.join(" ");
    termsOfUse.innerHTML = terms_of_use;
    privacySelection.checked = is_privacy_selection ? is_privacy_selection : false;

}

function ssw_user_role() {
//    console.log(options);
    var userSelect = document.getElementById("ssw-user-role");
    var siteUsageSelect = document.getElementById("ssw-site-usage");
    var siteCategorySelect = document.getElementById("ssw-site-category");
//    console.log(site_usage[userSelect.value]);
    if (userSelect.value=='add_new')
    {
//        document.getElementById("add-user-input").style.visibility='visible'
//        document.getElementById("add-user-img").style.visibility='visible'
    } 
    else 
    {
//        document.getElementById("add-user-input").style.visibility='hidden'
//        document.getElementById("add-user-img").style.visibility='hidden'

        // change value of siteUsageSelect based on userSelect value
        var siteUsageUser = site_usage[userSelect.value];
        siteUsageSelect.options.length = 0;
        for(var prop in siteUsageUser) {
            if(!siteUsageUser.hasOwnProperty([prop])) { continue; }
            var opt = document.createElement('option');
            opt.value = prop;
            opt.innerHTML = siteUsageUser[prop];
            siteUsageSelect.appendChild(opt);
            //console.log(siteUsageUser);
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
            //console.log(siteUsageUser);
        }
        add_new_select_option(siteCategorySelect);

    }
}

function ssw_site_category() {
    if (document.getElementById("ssw-site-category").value=='add_new')
    {
        document.getElementById("add-site-category-input").style.visibility='visible'
        document.getElementById("add-site-category-img").style.visibility='visible'
    } 
    else 
    { 
        document.getElementById("add-site-category-input").style.visibility='hidden'
        document.getElementById("add-site-category-img").style.visibility='hidden'
    }; 
}

function ssw_banned_site_address() {
    if (document.getElementById("ssw-banned-site-address").value=='add_new')
    {        
        document.getElementById("add-banned-site-address-input").style.visibility='visible'
        document.getElementById("add-banned-site-address-img").style.visibility='visible'
    } 
    else 
    { 
        document.getElementById("add-banned-site-address-input").style.visibility='hidden'
        document.getElementById("add-banned-site-address-img").style.visibility='hidden'
    }; 
}

// Load the values first time when the page loads 
window.onload = options_page();

/* ENDS JS for Site Setup Wizard Options Page */
