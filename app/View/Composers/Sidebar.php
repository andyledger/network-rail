<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Sidebar extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.sidebar',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'child_pages' => $this->child_pages(),
            'child_pages_title' => $this->child_pages_title(),
            'menu_categories_child_of_stories' => $this->menu_categories_child_of_stories(),
            'menu_blog_categories' => $this->menu_blog_categories()
        ];
    }

    /**
     * Find the parent root ancestor of a page given.
     *
     * @return Integet       ID of the ancestor root parent
     */
    protected function root_parent_ancestor()
    {
        $post = get_post();

        if ($post->post_parent) {
            $ancestors = get_post_ancestors($post->ID);

            $root = count($ancestors) - 1;

            return $ancestors[$root];
        }

        return $post->ID;
    }

    /**
     * [childPages description]
     *
     * @return [type]       [description]
     */
    protected function child_pages()
    {
        $page_ancestor = $this->root_parent_ancestor();

        $args = [
            'echo' => false,
            'title_li'  => null, // No default title.
            'child_of'  => $page_ancestor,
        ];

        return '<div class="pagenav"><ul>' . wp_list_pages($args) . '</ul></div>';
    }

    /**
     * [childPages description]
     *
     * @return [type]       [description]
     */
    protected function child_pages_title()
    {
        $page_ancestor = $this->root_parent_ancestor();
        return get_the_title($page_ancestor);
    }

    /**
     * Recursively sort an array of taxonomy terms hierarchically. Child categories will be
     * placed under a 'children' member of their parent term.
     *
     * @param Array   $cats     taxonomy term objects to sort
     * @param Array   $into     result array to put them in
     * @param integer $parentId the current parent ID to put them in
     */
    private function sort_terms_hierarchically(array &$cats, array &$into, $parentId = 0)
    {
        foreach ($cats as $i => $cat) {
            if ($cat->parent == $parentId) {
                $into[$cat->term_id] = $cat;
                unset($cats[$i]);
            }
        }

        foreach ($into as $topCat) {
            $topCat->children = [];
            $this->sort_terms_hierarchically($cats, $topCat->children, $topCat->term_id);
        }
    }

    /**
     * Return a category list child of stories category
     *
     * @return string
     */
    public function menu_categories_child_of_stories()
    {
        $cat_id = get_category_by_slug('stories');
        $cat_id = $cat_id->term_id;

        $categories = get_terms(
            [
            'taxonomy' => 'category',
            'child_of' => $cat_id,
            'hide_empty' => false,
            ]
        );

        if (\is_wp_error($categories)) {
            return '';
        }

        $category_hierarchy = [];

        $this->sort_terms_hierarchically($categories, $category_hierarchy, $cat_id);

        $template = '<div class="tw-text-3xl tw-font-bold tw-mb-6">Category list</div>';

        $template .= '<ul>';

        foreach ($category_hierarchy as $element) {
            if ($element->slug !== 'uncategorized') {
                $template .= '<li class="tw-font-bold tw-mb-3">';
                $template .= '<a class="hover:tw-text-hyperlinks hover:tw-underline" href="'.get_permalink(get_option('page_for_posts')).'?cat_name='.$element->slug.'">'.$element->name.'</a>';

                if (!empty($element->children)) {
                    $template .= '<ul class="tw-list-disc tw-pl-6 tw-mt-3">';

                    foreach ($element->children as $el) {
                        $template .= '<li class="tw-mb-3"><a class="hover:tw-text-hyperlinks hover:tw-underline" href="'.get_permalink(get_option('page_for_posts')).'?cat_name='.$el->slug.'">'.$el->name.'</a></li>';
                    }

                    $template .= '</ul>';
                }


                $template .= '</li>';
            }
        }

        $template .= '</ul>';

        return $template;
    }

    /**
     * Return a hierarchicall blog_category taxanomy list
     *
     * @return string
     */
    public function menu_blog_categories()
    {
        $categories = get_terms(
            [
            'taxonomy' => 'blog_category',
            'hide_empty' => false
            ]
        );

        if (\is_wp_error($categories)) {
            return '';
        }

        $category_hierarchy = [];

        $this->sort_terms_hierarchically($categories, $category_hierarchy);

        $template = '<div class="tw-text-3xl tw-font-bold tw-mb-6">Category list</div>';

        $template .= '<ul>';

        foreach ($category_hierarchy as $element) {
            if ($element->slug !== 'uncategorized') {
                $template .= '<li class="tw-font-bold tw-mb-3">';
                $template .= '<a class="hover:tw-text-hyperlinks hover:tw-underline" href="'.get_permalink(get_page_by_path('blogs')).'?cat_name='.$element->slug.'">'.$element->name.'</a>';

                if (!empty($element->children)) {
                    $template .= '<ul class="tw-list-disc tw-pl-6 tw-mt-3">';

                    foreach ($element->children as $el) {
                        $template .= '<li class="tw-mb-3"><a class="hover:tw-text-hyperlinks hover:tw-underline" href="'.get_permalink(get_page_by_path('blogs')).'?cat_name='.$el->slug.'">'.$el->name.'</a></li>';
                    }

                    $template .= '</ul>';
                }


                $template .= '</li>';
            }
        }

        $template .= '</ul>';

        return $template;
    }
}
