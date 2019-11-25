<?php

function fofo_bec_register_default_theme( $fofo_bec_register ) {

    $theme = $fofo_bec_register->get_new_theme();
    $theme->name = 'default';
    $theme->display_name = 'Default';
    $theme->settings_page = 'fofo_bec_default_theme_settings';
    $theme->css = '';
    $theme->my_location = dirname( __FILE__ ).'/fofo-bec-default-theme.php';

    $fofo_bec_register->register_theme( $theme );
}

add_action('fofo_bec_register_theme', 'fofo_bec_register_default_theme' );

function fofo_bec_default_theme_settings( $page_builder ) {
    
    $page = '<table class="form-table" style="width : 75%">
        <tbody>
            <tr> '.
                $page_builder->show_option( 'category_panel', '', '<th><label for="fofo-bec-category-panel">Category Panel</label></th><td>%s</td>', 'fofo-bec-category-panel' ).
                $page_builder->show_option( 'tag_panel', '', '<th><label for="fofo-bec-tag-panel">Tag Panel</label></th><td>%s</td>', 'fofo-bec-tag-panel' ).
            '</tr>
            <tr>'.
                $page_builder->show_option( 'featured_image_panel', '', '<th><label for="fofo-bec-featured-image-panel">Featured Image Panel</label></th><td>%s</td>', 'fofo-bec-featured-image-panel' ).
                $page_builder->show_option( 'excerpt_panel', '', '<th><label for="fofo-bec-excerpt-panel">Excerpt Panel</label></th><td>%s</td>', 'fofo-bec-excerpt-panel' ).
            '</tr>
            <tr>'.
                $page_builder->show_option( 'discussion_panel', '', '<th><label for="fofo-bec-discussion-panel">Discussion Panel</label></th><td>%s</td>', 'fofo-bec-discussion-panel' ).
                $page_builder->show_option( 'permalink_panel', '', '<th><label for="fofo-bec-permalink-panel">Permalink Panel</label></th><td>%s</td>', 'fofo-bec-permalink-panel' ).
            '</tr>
            <tr>'.
                $page_builder->show_option( 'top_toolbar', '', '<th><label for="fofo-bec-top-toolbar">Top Toolbar</label></th><td>%s</td>', 'fofo-bec-top-toolbar' ). 
                $page_builder->show_option( 'spotlight_mode', '', '<th><label for="fofo-bec-spotlight-mode">Spotlight Mode</label></th><td>%s</td>', 'fofo-bec-spotlight-mode' ).
            '</tr>
            <tr>'.
                $page_builder->show_option( 'fullscreen', '', '<th><label for="fofo-bec-fullscreen">Fullscreen</label></th><td>%s</td>', 'fofo-bec-fullscreen' ).
                $page_builder->show_option( 'edit_post_more_menu', '', '<th><label for="fofo-bec-edit-post-more-menu">\'Show more tools\' option</label></th><td>%s</td>', 'fofo-bec-edit-post-more-menu' ).
            '</tr>
        </tbody>
    </table>';

    return $page;
}
