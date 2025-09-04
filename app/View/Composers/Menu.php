<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Menu extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.header'
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        //dd($this->primary_navigation_menu());exit;
        return [
            'menu' => $this->primary_navigation_menu()
        ];
    }

    /**
     * Get primary navigation menu
     * @return object The primary navigation menu
     */
    public function primary_navigation_menu()
    {
        if (($locations = get_nav_menu_locations()) && isset($locations['primary_navigation'])) {
            return $this->wp_api_v2_menus_get_menu_items(
                $locations['primary_navigation']
            );
        } else {
            return new \WP_Error('no_menu_found', 'Set a menu to the primary_navigation location.');
        }
    }

    /**
     * Check if a menu item is child of one of the menu's element passed as reference
     *
     * @param $parents Menu's items
     * @param $child Menu's item to check
     *
     * @return bool True if the parent is found, false otherwise
     */
    public function wp_api_v2_menus_dna_test(&$parents, $child)
    {
        foreach ($parents as $key => $item) {

            if ($child->menu_item_parent == $item->ID) {
                if (! $item->child_items) {
                    $item->child_items = [];
                }

                array_push($item->child_items, $child);
                return true;
            }

            if ($item->child_items) {
                if ($this->wp_api_v2_menus_dna_test($item->child_items, $child)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Retrieve items for a specific menu
     *
     * @param $id Menu id
     *
     * @return array List of menu items
     */
    public function wp_api_v2_menus_get_menu_items($id)
    {
        $menu_items = wp_get_nav_menu_items($id);

        // check if there is acf installed
        if (class_exists('acf')) {
            foreach ($menu_items as $menu_key => $menu_item) {
                $fields = get_fields($menu_item->ID);
                if (! empty($fields)) {
                    foreach ($fields as $field_key => $item) {
                        // add all acf custom fields
                        $menu_items[ $menu_key ]->$field_key = $item;
                    }
                }
            }
        }

        // wordpress does not group child menu items with parent menu items
        $child_items = [];

        // pull all child menu items into separate object
        foreach ($menu_items as $key => $item) {
            if ($item->type == 'post_type') {
                // add slug to menu items
                $slug = basename(get_permalink($item->object_id));

                $item->slug = $slug;
            } elseif ($item->type == 'taxonomy') {
                $cat = get_term($item->object_id);

                $item->slug = $cat->slug;
            } elseif ($item->type == 'post_type_archive') {
                $post_type_data = get_post_type_object($item->object);

                if ($post_type_data->has_archive) {
                    $item->slug = $post_type_data->rewrite['slug'];
                }
            }

            if (isset($item->thumbnail_id) && $item->thumbnail_id) {
                $item->thumbnail_src = wp_get_attachment_image_url(intval($item->thumbnail_id), 'post-thumbnail');
            }

            if (isset($item->thumbnail_hover_id) && $item->thumbnail_hover_id) {
                $item->thumbnail_hover_src = wp_get_attachment_image_url(intval($item->thumbnail_hover_id), 'post-thumbnail');
            }

            if ($item->menu_item_parent) {

                unset(
                    $item->post_title,
                    $item->post_name,
                    $item->menu_order,
                    $item->post_author,
                    $item->post_date,
                    $item->post_date_gmt,
                    $item->post_content,
                    $item->post_excerpt,
                    $item->post_status,
                    $item->comment_status,
                    $item->ping_status,
                    $item->post_password,
                    $item->to_ping,
                    $item->pinged,
                    $item->post_modified,
                    $item->post_modified_gmt,
                    $item->post_content_filtered,

                    $item->description,
                    $item->comment_count,
                    $item->post_mime_type,
                    $item->post_type,
                    $item->guid,
                    $item->db_id,
                    $item->object_id,
                    $item->object,
                    $item->type,
                    $item->type_label,
                    $item->target,
                    $item->attr_title,
                    $item->classes,
                    $item->xfn,
                    $item->slug
                );

                array_push($child_items, $item);
                unset($menu_items[ $key ]);
            }
        }

        // push child items into their parent item in the original object
        do {
            foreach ($child_items as $key => $child_item) {
                if ($this->wp_api_v2_menus_dna_test($menu_items, $child_item)) {
                    unset($child_items[$key]);
                }
            }
        } while (count($child_items));

        foreach ($menu_items as $key => $item) {
            unset(
                $menu_items[$key]->post_title,
                $menu_items[$key]->post_name,
                $menu_items[$key]->post_parent,
                $menu_items[$key]->menu_order,
                $menu_items[$key]->menu_item_parent,
                $menu_items[$key]->post_author,
                $menu_items[$key]->post_date,
                $menu_items[$key]->post_date_gmt,
                $menu_items[$key]->post_content,
                $menu_items[$key]->post_excerpt,
                $menu_items[$key]->post_status,
                $menu_items[$key]->comment_status,
                $menu_items[$key]->ping_status,
                $menu_items[$key]->post_password,
                $menu_items[$key]->to_ping,
                $menu_items[$key]->pinged,
                $menu_items[$key]->post_modified,
                $menu_items[$key]->post_modified_gmt,
                $menu_items[$key]->post_content_filtered,
                $menu_items[$key]->filter,
                $menu_items[$key]->description,
                $menu_items[$key]->comment_count,
                $menu_items[$key]->post_mime_type,
                $menu_items[$key]->post_type,
                $menu_items[$key]->guid,
                $menu_items[$key]->db_id,
                $menu_items[$key]->object_id,
                $menu_items[$key]->object,
                $menu_items[$key]->type,
                $menu_items[$key]->type_label,
                $menu_items[$key]->target,
                $menu_items[$key]->attr_title,
                $menu_items[$key]->classes,
                $menu_items[$key]->xfn,
                $menu_items[$key]->slug,
            );
        }

        return array_values($menu_items);
    }
}
