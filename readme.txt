=== Site Setup Wizard ===
Contributors: shah.neel
Tags: plugin, multisite, site setup wizard, site registration, site creation, create site, wp-signup
Requires at least: 4.0
Tested up to: 4.8
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=2V9UGN9L5547U&lc=US&item_name=Site%20Setup%20Wizard%20Plugin&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted

Offers registered users flexibility to select site type, plugins, privacy and many other settings before creating a new site.

== Description ==

Site Setup Wizard plugin allows all your multisite registered users to be able to create new sites using many options such as their site type, category, address, theme, plugins they want to activate, privacy and many more in form of steps. It can be used by placing a shortcode [site_setup_wizard] on any page. Site category and addresses are separated using a hyphen (-). For example in http://yourdomain.com/hr-benefits **hr is a site category** while **benefits is site address**. This helps in organizing sites efficiently.   

Requires a wordpress multisite subdirectory install. 

= Users can select from the below options =
* Site Type
* Site Category
* Site Address
* Site Title
* Site Privacy
* Site Admin's Email (Only allows for a registered user's email address to be used while creating a site)
* Theme for your new site (Only displays Network Activated Themes)
* Plugins to be activated

= Current Features =
* Displays different Site Type and Site Category based on user role mapping if activated
* Allows users to select theme for their new site
* Integrates with WPMU Multisite Privacy Plugin to provide advanced privacy options
* Integrates with WPMU Pretty Plugins to provide categorization of Plugins
* Updates plugins list on installing/removing a plugin
* Bans users except super admins to be able to create sites with a site category as the complete site url
* Allows super admins to set banned site urls
* Allows super admins to create categories which do not need to have any prefixes in site address
* Provides Analytics of total sites created using this plugin based on the site type
* Allows users to resume Site Setup Wizard steps if they did not finish all steps
* Sends notification to users after creating a site
* Allows super admins to configure text displayed on all steps
* Allows super admins to decide whether user should be able to select privacy or not
* Registers option 'nsd_ssw_site_type' with Site Type value for every site created
* Registers option 'nsd_ssw_user_role' with Admin's User Role value from main site in newly created site's option table
* Hide specific Themes or Plugins from the Wizard Steps.
* Allows super admins to perform additional checks if required before displaying all steps to a user. (Using [SSW Additional Checks](https://wordpress.org/plugins/ssw-additional-checks/)
* Option to map wordpress user role with Site Setup Wizard user roles (Currently in beta)

= Coming soon =
* A step in wizard to Add New Users to their site while creating it
* Integrate with WPMU New Blog Template

Please check Screenshots for more information.

== Installation ==

* Download and install using the built in WordPress plugin installer.
* Activate in the "Plugins" network admin panel using the "Network Activate" link.
* Add shortcode `[site_setup_wizard]` on the page where you would like to display this wizard for allowing users to create new sites.
* You can change settings of the plugin from __Network Admin -> Create Site -> Options__ screen and click __Save Options__.

== Screenshots ==

1. Select Site Type
2. Essential Settings for creating a site
3. Select Theme for your site
4. Select Features/Plugins available to activate on your site
5. Select Features/Plugins based on categorization from WPMU Pretty Plugins
6. Finish page for wizard displaying site url
7. Basic settings available in Site Setup Wizard
8. Advanced settings available in Site Setup Wizard
9. More settings available in Site Setup Wizard
10. Analytics page for metrics collection

== Upgrade Notice ==
= 1.5.8 =
Fixed broken css issue when using Twenty Seventeen theme and Site Setup Wizard

= 1.5.7 =
Fixed issue related to not allowing users to create sites with a single quote in the site title

= 1.5.6 = 
Added new feature to hide selected Themes and Plugins from wizard steps.

= 1.5.5 = 
Added new charts on Analytics Page.

= 1.5.4 = 
Fixed a critical issue related to Themes Step. Please update now.

= 1.5.3 =
Added new feature to allow super admins to perform additional check before displaying all steps to user.

= 1.5.2 =
Added new feature. Fixed CSS issue on Theme page in Network Admin dashboard.

= 1.5.1 =
Bug fixes.

= 1.5 =
Provides a new step for selecting Themes to users.

= 1.4.1= 
Fixed a critical issue related to your custom settings. Please update now.

= 1.4 =
This version changes the value for default settings.

== Frequently Asked Questions ==

= Does this plugin display Privacy Selection Options in wizard? = 

Yes, it does display wordpress privacy options for user to select while creating his site. You also have a choice to disable this if required.

= Does it support WPMU Multisite Privacy Plugin? = 

Yes, it supports and has an option for you to enable under External Plugins, if you want to take advantage of WPMU Multisite Privacy Plugin.

= How do I change the default Yellow color of buttons? =

Please use CSS property to change button color for now. You can use class **.ssw-start-btn** and **.ssw-front-btn** to change color of button on all steps. For example using below CSS you can set all buttons to black color:
`.ssw-front-btn {
  background-color: #000 !important;
}

.ssw-start-btn {
  background-color: #000 !important;
}`


= Does this plugin display a list of all available plugins to select while creating a site? = 

Yes, it supports and displays all available for users to select on `Features (Step 4)` Page while creating a site if WPMU Pretty Plugins check box is not enabled under External Plugins section on `Options` page.

= Does it support WPMU Pretty Plugins? = 

Yes, it supports and has an option for you to enable under External Plugins, if you want to take additional advantage of WPMU Pretty Plugins. It will display all available plugins to users based on categories defined in WPMU Pretty Plugins. 

= Does this plugin work with a CDN enabled? = 

Yes, this plugin works fine with a CDN enabled for your site.

= Will this work on standard WordPress? =

You can activate it, but it won't do anything. You need to have the multisite functionality enabled and working first.

= Does it allow super admins to set banned site names? = 

Yes, it allows Super admins to add a set of banned site addresses/names from the Options page.

= Will it send a notification to users after creating a site? =

Yes, it sends a notification email to the site admin after completing the Site Setup Wizard. It also displays user new site url on the last page of the wizard.

= Does this plugin support resuming of wizard process? =

Yes, this plugin has an ability to resume wizard steps from where you left last until you finish it completely or click cancel on the top right side.

= Does it provide analytics of sites created using this plugin? =

Yes, you can view analytics based on site type selection from the `Analytics` page under `Create` on the Network Admin Dashboard.

= Does it allow users to create sites based on Site Type? =

Yes, it allows you to define/create site types from the options page and categorizes sites created based on the site type selected by the user during site setup wizard. In near future this site type will also be saved in the site's options table for you to take advantage of in order to provide further customization to users based on the site type.

= Does it provide different options based on the user's role defined in wordpress? =

Yes, it provides super admins with ability to define restrictions or different options such as Site Categories or Site Type to select during the site setup wizard based on their role defined in Wordpress main site.

= Where can I get support? =

The WordPress support forums: https://wordpress.org/support/plugin/site-setup-wizard/

= Where can I find documentation? =

Please check https://github.com/neelakansha85/site-setup-wizard for more documentation for now.

== Changelog ==
= 1.5.8 =
* Added new option to add custom message on the Finish page [Issue #44](https://github.com/neelakansha85/site-setup-wizard/issues/44)
* Fixed [Issue #43](https://github.com/neelakansha85/site-setup-wizard/issues/43)

= 1.5.7 =
* Fixed [Issue #42](https://github.com/neelakansha85/site-setup-wizard/issues/42).

= 1.5.6 =
* Added a new feature to hide selected Themes from theme selection page. Please refer to [Issue #35](https://github.com/neelakansha85/site-setup-wizard/issues/35) for additional details.
* Added a new feature to hide selected Plugins from plugins selection (Features) page. Please refer to [Issue #36](https://github.com/neelakansha85/site-setup-wizard/issues/36) for additional details.

= 1.5.5 = 
* Added pretty charts on Analytics Page for meaningful insights of Plugin usage.
* Added new feature to allow super admins to hide Features page if required.

= 1.5.4 =
* Fixed an issue related to Theme step displaying all network enabled themes. Please refer to [Issue #32](https://github.com/neelakansha85/site-setup-wizard/issues/32) for additional details.

= 1.5.3 =
* Added new feature to allow super admins to perform additional check before displaying all steps to user using [SSW Additional Checks](https://github.com/neelakansha85/ssw-additional-checks) Plugin. Please refer to [Issue #31](https://github.com/neelakansha85/site-setup-wizard/issues/31) for additional details.

= 1.5.2 =
* Added new feature to save admin's user role while creating new site. [Issue #28](https://github.com/neelakansha85/site-setup-wizard/issues/28)
* Fixes CSS issue for Theme page in Network Admin Dashboard.[Issue #29](https://github.com/neelakansha85/site-setup-wizard/issues/29)

= 1.5.1 =
* Fixes error message being displayed on Features page while returning from Themes page using Back button.

= 1.5 =
* Added new Select Theme step after Essential Settings. [Issue #21](https://github.com/neelakansha85/site-setup-wizard/issues/21)
* Store Site Type option for newly created sites. [Issue #20](https://github.com/neelakansha85/site-setup-wizard/issues/20)

= 1.4.1 = 
* Fixed an issue where users custom settings would get deleted on deactivating plugin.
* Added upgrade functionality for updating database when required. [Issue #26](https://github.com/neelakansha85/site-setup-wizard/issues/26)

= 1.4 = 
* Added new Export/Import settings functionality.
* Updated default settings value for releasing in Wordpress.org.
* Updated readme.txt with new screenshots for plugin.
* Fixed [Issue #25](https://github.com/neelakansha85/site-setup-wizard/issues/25).
* Fixed PHP Notice issue for undefined ssw-user-roles.

= 1.3.1 =
* Renamed plugins's main database table to wp_nsd_site_setup_wizard
* Fixed [Issue #14](https://github.com/neelakansha85/site-setup-wizard/issues/14).

= 1.3 =
* Added a functional Options Page to modify settings.
* Added a Reset to Default button for resetting all options.
* Optimized code or security and performance.
* Added custom sanitize functions for sanitizing user inputs.
* Fixed finding plugins default data when Pretty Plugins is enabled but does not override Plugin's default name.
* Changed site_type value in options from associate array to array.

= 1.2.5 =
* Fixed notices coming on Step4.php when WPMU Pretty Plugins is enabled but does not have any plugins categorized.
* Added variables from ssw_find_plugins() method in Debug file.
* Corrected readme file texts.

= 1.2.4 =
* Renamed site_usage to site_type in wp_ssw_main_nsd table and other places as as required.
* Added readme.txt and license.txt for wordpress.org support.

= 1.2.3 =
* Added Options Page to view all options for Site Setup Wizard
* Added new options to configure in Options Page
* Removed template_type field from wp_ssw_main_nsd table
* Fixed [Issue #12](https://github.com/neelakansha85/site-setup-wizard/issues/12) Restricting users from creating sites with names as site categories
* Fixed [Issue #1](https://github.com/neelakansha85/site-setup-wizard/issues/1)
* Fixed PHP Warnings and Notices that used to appear when running this plugin. 

= 1.2.2 = 
* Added a Readme.md file for documentation
* Added Debug functionality to plugin where it logs all plugin data to wp-content/uploads/**nsd_ssw_sql_log.log** if **debug_mode** is set true.
* Changed custom.js to ssw-main.js and variables associated with it for identifying it easily while degubbing.
* Fixed [Issue #3](https://github.com/neelakansha85/site-setup-wizard/issues/3) conflicting with Activity Log Plugin.
* Fixed [Issue #2](https://github.com/neelakansha85/site-setup-wizard/issues/2) related to Quick Draft and Permalinks not working.

= 1.2.0 =
* Initialized this plugin with proper documentation and structure for release.