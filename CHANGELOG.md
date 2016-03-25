# Change Log
All notable changes to this project will be documented in this file.

## [1.2.4](https://github.com/neelakansha85/nsd-site-setup-wizard/releases/tag/v1.2)
### Added
- Allowing users to change/save options for Site Setup Wizard Plugin
- Renamed site_usage to site_type in wp_ssw_main_nsd table and other places as as required.

## [1.2.3](https://github.com/neelakansha85/nsd-site-setup-wizard/releases/tag/v1.2.3) - 2016-03-22
### Added
- Options Page to view all options for Site Setup Wizard
- Added new options to configure in Options Page
- Removed from template_type field from wp_ssw_main_nsd table

### Fixed
- [Issue #12](https://github.com/neelakansha85/nsd-site-setup-wizard/issues/12) Restricting users from creating sites with names as site categories
- [Issue #1](https://github.com/neelakansha85/nsd-site-setup-wizard/issues/1)
- PHP Warnings and Notices that used to appear when running this plugin. 

## [1.2.2](https://github.com/neelakansha85/nsd-site-setup-wizard/releases/tag/v1.2.2) - 2015-11-18
### Added
- A Readme.md file for documentation
- This CHANGELOG file.
- Debug functionality to plugin where it logs all plugin data to wp-content/uploads/**nsd_ssw_sql_log.log** if **debug_mode** is set true.
- Update Options button on Options page of Site Setup Wizard to modify plugin settings.

### Changed
- custom.js to ssw-main.js and variables associated with it for identifying it easily while degubbing.

### Fixed
- [Issue #3](https://github.com/neelakansha85/nsd-site-setup-wizard/issues/3) conflicting with Activity Log Plugin.
- [Issue #2](https://github.com/neelakansha85/nsd-site-setup-wizard/issues/2) related to Quick Draft and Permalinks not working.

## [1.2.0](https://github.com/neelakansha85/nsd-site-setup-wizard/releases/tag/v1.2) - 2015-09-01
### Added
- Initialized this plugin with proper documentation and structure for release.