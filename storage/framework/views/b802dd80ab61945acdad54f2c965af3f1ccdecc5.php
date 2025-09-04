<?php $__env->startSection('pre-content'); ?>
    <?php echo $__env->make('partials.page-landing-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php (the_post()); ?>
    <?php (the_content()); ?>
  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/jerometoole/code/wholegrain-projects/network-rail/wp-content/themes/network-rail/resources/views/template-landing-page.blade.php ENDPATH**/ ?>