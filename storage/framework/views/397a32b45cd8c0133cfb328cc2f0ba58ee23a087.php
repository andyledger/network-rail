<div class="tw-relative tw-flex tw-flex-col tw-justify-between tw-min-h-screen" id="content-app">
  <a class="tw-sr-only focus:tw-not-sr-only" href="#main">
    <?php echo e(__('Skip to content')); ?>

  </a>

  <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <?php echo $__env->yieldContent('pre-content'); ?>

  <div class="tw-container tw-flex-grow lg:tw-flex tw-py-12">
    <?php if (! empty(trim($__env->yieldContent('sidebar')))): ?>
      <aside class="tw-hidden lg:tw-block lg:tw-w-1/4 lg:tw-pr-6">
        <?php echo $__env->yieldContent('sidebar'); ?>
      </aside>
    <?php endif; ?>

    <?php if (! empty(trim($__env->yieldContent('sidebar')))): ?>
      <main id="main" class="lg:tw-w-3/4 prose">
        <?php echo $__env->yieldContent('content'); ?>
      </main>
    <?php else: ?>
      <main id="main" class="prose">
        <?php echo $__env->yieldContent('content'); ?>
      </main>
    <?php endif; ?>
  </div>

  <?php echo $__env->yieldContent('pre-footer'); ?>

  <?php if($is_safespaces): ?>
    <?php echo $__env->make('partials.safe-spaces', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php endif; ?>
  
  <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php /**PATH /nas/content/live/newnetworkrail/wp-content/themes/network-rail/resources/views/layouts/app.blade.php ENDPATH**/ ?>