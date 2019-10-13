=== Foxdell Folio Block Editor Customiser ===
Contributors: chrisodell
Donate link: https://ko-fi.com/chrisodell
Tags: gutenberg, block-editor, customize
Requires at least: 5.1
Tested up to: 5.2.3
Stable tag: 1.0.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Customise you Block Editor experience, or customise the experience on client sites.

== Description ==

After the plugin has been installed features of the Block Editor can be turned off and on using the settings page
or the two hooks provided which can be called with do_action.

The plugin also allows customisation of the look and feel of the Block Editor through the selection of themes. Themes bundled with the
plugin are the Default theme, which has the same look and feel as the base Block Editor, and the VS Light theme which emulates the Light theme 
in VS Code.

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