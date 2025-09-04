<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.page-landing-header',
        'partials.content',
        'partials.content-*',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function override()
    {
        return [
            'title' => $this->title(),
            'on_the_fly_landing_page_image' => $this->on_the_fly_landing_page_image(),
            'on_the_fly_feature_image' => $this->on_the_fly_feature_image()
        ];
    }

    /**
     * Returns the post title.
     *
     * @return string
     */
    public function title()
    {
        if ($this->view->name() !== 'partials.page-header') {
            return get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            /* translators: %s is replaced with the search query */
            return sprintf(
                __('Search Results for %s', 'sage'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Sorry, that page cannot be found', 'sage');
        }

        return get_the_title();
    }

    /**
     * On the fly array with different size images.
     *
     * @return array false
     */
    public function on_the_fly_landing_page_image()
    {
        $attachment_id = get_post_thumbnail_id(
            get_the_ID()
        );

        $is_fly_image = fly_get_attachment_image_src($attachment_id, [600, 252], true);

        if (!empty($is_fly_image)) {
            return [
                'sm' => $is_fly_image['src'],
                'md' => fly_get_attachment_image_src($attachment_id, [800, 252], true)['src'],
                'lg' => fly_get_attachment_image_src($attachment_id, [1200, 252], true)['src'],
                'xl' => fly_get_attachment_image_src($attachment_id, [1700, 336], true)['src'],
            ];
        }

        return false;
    }

    /**
     * On the fly feature image.
     *
     * @return array false
     */
    public function on_the_fly_feature_image()
    {
        $attachment_id = get_post_thumbnail_id(
            get_the_ID()
        );

        $is_fly_image = fly_get_attachment_image_src($attachment_id, [800, 600], true);

        if (!empty($is_fly_image)) {
            return $is_fly_image['src'];
        }

        return false;
    }
}
