# Change log
All notable changes to this project will be documented in this file.

## [0.5.1] - 2021-4-18
### Bugfix
- fix bug where Router outputs an issue when display_errors / wp_debug is on.

## [0.5.0] - 2021-04-15
#### Added
 - Shortcode registration
 - Added response file
 - Added Ajax handler inside `Web::class`
 
#### Changed
- Rename AJAX files and folders to API 

## [0.4.0] - 2021-03-16
#### Added
 - Router support for woocommerce tabs
 - Router support for woocommerce settings
 - Registration of Web API

## [0.2.0] - 2021-02-14
#### Added
 - Packages / Library manager 
 - Bootstrap folder
 - Rest API registration
 - Add Service Providers
 
#### Changed
 - Transferred templates and assets files to a resource folder instead.
 - Changed the name of the template folder from Template to views.
 - Transferred Controller folder to http