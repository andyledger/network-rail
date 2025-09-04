<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\asset;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action(
    'wp_enqueue_scripts',
    function () {
        wp_enqueue_script(
            'sage/app.js',
            asset('scripts/app.js')->uri(),
            '',
            null,
            true
        );

        if (!is_front_page()) {
            // find the way to added only if wistia block is present
            wp_enqueue_script(
                'wistia-api-defer',
                'https://fast.wistia.com/assets/external/E-v1.js',
                [],
                '',
                true
            );
        }

        // not sure what is doing this. Check it.
        wp_add_inline_script(
            'sage/vendor.js',
            asset('scripts/manifest.js')->contents(),
            'before'
        );

        wp_enqueue_style(
            'sage/app.css',
            asset('styles/app.css')->uri(),
            false,
            null
        );

        /**
         * Css to apply a gryscale over the entire HTML
         */
        if (get_field('is_greyscale', 'option')) {
            echo '<style>html {-moz-filter: grayscale(100%);-webkit-filter: grayscale(100%);filter: gray; /* IE6-9 */filter: grayscale(100%);}</style>';
        }

        wp_deregister_style('classic-theme-styles');
        wp_dequeue_style('classic-theme-styles');
    },
    100
);

/**
 * Register the theme assets with the block editor.
 * Do we need this?
 * scripts/manifest.asset.php is not generated and creating
 * an error
 *
 * @return void
 */
add_action(
    'enqueue_block_editor_assets',
    function () {
        wp_enqueue_script(
            'sage/app.js',
            asset('scripts/app.js')->uri(),
            '',
            null,
            true
        );

        wp_enqueue_style(
            'sage/editor.css',
            asset('styles/editor.css')->uri(),
            false,
            null
        );
    },
    100
);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action(
    'after_setup_theme',
    function () {
        /**
         * Enable features from the Soil plugin if activated.
         *
         * @link https://roots.io/plugins/soil/
         */
        add_theme_support(
            'soil',
            [
                'clean-up',
                'nav-walker',
                'nice-search',
                'relative-urls'
            ]
        );

        /**
         * Register the navigation menus.
         *
         * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
         */
        register_nav_menus(
            [
                'primary_navigation' => __('Primary Navigation', 'sage')
            ]
        );

        /**
         * Register the editor color palette.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
         */
        add_theme_support('editor-color-palette', []);

        /**
         * Register the editor color gradient presets.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-gradient-presets
         */
        add_theme_support('editor-gradient-presets', []);

        /**
         * Register the editor font sizes.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-font-sizes
         */
        add_theme_support('editor-font-sizes', []);

        /**
         * Register relative length units in the editor.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#support-custom-units
         */
        add_theme_support('custom-units');

        /**
         * Enable support for custom line heights in the editor.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#supporting-custom-line-heights
         */
        add_theme_support('custom-line-height');

        /**
         * Enable support for custom block spacing control in the editor.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#spacing-control
         */
        add_theme_support('custom-spacing');

        /**
         * Disable custom colors in the editor.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
         */
        add_theme_support('disable-custom-colors');

        /**
         * Disable custom color gradients in the editor.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-gradients
         */
        add_theme_support('disable-custom-gradients');

        /**
         * Disable custom font sizes in the editor.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-font-sizes
         */
        add_theme_support(
            'editor-font-sizes',
            [
                [
                    'name' => esc_attr__('Small', 'themeLangDomain'),
                    'size' => 14,
                    'slug' => 'small'
                ],
                [
                    'name' => esc_attr__('Regular', 'themeLangDomain'),
                    'size' => 15.75,
                    'slug' => 'regular'
                ],
                [
                    'name' => esc_attr__('Medium', 'themeLangDomain'),
                    'size' => 21,
                    'slug' => 'medium'
                ],
                [
                    'name' => esc_attr__('Large', 'themeLangDomain'),
                    'size' => 26.25,
                    'slug' => 'large'
                ],
                [
                    'name' => esc_attr__('Huge', 'themeLangDomain'),
                    'size' => 31.5,
                    'slug' => 'huge'
                ]
            ]
        );

        /**
         * Disable the default block patterns.
         *
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
         */
        remove_theme_support('core-block-patterns');

        /**
         * Enable plugins to manage the document title.
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
         */
        add_theme_support('title-tag');

        /**
         * Enable post thumbnail support.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        /**
         * Enable wide alignment support.
         *
         * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment
         */
        add_theme_support('align-wide');

        /**
         * Enable responsive embed support.
         *
         * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
         */
        add_theme_support('responsive-embeds');

        /**
         * Enable HTML5 markup support.
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
         */
        add_theme_support(
            'html5',
            [
                'caption',
                'comment-form',
                'comment-list',
                'gallery',
                'search-form',
                'script',
                'style'
            ]
        );

        /**
         * Enable selective refresh for widgets in customizer.
         *
         * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
         */
        add_theme_support('customize-selective-refresh-widgets');
    },
    20
);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action(
    'widgets_init',
    function () {
        register_sidebar(
            [
                'name' => __('Primary', 'sage'),
                'id' => 'sidebar-primary',
                'before_widget' => '<div class="tw-mb-4 tw-text-lg">',
                'after_widget' => '</div>'
            ]
        );

        register_sidebar(
            [
                'name' => __('Footer', 'sage'),
                'id' => 'sidebar-footer'
            ]
        );
    }
);

/**
 *  Create an options pages
 */
if (function_exists('acf_add_options_page')) {
    // Main option page
    acf_add_options_page(
        [
            'page_title'    => 'Theme General Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'manage_options_nr',
            'redirect'      => false
        ]
    );

    acf_add_options_sub_page(
        [
            'page_title'    => 'Theme Footer Settings',
            'menu_title'    => 'Footer',
            'menu_slug'     => 'acf-options-footer',
            'parent_slug'   => 'theme-general-settings',
            'capability'    => 'manage_options_nr'
        ]
    );

    /**
     * Only for the alert notification modal, which has a different
     * capability for add it to the media_editor role
     */
    acf_add_options_sub_page(
        [
            'page_title'    => 'Alert Notification',
            'menu_title'    => 'Alert Notification',
            'menu_slug'     => 'acf-options-alert-notification',
            'parent_slug'   => 'theme-general-settings',
            'capability'    => 'manage_alert_message'
        ]
    );
}

/**
 * Add excerpt and remove comments
 */
add_action(
    'init',
    function () {
        /**
         * Add excerpt to pages
         */
        add_post_type_support('page', 'excerpt');

        /**
         * Remove comments and discussion
         */
        remove_post_type_support('post', 'comments');
        remove_post_type_support('page', 'comments');

        add_image_size('story_large', 1300, 800, true);
        add_image_size('story_small', 620, 384, true);
    },
    100
);

/**
 * Deactivate new block editor to avoid error on widgets page.
 *
 * Error wp_enqueue_script() was called incorrectly. "wp-editor" script should
 * not be enqueued together with the new widgets editor (wp-edit-widgets or
 * wp-customize-widgets).
 * (This message was added in version 5.8.0.)
 */
add_action(
    'after_setup_theme',
    function () {
        remove_theme_support('widgets-block-editor');
    }
);

/**
 * Add meta box to File list custom post type
 */
add_action(
    'add_meta_boxes_downloads_list',
    function ($post) {
        add_meta_box(
            'my-meta-box',
            __('This File list is being displayed at:'),
            function () {
                echo(View\Composers\App::get_file_lists_from_db());
            },
            'downloads_list',
            'normal',
            'default'
        );
    }
);


/**
 * Add meta box to Attachment page
 */
add_action(
    'add_meta_boxes_attachment',
    function ($post) {
        add_meta_box(
            'my-meta-box-2',
            __('This image is being displayed at:'),
            function () {
                echo(View\Composers\App::get_media_from_db());
            },
            'attachment',
            'side',
            'low'
        );
    }
);


/**
 * Disable RSS feed - using a single function doesn't work correctly, not sure why!
 */

add_action('do_feed', function () {
    wp_die(__( 'No feed available.' ), 'No feed available', 404 );
}, 1);

add_action('do_feed_rdf', function () {
    wp_die(__( 'No feed available.' ), 'No feed available', 404 );
}, 1);

add_action('do_feed_rss', function () {
    wp_die(__( 'No feed available.' ), 'No feed available', 404 );
}, 1);

add_action('do_feed_rss2', function () {
    wp_die(__( 'No feed available.' ), 'No feed available', 404 );
}, 1);

add_action('do_feed_atom', function () {
    wp_die(__( 'No feed available.' ), 'No feed available', 404 );
}, 1);

add_action('do_feed_rss2_comments', function () {
    wp_die(__( 'No feed available.' ), 'No feed available', 404 );
}, 1);

add_action('do_feed_atom_comments', function () {
    wp_die(__( 'No feed available.' ), 'No feed available', 404 );
}, 1);

add_action('wp_head', function () {
    remove_action( 'wp_head', 'feed_links', 2 );
    remove_action( 'wp_head', 'feed_links_extra', 3 );
}, 1);

if (function_exists('amp_is_request')) {
    add_action('template_redirect', function () {
        if (amp_is_request()) {
            $url = trailingslashit(home_url(amp_remove_paired_endpoint($GLOBALS['wp']->request)));
            wp_redirect($url, 301);
            exit();
        }

        if (!amp_is_request()) {
            remove_action( 'wp_head', 'amp_add_amphtml_link' );
        }
    });
}
