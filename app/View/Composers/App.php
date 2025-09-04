<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'site_name' => $this->site_name(),
            'is_safespaces' => $this->is_safespaces(),
            'is_black_logo' => $this->is_black_logo(),
            'logo_type' => $this->logo_type(),
            'is_production' => $this->is_production()
        ];
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function site_name()
    {
        return get_bloginfo('name', 'display');
    }

    /**
     * Check if the server is www.networkrail.co.uk
     *
     * @return boolean
     */
    public function is_production()
    {
        if ($_SERVER['HTTP_HOST'] === 'www.networkrail.co.uk') {
            return true;
        }

        return false;
    }

    /**
     * Check if the post thumbnail image has a
     * description, if not return the image title
     *
     * @param WP_Post|integer $post comment
     *
     * @return string
     */
    public static function alt_image($post)
    {
        $image_id = get_post_thumbnail_id($post);
        $alt_image = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        $image_title = get_the_title($image_id);

        if ($alt_image) {
            return $alt_image;
        }

        return $image_title;
    }

    /**
     * Check if an image has a description,
     * if not return the image title
     *
     * @param integer $id comment id of the image
     *
     * @return string
     */
    public static function alt_image_from_id(int $id)
    {
        $alt_image = get_post_meta($id, '_wp_attachment_image_alt', true);
        $image_title = get_the_title($id);

        if ($alt_image) {
            return $alt_image;
        }

        return $image_title;
    }

    /**
     * [on_the_fly_thumbnail description]
     *
     * @param int   $id   comment post ID
     * @param array $size comment width and heigh
     *
     * @return string url of the image or empty string
     */
    public static function on_the_fly_thumbnail(int $id, $size = [])
    {
        // set default thumbnail id
        $image_id = get_field('default_thumbnail', 'options');

        // check if the post id has a thumbnail
        if (has_post_thumbnail($id)) {
            $image_id = get_post_thumbnail_id($id);
        }

        $image = fly_get_attachment_image_src($image_id, $size, true);

        if (!empty($image)) {
            return $image['src'];
        }

        return '';
    }

    /**
     * Convert bytes in human readable filesize
     *
     * @param [integer] $bytes comment
     *
     * @return [string]
     */
    public static function human_filesize($bytes)
    {
        $bytes = floatval($bytes);

        $result = "";

        $arBytes = [
            0 => [
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ],
            1 => [
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ],
            2 => [
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ],
            3 => [
                "UNIT" => "KB",
                "VALUE" => 1024
            ],
            4 => [
                "UNIT" => "B",
                "VALUE" => 1
            ],
        ];

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(
                    ".",
                    ",",
                    strval(round($result, 0))
                ) . " " . $arItem["UNIT"];

                break;
            }
        }
        return $result;
    }


    /**
     * This method is static because it is being use into Home.php class
     * and filters.php
     *
     * @return string
     */
    public static function get_cat_name()
    {
        if (isset($_GET['cat_name']) && !empty($_GET['cat_name'])) {
            return $_GET['cat_name'];
        }

        return '';
    }

    /**
     * Display safe spaces banner
     *
     * @return boolean
     */
    protected function is_safespaces()
    {
        return get_field('safespaces', 'options');
    }

    /**
     * Display black logo
     *
     * @return boolean
     */
    protected function is_black_logo()
    {
        return get_field('is_black_logo', 'options');
    }

    /**
     * Select logo
     *
     * @return String
     */
    protected function logo_type()
    {
        return get_field('logo_type', 'options');
    }

    /**
     * Get taxonomy name by slug
     *
     * @param string $url_var  comment
     * @param string $taxonomy comment
     *
     * @return string in case there is a taxonomy
     * associated with the slug or false
     */
    public static function get_taxonomy_name_by_slug(string $url_var, string $taxonomy)
    {
        $slug = $_GET[$url_var] ?? null;

        if ($slug) {
            $tax = get_term_by('slug', $slug, $taxonomy);

            return $tax->name ?? 'Wrong ' . $taxonomy;
        }

        return 'All';
    }

    /**
     * Get all the published posts directly from
     * the db where a File list is being displayed.
     * Filter added on network-rail/app/setup.php
     *
     * @return string html with a list of links
     */
    public static function get_file_lists_from_db()
    {
        global $wpdb;

        $query = "SELECT ID, post_title FROM " . $wpdb->posts . " WHERE post_content LIKE '%wp:acf/nr-acf-file-list%' AND post_content LIKE '%" . $_GET['post'] . "%' AND post_status = 'publish'";

        $results = $wpdb->get_results($query);

        if (empty($results)) {
            return 'no results';
        }

        $html = '<ul>';

        foreach ($results as $result) {
            $html .= '<li><a href="' . get_the_permalink($result->ID) . '" target="_blank">' . $result->post_title . '</a></li>';
        }

        $html .= '</ul';

        return $html;
    }

    /**
     * Get all the published posts directly from
     * the DB where an image is being displayed.
     * Filter added on network-rail/app/setup.php
     *
     * @return string html with a list of links
     */
    public static function get_media_from_db()
    {
        global $wpdb;

        $query = "SELECT ID, post_title FROM " . $wpdb->posts . " WHERE post_content LIKE '%wp:image%' AND post_content LIKE '%" . $_GET['post'] . "%' AND post_status = 'publish'";

        $results = $wpdb->get_results($query);

        if (empty($results)) {
            return 'no results';
        }

        $html = '<ul>';

        foreach ($results as $result) {
            $html .= '<li><a href="' . get_the_permalink($result->ID) . '" target="_blank">' . $result->post_title . '</a></li>';
        }

        $html .= '</ul';

        return $html;
    }
}
