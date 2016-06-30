# [Wordpress Site Setup Wizard Plugin](https://wordpress.org/plugins/site-setup-wizard)
![Banner](http://plugins.svn.wordpress.org/site-setup-wizard/assets/banner-772x250.png)

Site Setup Wizard plugin allows all your multisite registered users to be able to create new sites using different many options such as their site type, category, address, theme, plugins they want to activate, privacy and many more in form of steps. It can be used by placing a shortcode [site_setup_wizard] on any page. Site category and addresses are seperated using a hyphen (-). For example in [http://yourdomain.com/hr-benefits](#) **hr is a site category** while **benefits is site address**. This helps in organizing sites effeciently. 

You can also find [Site Setup Wizard](https://wordpress.org/plugins/site-setup-wizard) in [wordpress.org](https://wordpress.org/plugins/site-setup-wizard).

* Tags: wordpress plugin, site setup wizard, multisite, site registration, site creation, create site, wp-signup
* Requires at least: 4.0
* Requires PHP: 5.5
* Tested up to: 4.5.3
* Stable tag: master
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Features

* Users can select from the below options
    * Site Type
    * Site Category
    * Site Address
    * Site Title
    * Site Privacy
    * Site Admin's Email (Only allows for a registered user's email address to be used while creating a site)
    * Theme for your new site (Only displays Network Activated Themes)
    * Plugins to be activated

* Current Features
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
    * Option to map wordpress user role with Site Setup Wizard user roles (Currently in beta)

`GitHub Plugin URI: https://github.com/neelakansha85/site-setup-wizard`

## Screenshots

![Screenshot-1](http://plugins.svn.wordpress.org/site-setup-wizard/assets/screenshot-1.png)
![Screenshot-2](http://plugins.svn.wordpress.org/site-setup-wizard/assets/screenshot-2.png)
![Screenshot-3](http://plugins.svn.wordpress.org/site-setup-wizard/assets/screenshot-3.png)
![Screenshot-4](http://plugins.svn.wordpress.org/site-setup-wizard/assets/screenshot-4.png)
![Screenshot-5](http://plugins.svn.wordpress.org/site-setup-wizard/assets/screenshot-5.png)
![Screenshot-6](http://plugins.svn.wordpress.org/site-setup-wizard/assets/screenshot-6.png)
![Screenshot-7](http://plugins.svn.wordpress.org/site-setup-wizard/assets/screenshot-7.png)
![Screenshot-8](http://plugins.svn.wordpress.org/site-setup-wizard/assets/screenshot-8.png)
![Screenshot-9](http://plugins.svn.wordpress.org/site-setup-wizard/assets/screenshot-9.png)
![Screenshot-10](http://plugins.svn.wordpress.org/site-setup-wizard/assets/screenshot-10.png)

## Installation

### Upload

1. Download the latest [tagged archive](https://github.com/neelakansha85/site-setup-wizard/releases) (choose the "zip" option).
2. Unzip the archive, rename the folder correctly to `site-setup-wizard`, then re-zip the file.
3. Go to the __Network Admin -> Plugins -> Add New__ screen and click the __Upload__ tab.
4. Upload the zipped archive directly.
5. Go to the Network Admin -> Plugins screen and click __Network Activate__ below __Site Setup Wizard__.

### Manual

1. Download the latest [tagged archive](https://github.com/neelakansha85/site-setup-wizard/releases) (choose the "zip" option).
2. Unzip the archive, rename the folder to `site-setup-wizard`.
3. Copy the folder to your `/wp-content/plugins/` directory.
4. Go to the __Network Admin -> Plugins__ screen and click __Network Activate__ below __Site Setup Wizard__.

Check out the Codex for more information about [installing plugins manually](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

# Usage
* Default plugin settings will be configured upon activating the plugin. 
* To modify plugin settings:
    * Go to __Network Admin -> Create Site -> Options__ screen and click __Save Changes__.

## License
The WordPress Plugin Boilerplate is licensed under the GPL v2 or later.
> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

A copy of the license is included in the root of the plugin’s directory. The file is named `LICENSE`.

## Important Notes
* This plugin is compatible with caching and cdn enabled.
* The plugin stores information in the database in the form of serialized array, hence please do not modify it directly unless you are sure of the modification.

## Issues

Please log issues on the GitHub at https://github.com/neelakansha85/site-setup-wizard/issues

## ChangeLog

See [readme.txt](readme.txt).

