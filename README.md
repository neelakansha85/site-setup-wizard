# [Wordpress Site Setup Wizard Plugin](https://wordpress.org/plugins/site-setup-wizard)
![banner-772x250](https://cloud.githubusercontent.com/assets/6759546/16505621/e3d7bc98-3eeb-11e6-89d5-f5383a698e2e.png)

Site Setup Wizard plugin allows all your multisite registered users to be able to create new sites using many options such as their site type, category, address, theme, plugins they want to activate, privacy and many more in form of steps. It can be used by placing a shortcode [site_setup_wizard] on any page. Site category and addresses are separated using a hyphen (-). For example in [http://yourdomain.com/hr-benefits](#) **hr is a site category** while **benefits is site address**. This helps in organizing sites efficiently. 

You can also find [Site Setup Wizard](https://wordpress.org/plugins/site-setup-wizard) in [wordpress.org](https://wordpress.org/plugins/site-setup-wizard).

* Tags: wordpress plugin, site setup wizard, multisite, site registration, site creation, create site, wp-signup
* Requires at least: 4.0
* Requires PHP: 5.5
* Tested up to: 4.8
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
    * Hide specific Themes or Plugins from the Wizard Steps.
    * Allows super admins to perform additional checks if required before displaying all steps to a user. (Using [SSW Additional Checks](https://wordpress.org/plugins/ssw-additional-checks/)
    * Option to map wordpress user role with Site Setup Wizard user roles

`GitHub Plugin URI: https://github.com/neelakansha85/site-setup-wizard`

## Screenshots

![screenshot-1](https://cloud.githubusercontent.com/assets/6759546/16505626/e3db310c-3eeb-11e6-836a-53192e66a4b9.png)
![screenshot-2](https://cloud.githubusercontent.com/assets/6759546/16505625/e3d8e7da-3eeb-11e6-8a5e-7a589ff3e56d.png)
![screenshot-3](https://cloud.githubusercontent.com/assets/6759546/16505622/e3d8c106-3eeb-11e6-976e-e315051d9d68.png)
![screenshot-4](https://cloud.githubusercontent.com/assets/6759546/16505623/e3d8f0e0-3eeb-11e6-96be-660cb7c0cbc1.png)
![screenshot-5](https://cloud.githubusercontent.com/assets/6759546/16505624/e3d8f7a2-3eeb-11e6-8ead-758ff7a92e72.png)
![screenshot-6](https://cloud.githubusercontent.com/assets/6759546/16505629/e3df64b6-3eeb-11e6-83e6-17e5966d8a98.png)
![screenshot-7](https://cloud.githubusercontent.com/assets/6759546/16505630/e3e1e57e-3eeb-11e6-8151-db47d3849889.png)
![screenshot-8](https://cloud.githubusercontent.com/assets/6759546/16505631/e3e22566-3eeb-11e6-85ae-83dacd1b6b51.png)
![screenshot-9](https://cloud.githubusercontent.com/assets/6759546/16505627/e3ddbd32-3eeb-11e6-90d2-c841a668632f.png)
![screenshot-10](https://cloud.githubusercontent.com/assets/6759546/16505628/e3df0ec6-3eeb-11e6-840a-44a9b150f7f2.png)

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

