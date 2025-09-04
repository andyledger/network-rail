<footer class="tw-bg-gray-darker tw-py-20">
  <div class="tw-container tw-flex tw-flex-col lg:tw-flex-row-reverse lg:tw-flex-row lg:tw-justify-between">
    <div class="tw-mb-8 lg:tw-mb-0 md:tw-flex md:tw-items-center lg:tw-flex-col lg:tw-justify-end lg:tw-items-start xl:tw-flex-row xl:tw-items-end xl:tw-w-1/3 tw-text-gray-medium">
      <p class="tw-mr-4 tw-mb-4 md:tw-mb-0 xl:tw-mb-0 lg:tw-mb-4 tw-text-xl tw-text-lighter">
        Follow us on:
      </p>

      <ul class="tw-flex">
        <li
          v-for="(item, i) in <?php echo e(json_encode($social_media_footer)); ?>"
          :key="i"
          class="tw-text-3xl tw-mr-4 tw-w-10 tw-h-10 tw-bg-gray-medium tw-text-gray-darker tw-rounded-full tw-flex tw-justify-center tw-items-center hover:tw-bg-primary"
        >
          <a 
            :href="item.link" 
            :aria-label="item.text"
            :title="item.text"
          >
            <inline-svg :name="item.icon" class="tw-relative tw-bottom-px tw-left-px"></inline-svg>
          </a>
        </li>
      </ul>
    </div>

    <div class="lg:tw-w-2/3">
      <nav id="navigation-footer-1" aria-label="navigation-footer-1" class="tw-mb-8 tw-text-white">
        <ul role="menu" class="tw-flex tw-flex-col md:tw-flex-row md:tw-divide-x">
          <li
            role="none"
            v-for="(item, i) in <?php echo e(json_encode(wp_get_nav_menu_items('Footer'))); ?>"
            :key="i"
            class="tw-text-lg tw-mb-2 md:tw-leading-4"
            :class="[i === 0 ? 'md:tw-pr-4' : 'md:tw-px-4']"
          >
            <a role="menuitem" :href="item.url" class="hover:tw-text-primary tw-border-b hover:tw-border-b-primary tw-inline-block">{{ item.title }}</a>
          </li>
        </ul>
      </nav>

      <p class="tw-text-base tw-mb-2 tw-text-white">
        <?php the_field('copyright', 'option'); ?>
      </p>

      <nav id="navigation-footer-2" aria-label="navigation-footer-2" class="tw-text-gray-medium">
        <ul role="menu" class="sm:tw-flex tw-flex-wrap sm:tw-divide-x">
          <li
            role="none"
            v-for="(item, i) in <?php echo e(json_encode(wp_get_nav_menu_items('Footer 2'))); ?>"
            :key="i"
            class="tw-text-xs tw-leading-3 tw-mb-2 tw-border-gray-medium"
            :class="[i === 0 ? 'sm:tw-pr-4' : 'sm:tw-px-4']"
          >
            <a role="menuitem" :href="item.url" class="hover:tw-text-primary tw-border-b hover:tw-border-b-primary tw-inline-block">{{ item.title }}</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</footer>
<?php /**PATH /Users/jerometoole/code/wholegrain-projects/network-rail/wp-content/themes/network-rail/resources/views/partials/footer.blade.php ENDPATH**/ ?>