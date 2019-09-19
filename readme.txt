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

= 1.0 =
* First commit

== Upgrade Notice ==

Customise your Block Editor experience

== FAQ ==

Q. What features can I disbale?
A. At the moment the only features that can be disabled are those listed at the top of this page.