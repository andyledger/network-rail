<?php if(is_page('blocks-reference-guide')): ?>
  <div class="tw-text-3xl tw-font-bold tw-mb-6">Blocks</div>

  <ul class="tw-text-lg tw-mb-4">
    <?php $__currentLoopData = $menu = wp_get_nav_menu_items('blocks-reference-guide'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li>
        <a class="hover:tw-text-hyperlinks hover:tw-underline" href="<?php echo e($item->url); ?>"><?php echo e($item->title); ?></a>
      </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </ul>
<?php endif; ?>

<?php if(is_page() && !is_page('blocks-reference-guide')): ?>
  <?php echo e($child_pages); ?>

<?php endif; ?>

<?php if(is_singular('post')): ?>
  <?php echo $menu_categories_child_of_stories; ?>


  <?php (dynamic_sidebar('sidebar-primary')); ?>
<?php endif; ?>

<?php if(is_singular('blog')): ?>
  <?php echo $menu_blog_categories; ?>


  <?php (dynamic_sidebar('sidebar-primary')); ?>
<?php endif; ?>


<div></div>



<?php /**PATH /Users/jerometoole/code/wholegrain-projects/network-rail/wp-content/themes/network-rail/resources/views/partials/sidebar.blade.php ENDPATH**/ ?>