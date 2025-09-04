<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function () {
    // check function exists
    if ( function_exists( 'acf_register_block' ) ) {
        acf_register_block( [
            'name'            => 'nr-acf-in-numbers',
            'title'           => __( 'NR In Numbers Infographic' ),
            'description'     => __( 'Create a modular grid infographic' ),
            'render_callback' => 'nr_acf_in_numbers_callback',
            'category'        => 'common',
            'icon'            => ['foreground' => '#e56430','src' => 'welcome-write-blog'],
            'mode'            => 'edit'
        ] );
    }
});

 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_in_numbers_callback( $block ) {
    $infographics = get_field('in_numbers_infographic');
    ?>

    <?php if (isset($infographics) && !empty($infographics)): ?>
        <div class="infographic-wrapper">
            <?php foreach ($infographics as $item): ?>
                <div
                    style="width: <?php echo ($item['style'] === 'full-width') ? '750px' : '450px' ?>;"
                    class="infographic-card"
                >
                    <div class="infographic__skew"></div>

                    <div class="d-flex">
                        <?php if ($item['style'] === 'right'): ?>
                            <div class="infographic__icon w-3/5" style="font-size: 150px; color: #005F82;">
                                <?php echo file_get_contents(plugin_dir_url(__FILE__).'icons/'.$item['icon'].'.svg'); ?>
                            </div>
                        <?php endif ?>

                        <div class="<?php echo ($item['style'] === 'full-width') ? 'w-1/4' : 'w-2/5' ; ?>">
                            <div class="infographic__number">
                                <?php echo $item['number'] ?>
                            </div>

                            <div class="infographic__description">
                                <div class="infographic__description__shape"></div>

                                <div>
                                    <?php echo $item['description'] ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($item['style'] === 'left'): ?>
                            <div class="infographic__icon w-3/5" style="font-size: 150px; color: #005F82;">
                                <?php echo file_get_contents(plugin_dir_url(__FILE__).'icons/'.$item['icon'].'.svg'); ?>
                            </div>
                        <?php endif ?>

                        <?php if ($item['style'] === 'full-width'): ?>
                            <div class="infographic__icon w-1/2" style="font-size: 150px; color: #005F82;">
                                <?php echo file_get_contents(plugin_dir_url(__FILE__).'icons/'.$item['icon'].'.svg'); ?>
                            </div>

                            <div class="w-1/4">
                                <div class="infographic__number">
                                    <?php echo $item['number_2'] ?>
                                </div>

                                <div class="infographic__description">
                                    <div class="infographic__description__shape"></div>

                                    <div>
                                        <?php echo $item['description_2'] ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <style>
        .infographic-wrapper {
            background: #085370;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .infographic-card {
            position: relative;
            padding: .5rem 1.5rem;
            margin-right: .75rem;
            margin-bottom: .75rem;
            height: 200px;
        }

        .infographic__number {
            font-size: 80px;
            color: #F4811E;
            line-height: 90px;
            position:
            relative;
            z-index: 10;
            letter-spacing: -5px;
        }

        .infographic__number span {
            font-size: .65em;
        }

        .infographic__description {
            color: #085370;
            height: 100px;
            margin-left: -30px;
            position: relative;
            z-index: 10;
            font-size: .875rem;
            line-height: 1rem;
        }

        .infographic__description span {
            color: #15A3C4;
        }

        .infographic__description__shape {
            shape-outside: polygon(0% 0%, 100% 0%, 0% 100%);
            width: 25px;
            height: 100%;
            float: left;
        }

        .infographic__icon {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content:
            center;
            align-items: center;
        }

        .infographic__skew {
            transform: skew(-10deg);
            background: #DCE8EC;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .w-1\/4 {
            width: 25%;
        }
        .w-1\/2 {
            width: 50%;
        }
        .w-2\/5 {
            width: 40%;
        }
        .w-3\/5 {
            width: 60%;
        }
        .w-1\/3 {
            width: 33.33334%;
        }
    </style>
    <?php
}
