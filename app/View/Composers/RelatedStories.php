<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class RelatedStories extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'single'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'stories' => $this->getStories(),
        ];
    }

    public function getStories()
    {
        $args = [
            'post_type' => 'post',
            'posts_per_page' => 4,
            'post__not_in' => [get_the_ID()],
            'ignore_sticky_posts' => true
        ];

        return new WP_Query($args);
    }
}
