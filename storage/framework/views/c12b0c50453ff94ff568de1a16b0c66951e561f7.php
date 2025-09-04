<h1 class="tw-sr-only">Home</h1>

<?php $__env->startSection('pre-content'); ?>
  <?php if(get_field('alert_message_activate', 'option')): ?>
    <emergency-banner
      title="<?php echo e(get_field('alert_message_title', 'option')); ?>"
      description="<?php echo e(get_field('alert_message', 'option')); ?>"
    ></emergency-banner>
  <?php endif; ?>

  <main-slider :slides="<?php echo e(json_encode($main_slider)); ?>"></main-slider>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <section class="tw-mb-8 tw-grid md:tw-grid-cols-2 tw-gap-8 tw-pt-4">
    <card
      v-for="(item, i) in <?php echo e(json_encode($main_stories)); ?>"
      class="card-xl-component"
      :key="i"
      :title="item.title"
      :description="item.description"
      :image="item.imgUrl"
      :link="item.link"
      :alt-image="item.altImage"
    ></card>
  </section>

  <div class="tw-pb-12">
    <div class="tw-border-t tw-border-gray-light"></div>
  </div>

  <section class="sm:tw-flex tw-justify-between tw-mb-8">
    <h2 class="h2-stories tw-mb-4 sm:tw-mb-0 tw-text-3xl lg:tw-text-5xl tw-text-gray-dark">
      <?php echo __('Stories around our network', 'sage'); ?>

    </h2>

    <div class="tw-flex tw-items-center">
      <a 
        href="<?php echo e(get_permalink( get_option( 'page_for_posts' ) )); ?>" 
        class="tw-cursor-pointer tw-border tw-border-gray-light tw-p-3 tw-text-sm tw-text-gray-dark tw-rounded tw-inline-flex tw-items-center tw-justify-between"
      >
        <span class="tw-mr-8">
          More stories
        </span>

        <inline-svg name="ut_arrow_right2"></inline-svg>
      </a>
    </div>
  </section>

  <section class="tw-grid md:tw-grid-cols-2 xl:tw-grid-cols-4 tw-gap-8 tw-mb-8">
    <card
      v-for="(item, i) in <?php echo e(json_encode($stories_around)); ?>"
      class="card-component"
      :key="i"
      :title="item.title"
      :description="item.description"
      :image="item.imgUrl"
      :link="item.link"
      :date="item.date"
      :alt-image="item.altImage"
      four-columns
    ></card>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pre-footer'); ?>
  <?php echo $__env->make('partials.find-us', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /nas/content/live/newnetworkrail/wp-content/themes/network-rail/resources/views/front-page.blade.php ENDPATH**/ ?>