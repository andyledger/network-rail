<?php $__env->startSection('pre-content'); ?>
  <?php echo $__env->make('partials.page-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if(have_posts()): ?>
    <?php ($counter = 1); ?>

    <h2 class="md:tw-text-5xl-i tw-text-gray-dark tw-mb-8-i">
      <?php echo __('Recommended stories', 'sage'); ?>

    </h2>

    <section class="tw-mb-8 tw-grid md:tw-grid-cols-2 tw-gap-8">
      <?php while(have_posts()): ?> <?php (the_post()); ?>
        <?php if($counter <= 2): ?>
          <card
            title="<?php echo e(get_the_title()); ?>"
            class="card-xl-component"
            description="<?php echo e(wp_trim_words( get_the_content(), 30, '...')); ?>"
            image="<?php echo e(get_the_post_thumbnail_url()); ?>"
            link="<?php echo e(get_permalink()); ?>"
            alt-image="<?php echo e(App\View\Composers\App::alt_image(get_the_ID())); ?>"
            date="<?php echo e(get_the_date()); ?>"
          ></card>
        <?php endif; ?>

        <?php if($counter == 2): ?>
          </section>

          <div class="tw-pb-12">
            <div class="tw-border-t tw-border-gray-light"></div>
          </div>

          <div class="tw-flex tw-justify-between tw-items-center tw-mb-8 tw-flex-wrap">
            <h2 class="md:tw-text-5xl-i tw-text-gray-dark">
              <?php echo __('More stories from around our network', 'sage'); ?>

            </h2>

            <div class="tw-flex tw-items-center tw-min-w-300">
              <n-dropdown-menu
                class="tw-z-10 n-dropdown-menu tw-w-full"
                label="Category: <?php echo e($dropdown_title); ?>"
                :items="<?php echo e(json_encode($dropdown_categories)); ?>"
              ></n-dropdown-menu>
            </div>
          </div>

          <section class="tw-grid md:tw-grid-cols-2 xl:tw-grid-cols-4 tw-gap-8 tw-mb-8">
        <?php endif; ?>

        <?php if($counter > 2): ?>
          <card
            title="<?php echo e(get_the_title()); ?>"
            class="card-component"
            description="<?php echo e(wp_trim_words( get_the_content(), 30, '...')); ?>"
            image="<?php echo e(get_the_post_thumbnail_url()); ?>"
            link="<?php echo e(get_permalink()); ?>"
            alt-image="<?php echo e(App\View\Composers\App::alt_image(get_the_ID())); ?>"
            date="<?php echo e(get_the_date('M j, Y')); ?>"
            four-columns
          ></card>
        <?php endif; ?>

        <?php ($counter++); ?>
      <?php endwhile; ?>
    </section>
  <?php endif; ?>

  <div class="tw-flex tw-flex-col md:tw-flex-row md:tw-justify-between md:tw-items-center tw-text-xl">
    <?php echo $pagination_results; ?>


    <?php echo $custom_pagination; ?>

  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /nas/content/live/newnetworkrail/wp-content/themes/network-rail/resources/views/home.blade.php ENDPATH**/ ?>