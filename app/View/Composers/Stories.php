<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class Stories extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'page-stories'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'featuredStories' => $this->getFeaturedStory(),
            'stories' => $this->getStories(),
            'customPagination' => $this->customPagination(),
            'categories' => $this->getCategories()
        ];
    }

    public function getFeaturedStory()
    {

        $featuredTerm = get_category_by_slug('featured');

        $ignoredCategories = [1];

        if (!empty($featuredTerm)) {
            $ignoredCategories[] = $featuredTerm->term_id;
        }

        return new WP_Query([
            'post_type' => 'post',
            'post__in' => $this->getFeaturedStoryID(),
            'category__not_in'  => $ignoredCategories,
            'posts_per_page' => 1,
            'ignore_sticky_posts' => true
        ]);
    }

    public function getFeaturedStoryID()
    {
        return get_field('featured_story', get_page_by_path('stories'));
    }

    public function getStories()
    {
        global $wp_query;

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $featuredTerm = get_category_by_slug('featured');

        $ignoredCategories = [1];

        if (!empty($featuredTerm)) {
            $ignoredCategories[] = $featuredTerm->term_id;
        }

        $args = [
            'post_type' => 'post',
            'posts_per_page' => 6,
            'paged' => $paged,
            'post__not_in' => $this->getFeaturedStoryID(),
            'category__not_in'  => $ignoredCategories
        ];

        if (!empty($_GET['cat'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $_GET['cat'],
                    'parent' => 335
                ]
            ];
        }

        $wp_query = new WP_Query($args);

        return $wp_query;
    }

    public function customPagination()
    {
        global $wp_query;

        if ($wp_query->max_num_pages <= 1) {
            return;
        }

        $big = 999999999; // need an unlikely integer

        $pages = paginate_links(
            [
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $wp_query->max_num_pages,
                'type'  => 'array',
                'prev_text' => '<span>‹<span><span class="sm:tw-pl-2 tw-hidden tw-underline sm:tw-inline-block">Previous</span>',
                'next_text' => '<span class="sm:tw-pr-2 tw-hidden tw-underline sm:tw-inline-block">Next</span><span>›</span>',
                'before_page_number' => '<span class="tw-sr-only">' . __( 'Page', 'networkrail' ) . '</span> '
            ]
        );

        $result = '';

        if (is_array($pages)) {

            $result = '<nav class="nav-pagination tw-flex tw-justify-center sm:tw-justify-end" aria-label="Pagination">';

            foreach ($pages as $page) {
                $result .= $page;
            }

            $result .= '</nav>';
        }

        return $result;
    }

    public function getCategories()
    {
        $featuredTerm = get_category_by_slug('featured');

        $ignoredCategories = [1];

        if (!empty($featuredTerm)) {
            $ignoredCategories[] = $featuredTerm->term_id;
        }

        return get_terms([
            'taxonomy' => 'category',
            'hide_empty' => true,
            'parent' => 335,
            'exclude' => $ignoredCategories
        ]);
    }
}
