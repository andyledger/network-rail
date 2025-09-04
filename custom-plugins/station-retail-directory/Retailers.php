<?php

namespace MuPlugins\StationRetailDirectory;

class Retailers
{
    protected function station_ids()
    {
        $stations = get_posts([
          'post_type'       => 'page',
          'post_parent'     => 3753, // our stations page ID
          'posts_per_page'  => -1,
          'orderby'         => 'title',
          'order'           => 'ASC'
        ]);

        $results = [];

        foreach ($stations as $station) {
            $results[] =$station->ID;
        }

        return $results;
    }

    public function get_retailers()
    {
        $results = [];

        $station_ids = $this->station_ids();

        foreach ($station_ids as $station_id) {
            
            $retailers = get_field('retailers', $station_id);

            if ($retailers) {
                foreach ($retailers as $retailer) {

                    if (empty($retailer['brand'])) {
                        continue;
                    }

                    $store_types = get_the_terms($retailer['brand']->ID, 'station_store_type');

                    $types = [];

                    if (is_array($store_types)) {
                        foreach ($store_types as $type) {
                            $types[] = wp_specialchars_decode($type->slug);
                        }
                    }

                    $attachment_id = get_post_thumbnail_id($retailer['brand']->ID);

                    $attachment_src = fly_get_attachment_image_src(
                        $attachment_id,
                        [300, 150],
                        true
                    );

                    if (count($attachment_src) === 0) {
                        $default_id = get_field('default_thumbnail', 'options');
                        $attachment_src = fly_get_attachment_image_src(
                            $default_id,
                            [300, 150],
                            true
                        );
                    }

                    $results[get_the_title($station_id)]['id'] = $station_id;

                    $results[get_the_title($station_id)]['retailers'][] = [
                        'title' => $retailer['brand']->post_title,
                        'name' => $retailer['brand']->post_name,
                        'link_to_station' => get_the_permalink($station_id),
                        'description' => $retailer['brand']->post_content,
                        'attachment_src' => $attachment_src['src'] ?? null,
                        'types' => $types,
                        'stores' => $retailer['retailer']
                    ];
                }
            }
        }

        return $results;
    }
}