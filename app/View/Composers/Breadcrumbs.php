<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Breadcrumbs extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.breadcrumbs'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'breadcrumbs' => $this->breadcrumbs()
        ];
    }

    /**
     * Cronstruc breadcrumb
     *
     * @return Array breadcrumbs items
     */
    public function breadcrumbs()
    {
        $id = get_the_id();

        if (empty($id)) {
            $id = isset($GLOBALS['post']) ? $GLOBALS['post']->ID : '';
        }

        // Settings
        $home_title = 'Home';

        // If you have any custom post types with custom taxonomies,
        // put the taxonomy name below (e.g. custom_tax).
        $custom_taxonomy = '';

        // Get the query & post information
        global $post, $wp_query;

        $breadcrumbs = [];

        // Home page
        $breadcrumbs[] = [
            'link' => get_home_url(),
            'title' => $home_title
        ];

        if (is_home()) {
            $breadcrumbs[] = [
                'title' => get_the_title(get_option('page_for_posts', true))
            ];

            return $breadcrumbs;
        }

        if (is_archive() && !is_tax() && !is_category() && !is_tag()) {
            $breadcrumbs[] = [
                'title' => post_type_archive_title('', false)
            ];

            return $breadcrumbs;
        }

        if (is_archive() && is_tax('story_category')) {

            $breadcrumbs[] = [
                'link' => get_home_url() . '/stories',
                'title' => 'Stories'
            ];

            $custom_tax_name = get_queried_object()->name;

            $breadcrumbs[] = [
                'title' => $custom_tax_name
            ];

            return $breadcrumbs;
        }

        $post_type = get_post_type();

        if (is_archive() && is_tax() && !is_category() && !is_tag() && get_the_title() !== 'Stories') {
            // If post is a custom post type


            // If it is a custom post type display name and link
            if ($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                $breadcrumbs[] = [
                    'link' => $post_type_archive,
                    'title' => $post_type_object->labels->name
                ];
            }

            $custom_tax_name = get_queried_object()->name;

            $breadcrumbs[] = [
                'title' => $custom_tax_name
            ];

            return $breadcrumbs;
        }


        if (is_singular() && $post_type === 'post') {

            $breadcrumbs[] = [
                'link' => get_home_url() . '/stories',
                'title' => 'Stories'
            ];

            $breadcrumbs[] = [
                'title' => get_the_title($id)
            ];

            return $breadcrumbs;
        }

        if (is_single()) {

            $breadcrumbs[] = [
                'title' => get_the_title($id)
            ];

            return $breadcrumbs;
        }

        if (is_category()) {

            $breadcrumbs[] = [
                'link' => get_home_url() . '/stories',
                'title' => 'Stories'
            ];

            $breadcrumbs[] = [
                'title' => single_cat_title('', false)
            ];

            return $breadcrumbs;
        }

        if (is_page()) {
            // If child page, get parents
            $anc = get_post_ancestors($post->ID);

            // Get parents in the right order
            $anc = array_reverse($anc);

            // Parent page loop
            $parents = '';

            foreach ($anc as $ancestor) {
                // display ancestors except footer id->57833
                if ($ancestor !== 57833) {
                    $breadcrumbs[] = [
                        'link' => get_permalink($ancestor),
                        'title' => get_the_title($ancestor)
                    ];
                }
            }

            $breadcrumbs[] = [
                'title' => get_the_title()
            ];

            return $breadcrumbs;
        }

        return $breadcrumbs;
    }
}
