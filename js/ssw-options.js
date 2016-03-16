/* Site Setup Wizard */

/* JS for Site Setup Wizard Options Page */

var siteAddressBucket = options['site_address_bucket'];
var siteAddressBucketNoneValue = options['site_address_bucket_none_value'];
var banned_site_address = options['banned_site_address'];
var templateType = options['template_type'];
var selectTemplate = options['select_template'];
var hidePluginCategory = options['hide_plugin_category'];
var externalPlugins = options['external_plugins'];
var restrictedUserRoles = options['restricted_user_roles'];
var siteUsage = options['site_usage'];
var isSiteUsageDisplayCommon = options['site_usage_display_common'];
var sswNotAvailable = options['ssw_not_available'];
var termsOfUse = options['terms_of_use'];
var stepsName = options['steps_name'];
var isPrivacySelection = options['privacy_selection'];
var isDebugMode = options['debug_mode'];
var isMasterUser = options['master_user'];

console.log(siteAddressBucket);

var select = document.getElementById("ssw-user-role");

for(var siteAddressBucketUser in siteAddressBucket) {
    // skip loop if property is from prototype
    if(!siteAddressBucket.hasOwnProperty([siteAddressBucketUser])) { continue; }
    var opt = document.createElement('option');
    opt.value = siteAddressBucketUser;
    opt.innerHTML = siteAddressBucketUser;
    select.appendChild(opt);
//    console.log(siteAddressBucketUser);
}

function ssw_user_role() {
    console.log(options);
    var select = document.getElementById("ssw-user-role");
    if (select.value=='add_new')
    {        
//        document.getElementById("u72_input").style.visibility='visible'
//        document.getElementById("u73_img").style.visibility='visible'
    } 
    else 
    { 
//        document.getElementById("u72_input").style.visibility='hidden'
//        document.getElementById("u73_img").style.visibility='hidden'
    }; 
}

function ssw_site_category() {
    if (document.getElementById("ssw-site-category").value=='add_new')
    {        
        document.getElementById("u71_input").style.visibility='visible'
        document.getElementById("u75_img").style.visibility='visible'
    } 
    else 
    { 
        document.getElementById("u71_input").style.visibility='hidden'
        document.getElementById("u75_img").style.visibility='hidden'
    }; 
}

function ssw_site_type() {
    if (document.getElementById("ssw-site-type").value=='add_new')
    {        
        document.getElementById("u70_input").style.visibility='visible'
        document.getElementById("u77_img").style.visibility='visible'
    } 
    else 
    { 
        document.getElementById("u70_input").style.visibility='hidden'
        document.getElementById("u77_img").style.visibility='hidden'
    }; 
}

function ssw_select_template() {
    if (document.getElementById("ssw-select-template").value=='add_new')
    {        
        document.getElementById("u69_input").style.visibility='visible'
        document.getElementById("u79_img").style.visibility='visible'
    } 
    else 
    { 
        document.getElementById("u69_input").style.visibility='hidden'
        document.getElementById("u79_img").style.visibility='hidden'
    }; 
}

function ssw_banned_site_address() {
    if (document.getElementById("ssw-banned-site-address").value=='add_new')
    {        
        document.getElementById("u68_input").style.visibility='visible'
        document.getElementById("u83_img").style.visibility='visible'
    } 
    else 
    { 
        document.getElementById("u68_input").style.visibility='hidden'
        document.getElementById("u83_img").style.visibility='hidden'
    }; 
}
/* ENDS JS for Site Setup Wizard Options Page */
