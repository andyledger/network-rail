<article <?php (post_class()); ?>>
  <?php if(has_post_thumbnail()): ?>
    <div class="tw-mb-4">
      <figure>
        <n-img
          alt="<?php echo e(App\View\Composers\App::alt_image($post)); ?>"
          lazy-src="<?php echo e($on_the_fly_feature_image); ?>"
        ></n-img>

        <?php if(get_the_post_thumbnail_caption()): ?>
          <figcaption>
            <?php echo e(get_the_post_thumbnail_caption()); ?>

          </figcaption>
        <?php endif; ?>
      </figure>
    </div>
  <?php endif; ?>

  <div class="entry-content prose">
    <?php (the_content()); ?>
  </div>
</article>
<?php /**PATH /Users/jerometoole/code/wholegrain-projects/network-rail/wp-content/themes/network-rail/resources/views/partials/content-single.blade.php ENDPATH**/ ?>