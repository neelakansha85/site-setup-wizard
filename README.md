# Wordpress Site Setup Wizard Plugin
Allows multiste registered users to create sites using pre selected features/settings in steps. This plugin can be used by placing a shortcode [site_setup_wizard] on any page. This plugin only works with subdomain multisite install.

* Tags: plugin, wordpress, site setup wizard, multisite site registration, site creation, wordpress 
* Requires at least: 3.9
* Requires PHP: 5.5
* Tested up to: 4.3
* Stable tag: master
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Features

* This plugin allows users to selection following settings before creating a site:
    * Site Privacy (Also includes WPMU Multisite Privacy settings if enabled).
    * Site Category (Allows users to select a pre-configured site category if required). (Ex: http://yourdomain.com/category1-mysite)
    * Plugins to be activated within the site (Works with WPMU Pretty Plugins including their categories if enabled).
* Super admins can configure banned site names to disallow users from creating specific sites.
* User's email address is displayedby default  on the page in addition to allowing them to enter another user from the system as an admin for the new site.
* Users are not allow to use hyphen "-" in a site name since it is used to differentiate between sites and their catgories. 
* If WPMU Pretty Plugins is not enabled, it will display all the plugins available for site admins to activate.
* It resumes from where user's left off on returning to the plugin page if they haven't completed all steps of the wizard.
* It sends a notification to the site admin's once the wizard is completed with the new link to their site.
* Super admins get analytics of sites created using the plugin including including if users did complete all steps of the wizard or not.

`GitHub Plugin URI: https://github.com/neelakansha85/nsd-site-setup-wizard`

## Installation

### Upload

1. Download the latest [tagged archive](https://github.com/neelakansha85/nsd-site-setup-wizard/releases) (choose the "zip" option).
2. Unzip the archive, rename the folder correctly to `nsd-site-setup-wizard`, then re-zip the file.
3. Go to the __Network Admin -> Plugins -> Add New__ screen and click the __Upload__ tab.
4. Upload the zipped archive directly.
5. Go to the Network Admin -> Plugins screen and click __Network Activate__ below __Site Setup Wizard__.

### Manual

1. Download the latest [tagged archive](https://github.com/neelakansha85/nsd-site-setup-wizard/releases) (choose the "zip" option).
2. Unzip the archive, rename the folder to `nsd-site-setup-wizard`.
3. Copy the folder to your `/wp-content/plugins/` directory.
4. Go to the __Network Admin -> Plugins__ screen and click __Network Activate__ below __Site Setup Wizard__.

Check out the Codex for more information about [installing plugins manually](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

# Usage
* Default plugin settings will be configured upon activating the plugin. 
* To modify plugin settings:
    * Modify required settings in `nsd-site-setup-wizard/admin/ssw_update_options.php`.
    * Go to __Network Admin -> Create Site -> Options__ screen and click __Update Plugin Settings__.

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

Please log issues on the GitHub at https://github.com/neelakansha85/nsd-site-setup-wizard/issues

## ChangeLog

See [CHANGES.md](CHANGES.md). In your project create a `CHANGES.md` or `CHANGELOG.md` file.

