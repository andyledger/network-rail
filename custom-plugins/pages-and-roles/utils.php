<?php

/**
 * Get a list of pages IDs with its childs and grand childs from a region role
 * @param  int      $user_id        The user you want to get his own pages
 * @param  array    $pages_id       List of pages you want to get its child IDs
 *                                  and grand childs IDs
 * @param  array    $exclude_ids    List of pages to be excluded (usefull when you
 *                                  don't need the page parent)
 * @return array    List of IDs
 */
function get_child_and_own_pages($user_id, $page_ids, $exclude_ids) {
    $pages = [];

    foreach ($page_ids as $page) {
        $shouther_region_pages = get_pages([
            'child_of'     => $page,
            'hierarchical' => false,
            'post_status'  => ['publish', 'draft']
        ]);

        foreach ($shouther_region_pages as $page) {
            $pages[] = $page->ID;
        }
    }

    foreach ($page_ids as $page) {
        $pages[] = $page;
    }

    // remove $exclude_ids pages
    $pages = array_diff($pages, $exclude_ids);

    // add own pages
    $own_pages = get_posts([
        'author' => $user_id,
        'post_type' => 'page',
        'posts_per_page' => -1,
        'post_status' => ['publish', 'draft']
    ]);

    foreach ($own_pages as $page) {
        $pages[] = $page->ID;
    }

    return $pages;
}

/**
 * @return boolean if a user is a specific role
 */
function is_current_user($role) {
    $user_id = get_current_user_id();

    if ($user_id) {
        $user_meta = get_userdata($user_id);

        $user_roles = $user_meta->roles;

        return in_array($role, $user_roles);
    }

    return false;
}

/**
 * @return boolean if a user is a Admin or NR Admin
 */
function is_current_user_admin_or_nr_admin() {
    $user_id = get_current_user_id();

    if ($user_id) {
        $user_meta = get_userdata($user_id);

        $user_roles = $user_meta->roles;

        return (in_array('administrator', $user_roles) || in_array('nr_admin', $user_roles));
    }

    return false;
}
