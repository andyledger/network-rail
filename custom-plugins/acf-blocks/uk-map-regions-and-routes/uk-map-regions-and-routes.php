<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
    // check function exists
    if ( function_exists( 'acf_register_block' ) ) {
        acf_register_block( [
            'name'            => 'nr-acf-uk-map-regions-and-routes',
            'title'           => __( 'NR UK map regions and routes' ),
            'description'     => __( 'Insert a regions and routes UK map' ),
            'render_callback' => 'nr_acf_uk_map_regions_and_routes_callback',
            'category'        => 'common',
            'icon'        => ['foreground' => '#e56430','src' => 'admin-site'],
            'mode'        => 'edit'
        ] );
    }
});


/**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_uk_map_regions_and_routes_callback( $block ) {
    $links = get_field('regions');
    $title = get_field('title');

    $areas = [
        [
            "name"=>"Anglia Route",
            "svg"=>"anglia",
            "x"=>"450",
            "y"=>"560",
            "count"=>"1",
            "color"=>"tw-text-brand-orange tw-opacity-100 hover:tw-text-brand-orange-darkest",
            "link"=> is_array($links['eastern'][0]['link']) ? $links['eastern'][0]['link']['url'] : '#',
        ],

        [
            "name"=>"East Midlands Route",
            "svg"=>"east-midlands",
            "x"=>"360",
            "y"=>"530",
            "count"=>"3",
            "color"=> "tw-text-brand-orange tw-opacity-100 hover:tw-text-brand-orange-darkest",
            "link"=> is_array($links['eastern'][1]['link']) ? $links['eastern'][1]['link']['url'] : '#'
        ],
        [
            "name"=>"North & East Route",
            "svg"=>"north-east",
            "x"=>"320",
            "y"=>"400",
            "count"=>"4",
            "color"=> "tw-text-brand-orange tw-opacity-100 hover:tw-text-brand-orange-darkest",
            "link"=> is_array($links['eastern'][2]['link']) ? $links['eastern'][2]['link']['url'] : '#'
        ],
        [
            "name"=>"Central Route",
            "svg"=>"central",
            "x"=>"318",
            "y"=>"580",
            "count"=>"5",
            "color"=> "tw-text-brand-green tw-opacity-100 hover:tw-text-brand-green-darkest",
            "link"=> is_array($links['north-west-and-central'][1]['link']) ? $links['north-west-and-central'][1]['link']['url'] : '#'
        ],
        [
            "name"=>"North West Route",
            "svg"=>"north-west",
            "x"=>"270",
            "y"=>"410",
            "count"=>"6",
            "color"=> "tw-text-brand-green tw-opacity-100 hover:tw-text-brand-green-darkest",
            "link"=> is_array($links['north-west-and-central'][0]['link']) ? $links['north-west-and-central'][0]['link']['url'] : '#'
        ],
        [
            "name"=>"West Coast South Route",
            "svg"=>"west-coast-south",
            "x"=>"355",
            "y"=>"580",
            "count"=>"7",
            "color"=> "tw-text-brand-green tw-opacity-100 hover:tw-text-brand-green-darkest",
            "link"=> is_array($links['north-west-and-central'][2]['link']) ? $links['north-west-and-central'][2]['link']['url'] : '#'
        ],
        [
            "name"=>"Scotland Route",
            "svg"=>"scotland",
            "x"=>"180",
            "y"=>"180",
            "count"=>"8",
            "color"=> "tw-text-brand-blue-dark tw-opacity-100 hover:tw-text-brand-blue-darkest",
            "link"=> is_array($links['scotlands_railway'][0]['link']) ? $links['scotlands_railway'][0]['link']['url'] : '#'
        ],
        [
            "name"=>"Kent Route",
            "svg"=>"kent",
            "x"=>"450",
            "y"=>"670",
            "count"=>"9",
            "color"=> "tw-text-brand-turquesa tw-opacity-100 hover:tw-text-brand-turquesa-darkest",
            "link"=> is_array($links['southern'][0]['link']) ? $links['southern'][0]['link']['url'] : '#'
        ],
        [
            "name"=>"Network Rail High Speed",
            "svg"=>"high-speed",
            "x"=>"475",
            "y"=>"660",
            "count"=>"10",
            "color"=> "tw-text-white",
            "link"=> is_array($links['southern'][3]['link']) ? $links['southern'][3]['link']['url'] : '#'
        ],
        [
            "name"=>"Sussex Route",
            "svg"=>"sussex",
            "x"=>"400",
            "y"=>"680",
            "count"=>"11",
            "color"=> "tw-text-brand-turquesa tw-opacity-100 hover:tw-text-brand-turquesa-darkest",
            "link"=> is_array($links['southern'][1]['link']) ? $links['southern'][1]['link']['url'] : '#'
        ],
        [
            "name"=>"Wessex Route",
            "svg"=>"wessex",
            "x"=>"330",
            "y"=>"680",
            "count"=>"12",
            "color"=> "tw-text-brand-turquesa tw-opacity-100 hover:tw-text-brand-turquesa-darkest",
            "link"=> is_array($links['southern'][2]['link']) ? $links['southern'][2]['link']['url'] : '#'
        ],

        [
            "name"=>"Wales & Borders Route",
            "svg"=>"wales",
            "x"=>"220",
            "y"=>"560",
            "count"=>"13",
            "color"=> "tw-text-brand-red tw-opacity-100 hover:tw-text-brand-pink-darkest",
            "link"=> is_array($links['wales-and-western'][0]['link']) ? $links['wales-and-western'][0]['link']['url'] : '#'
        ],
        [
            "name"=>"Western Route",
            "svg"=>"western",
            "x"=>"300",
            "y"=>"630",
            "count"=>"14",
            "color"=> "tw-text-brand-red tw-opacity-100 hover:tw-text-brand-pink-darkest",
            "link"=> is_array($links['wales-and-western'][1]['link']) ? $links['wales-and-western'][1]['link']['url'] : '#'
        ],
        [
            "name"=>"East Coast Route",
            "svg"=>"east-coast",
            "x"=>"352",
            "y"=>"450",
            "count"=>"2",
            "color"=> "tw-text-brand-orange-dark tw-opacity-100 hover:tw-text-brand-orange-darkest",
            "link"=> is_array($links['eastern'][3]['link']) ? $links['eastern'][3]['link']['url'] : '#'
        ],
    ];

    $regions = [
        'eastern' => $links['eastern_link']['url'] ?? null,
        'northwestandcentral' => $links['north-west-and-central_link']['url'] ?? null,
        'scotlandsrailway' => $links['scotlands_railway_link']['url'] ?? null,
        'southern' => $links['southern_link']['url'] ?? null,
        'walesandwestern' => $links['wales-and-western_link']['url'] ?? null,
    ];

    $areas = htmlentities(json_encode($areas, JSON_HEX_QUOT), ENT_QUOTES);
    $regions = htmlentities(json_encode($regions, JSON_HEX_QUOT), ENT_QUOTES);

    ?>
    <div>
        <?php if ($title): ?>
            <h3 class="tw-text-3xl tw-leading-relaxed"><?php echo $title ?></h3>
        <?php endif ?>

        <?php if (!is_admin()): ?>
            <n-uk-map
                    :areas="<?php echo $areas ?>"
                    :regions="<?= $regions ?>"
                    class="n-uk-map-wrapper"
            ></n-uk-map>
        <?php endif ?>

        <?php if (is_admin()): ?>
            <p>Region and Route Map</p>
        <?php endif ?>
    </div>
    <?php
}
