<?php

/**
 * Register the block once ACF has initialized
 */
add_action('acf/init', function () {
    // check function exists
    if (function_exists('acf_register_block')) {
        acf_register_block([
            'name'            => 'nr-acf-file-list',
            'title'           => __('NR File list'),
            'description'     => __('Display file list custom post type'),
            'render_callback' => 'nr_acf_file_list_callback',
            'category'        => 'common',
            'icon' 			  => ['foreground' => '#e56430','src' => 'list-view'],
            'mode' 			  => 'edit'
        ]);
    }
});

 /**
 * Render Callback for the block. This is what is output in the Theme AND
 * in the preview within Gutenberg
 *
 * @param $block
 */
function nr_acf_file_list_callback($block)
{
    $title = get_field('title');
    $description = get_field('description');
    $file_list = get_field('files_to_download');

    if ($file_list) {
        $file_list_title = $file_list->post_title;
        $file_list = get_field('download_list', $file_list->ID);
    } ?>

	<?php if (isset($file_list) && !empty($file_list)): ?>
		<?php if ($title): ?>
			<h3><?php echo $title ?></h3>
		<?php endif ?>
		
		<?php if ($description): ?>
			<p><?php echo $description ?></p>
		<?php endif ?>

		<div class="tw-mb-8">
			<?php foreach ($file_list as $key => $element): ?>
				<?php if ($element['file']): ?>
					<div
						class="tw-py-4 tw-border-b tw-border-gray-light"
						:class="{'tw-border-t' : <?php echo $key ?> === 0 }"
					>
		      			<a 
		      				href="<?php echo $element['file']['url'] ?>" 
		      				class="tw-flex tw-justify-between file-list"
		      			>
					        <div class="tw-font-bold tw-text-lg md:tw-text-xl tw-pr-4 hover:tw-text-hyperlinks hover:tw-underline">
					        	<?php echo (!empty($element['title'])) ? $element['title'] : $element['file']['title'] ?>
					        </div>

					        <div class="tw-flex tw-items-center tw-justify-end">
					        	<?php if (is_admin()): ?>
					        		<div class="tw-text-primary tw-text-3xl">
										<svg style="fill: currentColor" width="1em" height="1em" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 16"><path d="M8.433,15.302l-0.012,0c-0.126,0.001 -0.252,-0.045 -0.348,-0.137c-0.031,-0.031 -0.057,-0.064 -0.078,-0.099l-2.896,-2.793c-0.189,-0.182 -0.189,-0.477 0,-0.66c0.189,-0.182 0.495,-0.182 0.684,0l2.149,2.072l0,-6.511c0,-0.263 0.222,-0.478 0.495,-0.478c0.274,0 0.496,0.215 0.496,0.478l0,6.511l2.148,-2.072c0.189,-0.182 0.496,-0.182 0.685,0c0.189,0.183 0.189,0.478 0,0.66l-2.896,2.793c-0.022,0.035 -0.047,0.068 -0.078,0.099c-0.096,0.092 -0.223,0.138 -0.349,0.137Zm-4.467,-1.94c-2.231,-0.237 -3.966,-2.061 -3.966,-4.275c0,-2.079 1.529,-3.814 3.561,-4.215c0.417,-1.96 2.215,-3.433 4.371,-3.433c1.984,0 3.665,1.248 4.245,2.975c2.109,0.451 3.686,2.265 3.686,4.434c0,1.917 -1.231,3.556 -2.974,4.221l0,-1.05c1.179,-0.601 1.983,-1.796 1.983,-3.171c0,-1.911 -1.551,-3.473 -3.505,-3.58c-0.238,-1.624 -1.685,-2.874 -3.435,-2.874c-1.909,0 -3.459,1.487 -3.471,3.325l0,0.022c-1.916,0 -3.47,1.497 -3.47,3.346c0,1.686 1.293,3.08 2.975,3.312l0,0.963Z"></path></svg>
					        		</div>
					        	<?php endif ?>

					        	<?php if (!is_admin()): ?>
									<inline-svg
										name="ut_download"
										class="tw-text-primary tw-text-3xl"
									></inline-svg>
					        	<?php endif ?>

								<div class="tw-text-xl tw-text-gray-medium tw-min-w-75 tw-text-right">
									<?php echo App\View\Composers\App::human_filesize($element['file']['filesize']) ?>
								</div>
							</div>	      		
				      	</a>

				      	<?php if ($element['desc']): ?>
				      		<div class="tw-hidden md:tw-block tw-pt-1 tw-text-base">
				      			<?php echo $element['desc']; ?>
				      		</div>
				      	<?php endif ?>
		        	</div>
	        	<?php endif ?>
			<?php endforeach ?>
		</div>
	<?php endif ?>
	<?php
}
