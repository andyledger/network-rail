<?php

/**
 * Register the block once ACF has initialized
 */
add_action( 'acf/init', function() {
 	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
 		acf_register_block( [
			'name'            => 'nr-acf-table',
			'title'           => __( 'NR Table' ),
			'description'     => __( 'Create a table' ),
			'render_callback' => 'nr_acf_table_callback',
			'category'        => 'common',
			'icon' 			  => ['foreground' => '#e56430','src' => 'menu'],
			'mode' 			  => 'edit'
		] );
	}
 });

 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_table_callback( $block ) {
	$headings = get_field('table_headings');
    $headingCount = count($headings);
	?>
	<?php if (!empty($headings)): ?>

        <div class="tw-overflow-x-auto tw-my-12">
            <table class="table-block tw-table-auto tw-w-full sortable" tabindex="0">
                <caption class="tw-text-3xl tw-mb-8 tw-text-left"><?php the_field('caption');?></caption>
                <thead class="tw-text-lg md:tw-text-xl tw-border-b-2">
                    <tr>
                        <?php foreach($headings as $column) : ?>
                            <th class="tw-py-5 tw-text-left tw-pr-4 tw-whitespace-nowrap" scope="col">
                                <div class="tw-flex tw-items-center">
                                    <?php echo $column['heading_title'];?>
                                </div>
                            </th>
                        <?php endforeach;?>
                    </tr>
                </thead>
                <tbody class="tw-border-b-2 tw-border-gray-light tw-text-md md:tw-text-lg tw-text-gray-dark">
                <?php foreach(get_field('table_rows') as $row) : ?>
                    <tr class="tw-border-b-2 tw-border-gray-light tw-text-md md:tw-text-lg tw-text-gray-dark">
                        <?php
                            $colCount = !empty($row['row']) ? count($row['row']) : 0;
                        ?>
                        <?php if ($colCount) : ?>
                            <?php foreach ($row['row'] as $key => $column) : ?>
                                <?php
                                    if (($key + 1) > $headingCount) {
                                        break;
                                    }

                                    $dataSort = null;

                                    if ($column['content_type'] === 'date') {
                                        $date = DateTime::createFromFormat('d/m/Y', $column['date']);

                                        $dataSort = $date->format('Ymd');
                                    }

                                    $tagType = !empty($column['is_heading']) ? 'th' : 'td';
                                ?>

                                <?php if ($tagType === 'th') : ?>
                                    <th class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-4 tw-text-left tw-align-top table-content" <?php echo $key === 0 ? 'scope="row"' : null;?> data-sort="<?php echo $dataSort?>">
                                <?php endif;?>

                                <?php if ($tagType === 'td') : ?>
                                    <td class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-4 tw-text-left tw-align-top table-content" data-sort="<?php echo $dataSort?>">
                                <?php endif;?>

                                    <?php
                                        if ($column['content_type'] === 'text') {
                                            echo $column['content'];
                                        }

                                        if ($column['content_type'] === 'date') {
                                            echo $column['date'];
                                        }
                                    ?>

                                <?php if ($tagType === 'th') : ?>
                                    </th>
                                <?php endif;?>

                                <?php if ($tagType === 'td') : ?>
                                    </td>
                                <?php endif;?>

                            <?php endforeach;?>
                        <?php endif;?>

                        <?php if ($colCount < $headingCount) : ?>

                            <?php for($colCount; $colCount < $headingCount; $colCount++) : ?>

                                <td class="tw-py-2 md:tw-py-3 lg:tw-py-5 tw-pr-4 table-content" <?php echo $colCount === 0 ? 'scope="row"' : null;?>>
                                   &nbsp;
                                </td>

                            <?php endfor;?>
                        <?php endif;?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>

	<?php endif ?>
	<?php
}
