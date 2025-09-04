<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FrontPage extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'front-page',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'main_slider' => $this->main_slider(),
            'main_stories' => $this->main_stories(),
            'stories_around' => $this->stories_around(),
            'social_media_find_us' => $this->social_media_find_us(),
        ];
    }

    /**
     * Return an array of post objects for the main slider.
     *
     * @return array
     */
    public function main_slider()
    {
        $data = get_field('main_slider');

        $result = [];

        foreach ($data as $item) {
            if (!empty(get_field('label_title', $item->ID))) {
                $result[] = [
                    "title" => $item->post_title,
                    'description' => $item->post_excerpt === '' ? wp_trim_words($item->post_content, 5, '...') : $item->post_excerpt,
                    'altImage' => App::alt_image($item),
                    'content' => wp_trim_words($item->post_content, 5),
                    'link' => get_the_permalink($item->ID),
                    'link_title' => $item->label_title,
                    'imgUrl' => get_the_post_thumbnail_url($item->ID),
                    'imgUrlSrcSet' => wp_get_attachment_image_srcset(
                        get_post_thumbnail_id($item->ID)
                    ),
                ];
            } else {
                $result[] = [
                    "title" => $item->post_title,
                    'description' => $item->post_excerpt === '' ? wp_trim_words($item->post_content, 5, '...') : $item->post_excerpt,
                    'altImage' => App::alt_image($item),
                    'content' => wp_trim_words($item->post_content, 5),
                    'link' => get_the_permalink($item->ID),
                    'link_title' => 'More information',
                    'imgUrl' => get_the_post_thumbnail_url($item->ID),
                    'imgUrlSrcSet' => wp_get_attachment_image_srcset(
                        get_post_thumbnail_id($item->ID)
                    ),
                ];
            }
        }

        return $result;
    }

    /**
     * Return an array of post objects for the main stories section.
     *
     * @return array
     */
    public function main_stories()
    {
        $posts = get_field('main_stories');

        $result = [];

        foreach ($posts as $item) {
            $result[] = [
                'title' => $item->post_title,
                'description' => $item->post_excerpt === '' ? wp_trim_words($item->post_content, 30, '...') : $item->post_excerpt,
                'link' => get_the_permalink($item->ID),
                'imgUrl' => get_the_post_thumbnail_url($item->ID, 'large'),
                'altImage' => App::alt_image($item),
            ];
        }

        return $result;
    }

    /**
     * Last 4 posts for the stories around section (exclude uncategorized post).
     *
     * @return [array]
     */
    public function stories_around()
    {
        $featuredTerm = get_category_by_slug('featured');

        $ignoredCategories = [1];

        if (!empty($featuredTerm)) {
            $ignoredCategories[] = $featuredTerm->term_id;
        }

        $posts = get_posts(
            [
                'post_type' => ['post'],
                'posts_per_page' => 4,
                'category__not_in' => $ignoredCategories,
            ]
        );

        $result = [];

        foreach ($posts as $item) {
            $result[] = [
                'title' => $item->post_title,
                'description' => $item->post_excerpt === '' ? wp_trim_words($item->post_content, 30, '...') : $item->post_excerpt,
                'link' => get_the_permalink($item->ID),
                'imgUrl' => get_the_post_thumbnail_url($item->ID, 'medium'),
                'date' => get_the_date('M j, Y', $item->ID),
                'altImage' => App::alt_image($item),
            ];
        }

        return $result;
    }

    /**
     * Social media data used in find us section.
     *
     * @return [array]
     */
    public function social_media_find_us()
    {
        $social_media = get_field('social_media', 'options');

        // temporary solution
        $social_media[0]['class'] = 'sm_twitter';
        $social_media[1]['class'] = 'sm_facebook';

        return $social_media;
    }
}
