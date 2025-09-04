<?php

/**
 * This file customize the default AMP template in classic mode
 */

/**
 * Add styles to amp template
 * 
 */
add_action(
    'amp_post_template_head', 
    function( $amp_template ) {
        /**
         * Compile css version with no hash, we don't need a hash here, this style is added inline.
         * Amp plugin print the stylesheet inline to comply with amp
         * 
         * amp.css is a compile version same as app.css but without common/global, 
         * which has an @import and creates the next error because of the @import
         *
         * [error] 
         * wp_enqueue_style was called incorrectly. 
         * It is not a best practice to use @import to load font CDN stylesheets. 
         * Please use wp_enqueue_style() to enqueue Noto Sans font as its own separate script. 
         * 
         */
        echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/public/styles/amp.css">';

        /**
         * Noto Sans is already in the plugin as a default font
         * /amp/src/Admin/GoogleFonts.php:62
         * 
         */
        // echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans:ital,wght@0,400;0,700;1,400&display=swap)">';
    }
);

/**
 * Canonical link tag and verification tag
 */
add_action(
    'amp_post_template_head', 
    function( $amp_template ) {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $amp_end = substr($actual_link, -1);

        $canonical_link = '';

        if ($amp_end === '/') {
            $canonical_link = str_replace('/amp/', '/', $actual_link);
        }

        if ($amp_end !== '/') {
            $canonical_link = str_replace('/amp', '/', $actual_link);
        }

        echo '<link rel="canonical" href="'.$canonical_link.'">';

        if ($_SERVER['HTTP_HOST'] === 'www.networkrail.co.uk') {
            echo '<meta name="google-site-verification" content="fWIlW0o7ZsWQi5QFF0YQarpNY8aOws1wZ9842zHu-oE" />';
        }
    }
);

/**
 * Custom Template
 */
add_filter( 
    'amp_post_template_file', 
    function( $file, $type, $post ) {
        if ( 'single' === $type ) {
            $file = dirname( __FILE__ ) . '/templates/my-amp-template-with-tailwind.php';
        }

        return $file;
    }, 
    10, 
    3 
);

