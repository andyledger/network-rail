<section class="tw-bg-gray-lighter">
  <div class="tw-container tw-py-8 lg:tw-py-12 xl:tw-py-16 md:tw-grid md:tw-grid-cols-2 md:tw-gap-8">
    <?php $__currentLoopData = $social_media_find_us; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="tw-mb-8 md:tw-mb-0 lg:tw-flex lg:tw-items-start">
        <div class="tw-hidden lg:tw-flex tw-items-center tw-mb-4">
          <div 
            class="tw-rounded-full tw-p-2 tw-inline-block tw-mr-6" 
            style="background: <?php echo e($element['color']); ?>"
          >
            <inline-svg 
              name="<?php echo e($element['class']); ?>" 
              class="tw-text-white tw-text-4xl lg:tw-text-7xl"
            ></inline-svg>
          </div>
        </div>

        <div>
          <div class="tw-flex tw-items-center tw-mb-4">
            <div 
              class="lg:tw-hidden tw-rounded-full tw-p-2 tw-inline-block tw-mr-6"
              style="background: <?php echo e($element['color']); ?>"
            >
              <inline-svg 
                name="<?php echo e($element['class']); ?>" 
                class="tw-text-white tw-text-4xl lg:tw-text-7xl"
              ></inline-svg>
            </div>

            <h4 class="tw-font-bold tw-text-lg">Find us on <?php echo e($element['name']); ?></h4>
          </div>

          <p class="tw-mb-4 tw-children-underline tw-children-font-bold">
            <?php echo $element['text']; ?>

          </p>

          <a 
            href="<?php echo e($element['url']); ?>" 
            target="_blank" 
            class="tw-underline tw-font-bold"
          >Visit us on <?php echo e($element['name']); ?></a>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</section>
<?php /**PATH /Users/jerometoole/code/wholegrain-projects/network-rail/wp-content/themes/network-rail/resources/views/partials/find-us.blade.php ENDPATH**/ ?>