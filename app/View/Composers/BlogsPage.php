<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

// use WP_Query;

class BlogsPage extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'page-blogs',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'get_blogs' => $this->get_blogs(),
            'dropdown_blog_categories' => $this->dropdown_blog_categories()
        ];
    }

    /**
     * get blogs custom post type with blog_category taxonomy
     * @return Array
     */
    protected function get_blogs()
    {
        $cat = $_GET['cat_name'] ?? null;

        $args = [
          'post_type' => ['blog']
        ];

        if ($cat) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'blog_category',
                    'field'    => 'slug',
                    'terms'    => $cat
                ]
            ];
        }

        return get_posts($args);
    }

    protected function dropdown_blog_categories()
    {
        $result = [];

        $result[] = [
            'url' => get_permalink(get_page_by_path('blogs')),
            'title' => 'All'
        ];

        $arr = get_terms([
            'taxonomy' => 'blog_category',
            'hide_empty' => false
        ]);

        foreach ($arr as $cat) {
            $result[] = [
                'url' => get_permalink(get_page_by_path('blogs')).'?cat_name='.$cat->slug,
                'title' => $cat->name
            ];
        }

        return $result;
    }
}
