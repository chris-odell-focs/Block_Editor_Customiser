chris-odell-focs/Block_Editor_Feature_Toggler
========================================

A plugin for turning Block Editor Features on and off.

Quick links: [Using](#using) | [Installing](#installing) | [Donating](#donating) | [Contributing](#contributing) | [Support](#support)

## Using

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
 
### Examples

do_action( 'fofo_bec_feature_off', 'category_panel' ); //this turns the category panel in the sidebar off.

do_action( 'fofo_bec_feature_on', 'category_panel' ); //this turns the category panel in the sidebar on, if it has been turned off.

## Installing

1. To install Foxdell Folio Gutenberg(Block Editor) feature toggler download the zip file from here.
2. Unzip the file into the plugins folder of your WordPress installation.
3. Goto the plugin manager page of your WordPress dashboard and activate the plugin.

## Donating

If the Block Editor feature toggler helps you in your daily work then please consider donating as it helps to
fund further development.

Donations can be made via my [Ko-Fi button](https://ko-fi.com/chrisodell).

## Contributing

We appreciate you taking the initiative to contribute to this project.

Contributing isn’t limited to just code. We encourage you to contribute in the way that best fits your abilities, by writing tutorials, giving a demo at your local meetup, helping other users with their support questions, or revising our documentation.


### Reporting a bug

Think you’ve found a bug? We’d love for you to help us get it fixed.

Before you create a new issue, you should [search existing issues](https://github.com/chris-odell-focs/Block_Editor_Feature_Toggler/issues) to see if there’s an existing resolution to it, or if it’s already been fixed in a newer version.

Once you’ve done a bit of searching and discovered there isn’t an open or fixed issue for your bug, please [create a new issue](https://github.com/chris-odell-focs/Block_Editor_Feature_Toggler/issues/new). Include as much detail as you can, and clear steps to reproduce if possible.

### Creating a pull request

Want to contribute a new feature? Please first [open a new issue](https://github.com/chris-odell-focs/Block_Editor_Feature_Toggler/issues/new) to discuss whether the feature is a good fit for the project.
