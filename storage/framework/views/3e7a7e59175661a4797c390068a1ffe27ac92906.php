<div class="tw-hidden sm:tw-block tw-border-b tw-border-gray-light">
  <div class="tw-container tw-relative tw-py-3 md:tw-py-4">
    <nav aria-label="breadcrumb" class="tw-hidden sm:tw-block">
      <ul class="tw-flex tw-flex-wrap tw-text-base">
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="<?php echo isset($element['link']) ? 'tw-flex tw-items-center' : 'tw-opacity-75'?>">
            <?php if( isset($element['link']) ): ?>
              <a href="<?php echo $element['link']?>" class="tw-underline hover:tw-text-hyperlinks">
                <?php echo $element['title']; ?>

              </a>

              <inline-svg name="ut_arrow_right2" class="tw-px-4"></inline-svg>
            <?php endif; ?>           
          </li>

          <?php if( !isset($element['link']) ): ?>
            <span>
              <?php echo $element['title']; ?>

            </span>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </nav>
  </div>
</div><?php /**PATH /Users/jerometoole/code/wholegrain-projects/network-rail/wp-content/themes/network-rail/resources/views/partials/breadcrumbs.blade.php ENDPATH**/ ?>