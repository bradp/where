=== Where ===
Contributors: bradparbs
Tags: admin, profile, environment, development-tools, dev-tools
Requires at least: 6.0
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin to display your site's environment type in the admin bar.

== Description ==

Display your WordPress site's environment type in the admin bar.

== Available Filters ==

'where_env_should_add_env_type' - Defaults to true if the user is an admin and the admin bar is showing. Filter this to allow different roles to view as well.
'where_env_environment_type' - Modify the environment type. You'll also need to use this filter if you're running an older version of WP that doesn't have the 'get_environment_type' function.
'where_env_styles' - An array of colors/icons to use for the different environment types.

== Changelog ==

= 1.0.2 =

* Escaped the environment name and cleaned up code.
* Requires WordPress 6.0 and PHP 7.4, tested up to WordPress 7.1.
