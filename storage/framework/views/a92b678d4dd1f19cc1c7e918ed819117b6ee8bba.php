<?php use App\View\Composers\App; ?>



<?php $__env->startSection('pre-content'); ?>
  <?php echo $__env->make('partials.page-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div class="tw-flex tw-justify-between tw-items-center tw-mb-8 tw-flex-wrap">
    <h2 class="md:tw-text-5xl-i tw-text-gray-dark">
      <?php echo __('Featured blogs', 'sage'); ?>

    </h2>

      <?php if(count($get_blogs) <= 2): ?>
    <div class="tw-flex tw-items-center tw-min-w-300">
      <n-dropdown-menu
        class="tw-z-10 n-dropdown-menu tw-w-full"
        label="Category: <?php echo e(App::get_taxonomy_name_by_slug('cat_name', 'blog_category')); ?>"
        :items="<?php echo e(json_encode($dropdown_blog_categories)); ?>"
      ></n-dropdown-menu>
    </div>
      <?php endif; ?>
  </div>

  <?php ($counter = 1); ?>

  <section class="tw-mb-8 tw-grid md:tw-grid-cols-2 tw-gap-8">
    <?php $__currentLoopData = $get_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if($counter <= 2): ?>
    <card
      title="<?php echo e(get_the_title($element->ID)); ?>"
      class="card-xl-component"
      description="<?php echo e(wp_trim_words( get_the_content(null, false, $element->ID), 30, '...')); ?>"
      image="<?php echo e(get_the_post_thumbnail_url($element->ID)); ?>"
      link="<?php echo e(get_permalink($element->ID)); ?>"
      alt-image="<?php echo e(App::alt_image($element->ID)); ?>"
      date="<?php echo e(get_the_date('M j, Y', $element->ID)); ?>"
    ></card>
      <?php endif; ?>

      <?php if($counter == 2): ?>
  </section>
      <?php endif; ?>

      <?php if(count($get_blogs) > 2 && $counter == 2): ?>
  <div class="tw-pb-12">
    <div class="tw-border-t tw-border-gray-light"></div>
  </div>

  <div class="tw-flex tw-justify-between tw-items-center tw-mb-8 tw-flex-wrap">
    <h2 class="md:tw-text-5xl-i tw-text-gray-dark">
      <?php echo __('More blogs from Network Rail', 'sage'); ?>

    </h2>

    <div class="tw-flex tw-items-center tw-min-w-300">
      <n-dropdown-menu
        class="tw-z-10 n-dropdown-menu tw-w-full"
        label="Category: <?php echo e(App::get_taxonomy_name_by_slug('cat_name', 'blog_category')); ?>"
        :items="<?php echo e(json_encode($dropdown_blog_categories)); ?>"
      ></n-dropdown-menu>
    </div>
  </div>
      <?php endif; ?>
  
      <?php if(count($get_blogs) > 2 && $counter == 2): ?>
  <section class="tw-grid md:tw-grid-cols-2 xl:tw-grid-cols-4 tw-gap-8 tw-mb-8 xxx">
      <?php endif; ?>

      <?php if($counter > 2): ?>
    <card
      title="<?php echo e(get_the_title($element->ID)); ?>"
      class="card-component"
      description="<?php echo e(wp_trim_words( get_the_content(null, false, $element->ID), 30, '...')); ?>"
      image="<?php echo e(get_the_post_thumbnail_url($element->ID)); ?>"
      link="<?php echo e(get_permalink($element->ID)); ?>"
      alt-image="<?php echo e(App::alt_image($element->ID)); ?>"
      date="<?php echo e(get_the_date('M j, Y', $element->ID)); ?>"
      four-columns
    ></card>
      <?php endif; ?>

      <?php ($counter++); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /nas/content/live/newnetworkrail/wp-content/themes/network-rail/resources/views/page-blogs.blade.php ENDPATH**/ ?>