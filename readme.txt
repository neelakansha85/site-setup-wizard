=== Site Setup Wizard ===
Contributors: shahneel
Tags: plugin, wordpress, site setup wizard, multisite site registration, site creation, wordpress
Requires at least: 4.0
Tested up to: 4.5.2
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=2V9UGN9L5547U&lc=US&item_name=Site%20Setup%20Wizard%20Plugin&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted

== Description ==

Allows multisite registered users to create sites using pre selected features/settings in steps. This plugin can be used by placing a shortcode [site_setup_wizard] on any page. This plugin only works with subdirectory multisite install.

== Installation ==

* Download and install using the built in WordPress plugin installer.
* Activate in the "Plugins" network admin panel using the "Network Activate" link.
* Add shortcode `[site_setup_wizard]` on the page where you would like to display this wizard for allowing users to create new sites.
* You can change settings of the plugin from __Network Admin -> Create Site -> Options__ screen and click __Save Options__.

== Screenshots ==

1. Select Site Type
2. Essential Settings for creating a site
3. Select Features/Plugins available to activate on your site
4. Select Features/Plugins based on categorization from WPMU Pretty Plugins
5. Finish page for wizard displaying site url
6. Basic settings available in Site Setup Wizard
7. Advanced settings available in Site Setup Wizard
8. More settings available in Site Setup Wizard
9. Analytics page for metrics collection

== Upgrade Notice ==

= 1.4 =
This version changes the value for default settings.

== Frequently Asked Questions ==

= Does this plugin display Privacy Selection Options in wizard? = 

Yes, it does display wordpress privacy options for user to select while creating his site. You also have a choice to disable this if required.

= Does it support WPMU Multisite Privacy Plugin? = 

Yes, it supports and has an option for you to enable under External Plugins, if you want to take advantage of WPMU Multisite Privacy Plugin.

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