<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Home extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'home',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'dropdown_title' => $this->dropdown_title(),
            'dropdown_categories' => $this->dropdown_categories(),
            'custom_pagination' => $this->custom_pagination(),
            'pagination_results' => $this->pagination_results()
        ];
    }

    private function dropdown_title()
    {
        $category = get_category_by_slug(App::get_cat_name());

        if (is_object($category)) {
            return wp_trim_words($category->name, 3, '...');
        }

        return 'All';
    }

    /**
     * Categories child of stories
     *
     * @return array
     */
    private function dropdown_categories()
    {
        $args = [
            'parent' => 335 // show only categories child of Stories category
        ];

        $home = get_permalink(
            get_option('page_for_posts')
        );

        $result = [];

        $result[] = [
            "title" => 'All',
            "url" => $home
        ];

        foreach (get_categories($args) as $value) {
            $result[] = [
                "title" => $value->name,
                "url" => $home . '?cat_name=' .$value->slug
            ];
        }

        return $result;
    }

    private function index_posts()
    {
        return get_posts(
            [
                'post_type'     => ['post'],
                'posts_per_page'=> -1,
                'category_name' => App::get_cat_name()
            ]
        );
    }

    /**
     * Total of posts requested
     *
     * @return int
     */
    private function number_of_posts()
    {
        return count(
            $this->index_posts()
        );
    }

    private function page_number()
    {
        return (get_query_var('paged')) ? get_query_var('paged') : 1;
    }

    private function is_last_page()
    {
        $number_of_posts = $this->number_of_posts();
        $page_number = $this->page_number();
        $ppp = get_option('posts_per_page');

        return (
            intdiv($number_of_posts, $ppp) + 1 == $page_number
        ) ? true : false;
    }

    /**
     * Return formatted HTML with the results
     *
     * @return string
     */
    private function pagination_results()
    {
        $ppp = intval(get_option('posts_per_page'));
        $page_number = get_query_var('paged') ? get_query_var('paged') : 1;
        $total = $this->number_of_posts();
        $from = $ppp * $page_number - ($ppp - 1);
        $to = ($this->is_last_page()) ? $total : $from + $ppp - 1 ;

        return '<div class="tw-mb-4 md:tw-mb-0">Results '.$from.' - '.$to.' out of '.$total.'</div>';
    }

    private function custom_pagination()
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
                'prev_text' => '<span>‹<span><span class="sm:tw-pl-2 tw-hidden tw-underline sm:tw-inline-block">Prev</span>',
                'next_text' => '<span class="sm:tw-pr-2 tw-hidden tw-underline sm:tw-inline-block">Next</span><span>›</span>'
            ]
        );

        $result = '';

        if (is_array($pages)) {
            $paged = (get_query_var('paged') == 0) ? 1 : get_query_var('paged');

            $result = '<nav class="nav-pagination tw-flex tw-justify-center sm:tw-justify-end">';

            foreach ($pages as $page) {
                $result .= $page;
            }

            $result .= '</nav>';
        }

        return $result;
    }
}
