=== Foxdell Folio Block Editor Customiser ===
Contributors: chrisodell
Donate link: https://ko-fi.com/chrisodell
Tags: gutenberg, block-editor, customize
Requires at least: 5.1
Tested up to: 5.2.3
Stable tag: 1.5.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Customise you Block Editor experience, or customise the experience on client sites.

== Description ==

After the plugin has been installed features of the Block Editor can be turned off and on using the settings page
or the two hooks provided which can be called with do_action.

The plugin also allows customisation of the look and feel of the Block Editor through the selection of themes. Themes bundled with the
plugin are the Default theme, which has the same look and feel as the base Block Editor, and the VS Light theme which emulates the Light theme in VS Code.

The two hooks are:-

'fofo_bec_feature_on' to turn features on and
'fofo_bec_feature_off' to turn features off.

Currently supported features are :- 

 *  The 'Category Panel' on the settings sidebar [use feature name 'category_panel']
 *  The 'Tag Panel' on the settings sidebar [use feature name 'tag_panel']
 *  The 'Featured Image Panel' on the settings sidebar [use feature name 'featured_image_panel']
 *  The 'Excerpt Panel' on the settings sidebar [use feature name 'excerpt_panel']
 *  The 'Discussion Panel' on the settings sidebar [use feature name 'discussion_panel']
 *  The 'Permalink Panel' on the settings sidebar [use feature name 'permalink_panel']
 *  The 'Top Toolbar' option can be toggled on/off [use feature name 'top_toolbar']
 *  The 'Spotlight Mode' can be toggled on/off [use feature name 'spotlight_mode']
 *  The 'Fullscreen mode' can be toggled on/off  [use feature name 'fullscreen']
 *  The 'Show more tools and options' button can be turned off [use feature name 'edit_post_more_menu']
 
=== Examples ===

`do_action( 'fofo_bec_feature_off', 'category_panel' ); //this turns the category panel in the sidebar off.`

`do_action( 'fofo_bec_feature_on', 'category_panel' ); //this turns the category panel in the sidebar on, if it has been turned off.`

== Installation ==

This plugin can be installed directly from your site.

* Log in and navigate to Plugins → Add New.
* Type “Foxdell Folio Block Editor Customiser” into the Search and hit Enter.
* Locate the Foxdell Folio Block Editor Customiser plugin in the list of search results and click Install Now.
* Once installed, click the Activate link.

It can also be installed manually.

* Download the Foxdell Folio Block Editor Customiser plugin from WordPress.org
* Unzip the package and move to your plugins directory.
* Log into WordPress and navigate to the Plugins screen.
* Locate Foxdell Folio Block Editor Customiser in the list and click the Activate link.

== Screenshots ==

1. The FoFo Block Customiser screen (1.png).

== Changelog ==

= 1.5.0 =

* ** BREAKING CHANGE ** Themes are no longer added in their own folder below this plugin but now need to be added as a plugin in their own right.
* Removed the VS Light theme folder and contents.
* Changed definition for addon to extenstion to better reflect conceptual level model. The definitions changed are :- FOFO_BEC_ADDON_VERSION_KEY, 
    FOFO_BEC_ADDON_NAME_KEY and FOFO_BEC_ADDON_DESCRIPTION_KEY.
* Modified addon definitions in class 'FoFo_Bec_Shared' in file class-fofo-bec-shared.php (as above).
* Updated definitions in class 'FoFo_Bec_Addon_Registry' in file class-fofo-bec-addon-registry.php.
* Updated definitions in class 'FoFo_Bec_Addon' in file class-fofo-bec-addon.php.
* Modified function 'get_current_theme' in class 'FoFo_Bec_Dal' in file class-fofo-bec-dal so that the default theme is no longer defined.
* Modified function 'get_registered_themes' in class 'FoFo_Bec_Dal' to return null vs returning an empty array.
* Updated definitions in class 'FoFo_Bec_Extension_Manager' in file class-fofof-bec-extension-manager.php.
* Changed constructor of class 'FoFo_Bec_Extension_Manager' to inject a theme registry instance.
* Added the 'scan_for_themes' function to the class 'FoFo_Bec_Extension_Manager'.
* Modified the 'get_theme_selector' function in class 'FoFo_Bec_Page_Composer' in file class-fofo-bec-page-composer.php to return current theme using theme registry.
* Added 'ensure_theme_version' function to class 'FoFo_Bec_Theme_Registry' in file class-fofo-bec-theme-registry.php to ensure theme object is latest version.
* Modified the 'register_theme' function in class 'FoFo_Bec_Theme_Registry' to call ensure_theme_version.
* Removed the 'scan_for_themes' function from class 'FoFo_Bec_Theme_Registry'.
* Removed the 'includes_existing_register_function' function from class 'FoFo_Bec_Theme_Registry'.
* Removed the 'update_registered_themes' function from class 'FoFo_Bec_Theme_Registry'.
* Added the 'commit_registered_theme_changes' function to class 'FoFo_Bec_Theme_Registry'.
* Modified the 'theme_exists' function in class 'FoFo_Bec_Theme_Registry' to check if the theme registry is null.
* Modified the 'get_current_theme' function in class 'FoFo_Bec_Theme_Registry' to update the current theme to the correct version and set the default theme as current as required.
* Modified the 'set_current_theme' function in class 'FoFo_Bec_Theme_Registry' to update the current theme to the correct version.
* Added the 'list_themes' function to class 'FoFo_Bec_Theme_Registry'.
* Added the 'clear_themes' function to class 'FoFo_Bec_Theme_Registry'.
* Added the 'ensure_theme_version' function to class 'FoFo_Bec_Theme_Registry'.
* Added the 'ensure_have_theme' function to class 'FoFo_Bec_Theme_Registry' to return the default theme if the theme being checked is empty.
* Modified function 'to_ui' in class 'FoFo_Bec_Theme_Transform' in file class-fofo-bec-theme-transform.php to use callable defined in theme for settings page render.
* Modified the version number in class 'FoFo_Bec_Theme' in file class-fofo-bec-theme.php.
* Added the new property 'my_location' to class 'FoFo_Bec_Theme'.
* Fixed typo in function 'theme_v110_v120' in class 'FoFo_Bec_Upgrader' in file class-fofo-bec-upgrader.php.
* Added function 'theme_to_v130' in class 'FoFo_Bec_Upgrader'.
* Modified the 'attach' function in class 'FoFo_Bec' in file class-fofo-bec.php to use the extension manager.
* Modified the 'load_scripts' function in class 'FoFo_Bec' to use the full css url supplied by a theme vs the location in the theme sub folder.
* Added the default theme file fofo-bec-default-theme.php. 
 
= 1.4.0 =

* Added the 'Disable Core Blocks' addon
* Added the FoFo_Bec_Addon_Registry in class-fofo-bec-addon-registry.php file.
* Added the FoFo_Bec_Addon in class-fofo-bec-addon.php.
* Modified the JS template in the class-fofo-bec-cuustomiser.php file to be more 'pluggable'.
* Added a 'compose_js' function in the class-fofo-bec-cuustomiser.php file to enabled hooking into the JS template.
* Modified the 'get_javascript' function in the class-fofo-bec-cuustomiser.php file to call the 'compose_js' function.
* Added the 'get_addons' and 'set_addons' to the FoFo_Bec_Dal class in the class-fofo-bec-dal.php file.
* Added the 'FoFo_Bec_Extension_Manager' in the class-fofo-bec-extension-manager.php file to manage extension activation & deactivation.
* Modified the contructor in class 'FoFo_Bec_Page_Composer' in the file class-fofo-bec-composer.php to take dependencies as an array.
* Addded a dependency on the Addon registry to the 'FoFo_Bec_Page_Composer' class.
* Modified the function 'build_page' in the 'FoFo_Bec_Page_Composer' class to just display the current theme settings.
* Added the 'build_theme_page' function to the 'FoFo_Bec_Page_Composer' class to display the theme selector.
* Added the 'build_addon_page' function to the 'FoFo_Bec_Page_Composer' class to display the list of available addons & allow addon activitation/deactivation.
* Moved the defines for 'FOFO_BEC_JS_KEY' and 'FOFO_BEC_REQUEST_KEY' to the 'define_general' in the 'FoFo_Bec_Shared' in file class-fofo-bec-shared.php.
* Added two new methods 'defines_for_themes' and 'defines_for_addons' to the 'FoFo_Bec_Shared' class.
* Added defines for addon management to the 'FoFo_Bec_Shared' class.
* Added defines for addon hooks as part of addon integration in the 'FoFo_Bec_Shared' class.
* Added check to see if theme already exists when registering a theme in class 'FoFo_Bec_Theme_Registry' in file class-fofo-bec-theme-registry.php.
* Added member level variable to cache theme data in 'FoFo_Bec_Theme_Registry' to prevent multiple database hits.
* Modified functon 'scan_for_themes' in 'FoFo_Bec_Theme_Registry' to call new function 'update_registered_themes'.
* Added function 'update_registered_themes' in 'FoFo_Bec_Theme_Registry' to merge changes from the theme cache and updated theme before saving.
* Modified function 'theme_exists' in 'FoFo_Bec_Theme_Registry' to get the theme from the internal theme cache.
* Modified function 'get_theme' in 'FoFo_Bec_Theme_Registry' to use the internal theme cache.
* Modified function 'set_current_theme' in 'FoFo_Bec_Theme_Registry' to save the theme changes correctly.
* Added the function 'get_theme_cache' to the 'FoFo_Bec_Theme_Registry' class.
* Fixed comments in file class-fofo-bec-theme.php.
* Added the addon registry to the core 'FoFo_Bec' class in the file class-fofo-bec.php.
* Added creaton of an addon registry instance in function 'attach' of class 'FoFo_Bec'.
* Modified the 'load_scripts' function in class 'FoFo_Bec' to load scripts for addon management.
* Modified function 'add_plugin_page' in class 'FoFo_Bec' so that themes and addons can now be managed from their own pages.
* Modified function 'show_page' in class 'FoFo_Bec' so that the core plugin page just shows settings for the current theme.
* Added a 'show_addon_page' function to class 'FoFo_Bec' to display and manage available addons.
* Added a 'show_theme_page' function to class 'FoFo_Bec' to display and manage available themes.
* Added the hook 'FOFO_BEC_ADDON_APPLY_CHANGES' in class 'FoFo_Bec' to cascade changes made by an addon.
* Added a 'toggle_addon' function to class 'FoFo_Bec' to enable/disable an addon(called via ajax).
* Added a 'apply_addon_updates' function to class 'FoFo_Bec' to cascade JS changes from addons.
* Fix issue with theme not loading on 'edit page' as well as 'edit post'.

= 1.3.0 =
* Removed the 'fofobec_get_removeEditorPanel' javascript function from the template in class-fofo-bec-customiser.php.
* Removed the 'fofobec_run_dispatcher' javascript function from the template in class-fofo-bec-customiser.php.
* Added higher order components from controlling the options in javascript function from the template in class-fofo-bec-customiser.php.
* Remove serialisation of theme in 'set_current_theme' and 'get_current_theme' in class-fofo-bec-dal.php.
* Remove 'get_selected_theme_name' and 'set_selected_theme_name' from class-fofo-bec-dal.php.
* Added html generator functions for new options in class-fofo-bec-page-builder.php.
* Renamed 'get_document_panel_html' to 'get_toggle_value_html' in class-fofo-bec-page-builder.php.
* Modified method 'get_theme_selector' in class-fofo-bec-page-composer.php to return all registered themes in the dropdown.
* Modified method 'set_current_theme' in class-fofo-bec-page-composer.php to use registry methods to check a theme exists and to persist the current theme.
* Added define FOFO_BEC_THEME_REPO_URL in class-fofo-bec-shared.php.
* Changed define FOFO_BEC_FEATURE_DOC_PANEL_PEMALINK to FOFO_BEC_FEATURE_DOC_PANEL_PERMALINK in class-fofo-bec-shared.php.
* Modified method 'scan_for_themes' in class-fofo-bec-theme-registry.php to check if a theme 'init.php' register theme callable already exists.
* Added a new function , 'includes_existing_register_function' to class-fofo-bec-theme-registry.php.
* Added the 'get_theme' function to class-fofo-bec-theme-registry.php.
* Added the function 'get_current_theme' to class-fofo-bec-theme-registry.php.
* Added the function 'set_current_theme' to class-fofo-bec-theme-registry.php.
* Changed the function name 'set_panel_state' to 'set_feature_state' in class-fofo-bec-theme-transform.php.
* Added new options 'top_toolbar', 'spotlight_mode', 'fullscreen', 'edit_post_more_menu', 'css' to class-fofo-bec-theme.php.
* Update 'version' from '1.1.0' to '1.2.0'.
* Added the function 'theme_v110_v120' to class-fofo-bec-upgrader.php.
* Modified the 'attach' function in class-fofo-bec.php to use the registry functions to get the current theme.
* Modified the 'attach' function in class-fofo-bec.php to upgrade a theme from v1.1.0 to v1.2.0.
* Modified the 'convert_to_theme' function to use the registry functions to set the current theme in class-fofo-bec.php.
* Added 'jquery', 'wp-editor' as dependencies to 'wp_register_script' in the 'load_scripts' in class-fofo-bec.php.
* Modified the function 'load_scripts' in class-fofo-bec.php to load the current theme style sheet.
* Modified the function 'toggle_feature' in class-fofo-bec.php to use the 'set_current_theme' registry function.
* Modified the function 'apply_ui_updates' in class-fofo-bec.php to use the 'set_current_theme' registry function.
* Added the function 'fofobecCoreEditPostStore' to fofobec.js.
* Added the 'fofo_bec_dom' higher order function to fofobec.js.
* Added the 'fofobec_run_dispatcher' function to fofobec.js.
* Updated the version number in fofo-block-editor-customiser.php.
* Created the light_vs theme.

= 1.2.0 =
* Refactored code for better decoupling.
* Added the theme selector to the settings page.
* Created a default theme.

= 1.1.0 =
* Added code to allow the management of customisation options as a theme.

= 1.0 =
* First commit

== Upgrade Notice ==

Customise your Block Editor experience

== FAQ ==

Q. What features can I disbale?
A. At the moment the only features that can be disabled are those listed at the top of this page.