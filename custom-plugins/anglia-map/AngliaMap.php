<?php

class AngliaMap {
    protected $anglia_map_sheet_url;

    public function __construct( $anglia_map_sheet_url )
    {
        $this->anglia_map_sheet_url = $anglia_map_sheet_url;
    }

    /**
    * convert csv from url to an array of datq
    * @return array or string in case of fail
    */
    public function convertCsvToArray()
    {
        $spreadsheet_data = [];

        if (($handle = fopen($this->anglia_map_sheet_url, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $spreadsheet_data[] = $data;
            }

            fclose($handle);

            return $spreadsheet_data;
        }

        return 'Fail to read google sheet.';
    }

    public function penultimate_element($array)
    {
        $number_of_elements = count($array);

        return $array[$number_of_elements - 2];
    }

    public function checkLatLng($string) {
        return preg_match('/^(-?\d+(\.\d+)?),\s*(-?\d+(\.\d+)?)$/', $string);
    }

    public function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' )
    {
        global $wpdb;

        $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'", $page_slug, $post_type ) );

        if ( $page ) {
            return get_post($page, $output);
        }

        return null;
    }

    public function createDataModel()
    {
        $csv = $this->convertCsvToArray();
        $data = [];

        for ($i=1; $i < count($csv); $i++) {
            if ( !$this->checkLatLng($csv[$i][0])) {
                add_action( 'admin_notices', $callback = function() use ($i) {
                    ?>
                        <div class="notice notice-error is-dismissible">
                            <p><strong>Wrong lat-long at row <?php echo $i + 1 ?> on you spreadsheet</strong></p>
                            <p>Format should be: 51.530975,0.7931863</p>
                        </div>
                    <?php
                });

                return;
            }

            $position = explode(',', $csv[$i][0]);
            $lat = 0;
            $long = 0;

            $lat = floatval($position[0]);
            $long = floatval($position[1]);

            $pageUrl = $csv[$i][7];

            if ($pageUrl) {
                $pageSlug = explode("/", $pageUrl);

                $pageSlug = $this->penultimate_element($pageSlug);
            }

            $data[$i] = [
                'position' => [
                    'lat' => $lat,
                    'lng' => $long
                ],
                'location' => $csv[$i][1],
                'line' => $csv[$i][2],
                'year' => $csv[$i][3],
                'work' => $csv[$i][4],
                'benefit' => $csv[$i][5],
                'type' => $csv[$i][6],
                'info' => $pageUrl,
                'icon' => $csv[$i][8]
            ];

            if (isset($pageSlug)) {
                $pageId = $this->get_page_by_slug($pageSlug);

                if ($pageId) {
                    $imageUrl = get_the_post_thumbnail_url($pageId->ID, 'medium');

                    if ($imageUrl) {
                        $data[$i]['imageUrl'] = $imageUrl;
                    }
                }
            }
        }

        return $data;
    }
}
