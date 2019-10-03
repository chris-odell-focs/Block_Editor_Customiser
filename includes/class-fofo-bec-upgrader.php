<?php

namespace FoFoBec;

/**
 * Provide functions which are used for upgrading the plugin.
 * These will include functions for migrating data and changing
 * DTO class structures
 * 
 * @since   1.2.0
 */
class FoFo_Bec_Upgrader {

    /**
     * Migrate a version 1.0.0 theme to a 1.1.0 version of a theme
     * 
     * @param   \FoFoBec\FoFo_Bec_Theme     The verion 1.0.0 theme to migrate
     * 
     * @return  \FoFoBec\FoFo_Bec_Theme     The migrated version 1.1.0 of the theme
     * @since   1.2.0
     */
    public static function theme_v100_v110( $v100Theme ) {

        if( '1.0.0' === $v100Theme->version) {

            $converted = new \FoFoBec\FoFo_Bec_Theme();
            $converted->category_panel = $v100Theme->category_panel;
            $converted->tag_panel = $v100Theme->tag_panel;
            $converted->featured_image_panel = $v100Theme->featured_image_panel;
            $converted->excerpt_panel = $v100Theme->excerpt_panel;
            $converted->discussion_panel = $v100Theme->discussion_panel;
            $converted->permalink_panel = $v100Theme->permalink_panel;
            $converted->name = 'default';
            $converted->display_name = 'Default';
            $converted->version = '1.1.0';
            $converted->settings_page = 'settings';

            return $converted;
        }

        return $v100Theme;
    }
}