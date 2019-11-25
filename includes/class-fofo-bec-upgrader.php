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

    /**
     * Migrate a version 1.0.0 theme to a 1.1.0 version of a theme
     * 
     * @param   \FoFoBec\FoFo_Bec_Theme     The verion 1.0.0 theme to migrate
     * 
     * @return  \FoFoBec\FoFo_Bec_Theme     The migrated version 1.1.0 of the theme
     * @since   1.3.0
     */
    public static function theme_v110_v120( $v110Theme ) {

        if( '1.1.0' === $v110Theme->version) {

            $converted = new \FoFoBec\FoFo_Bec_Theme();
            $converted->category_panel = $v110Theme->category_panel;
            $converted->tag_panel = $v110Theme->tag_panel;
            $converted->featured_image_panel = $v110Theme->featured_image_panel;
            $converted->excerpt_panel = $v110Theme->excerpt_panel;
            $converted->discussion_panel = $v110Theme->discussion_panel;
            $converted->permalink_panel = $v110Theme->permalink_panel;
            $converted->name = $v110Theme->name;
            $converted->display_name = $v110Theme->display_name;
            $converted->version = '1.2.0';
            $converted->settings_page = $v110Theme->settings_page;
            
            return $converted;
        }

        return $v110Theme;
    }

    /**
     * Migrate a theme to version 1.3.0
     * 
     * @param   \FoFoBec\FoFo_Bec_Theme     The theme
     * 
     * @return  \FoFoBec\FoFo_Bec_Theme     The migrated version 1.3.0 of the theme
     * @since   1.5.0
     */
    public static function theme_to_v130( $theme ) {

        $theme = self::theme_v100_v110( $theme );
        $theme = self::theme_v110_v120( $theme );

        if( '1.2.0' === $theme->version) {

            $converted = new \FoFoBec\FoFo_Bec_Theme();
            $converted->category_panel = $theme->category_panel;
            $converted->tag_panel = $theme->tag_panel;
            $converted->featured_image_panel = $theme->featured_image_panel;
            $converted->excerpt_panel = $theme->excerpt_panel;
            $converted->discussion_panel = $theme->discussion_panel;
            $converted->permalink_panel = $theme->permalink_panel;
            $converted->name = $theme->name;
            $converted->display_name = $theme->display_name;
            $converted->version = '1.3.0';
            $converted->settings_page = $theme->settings_page;

            return $converted;
        }

        return $theme;
    }
}