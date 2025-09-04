<footer class="tw-bg-gray-darker tw-py-20">
  <div class="tw-container tw-flex tw-flex-col lg:tw-flex-row lg:tw-flex-row lg:tw-justify-between">

    <div class="lg:tw-w-3/4">
      <nav id="navigation-footer-1" aria-label="navigation-footer-1" class="tw-mb-8 tw-text-white">
        <ul role="menu" class="tw-flex tw-flex-col md:tw-flex-row md:tw-divide-x">
          @foreach (wp_get_nav_menu_items('Footer') as $key => $item)
          <li
            role="none"
            class="tw-text-lg tw-mb-2 md:tw-leading-4 {{ $key === 0 ? 'sm:tw-pr-4' : 'sm:tw-px-4'}}"
          >
            <a role="menuitem" href="{{ $item->url }}" class="hover:tw-text-primary-light tw-border-b hover:tw-border-b-primary tw-inline-block">{{ $item->title }}</a>
          </li>
          @endforeach
        </ul>
      </nav>

      <p class="tw-text-lg tw-mb-2 tw-text-white">
        <?php the_field('copyright', 'option'); ?>
      </p>

      <nav id="navigation-footer-2" aria-label="navigation-footer-2" class="tw-text-gray-mid">
        <ul role="menu" class="sm:tw-flex tw-flex-wrap sm:tw-divide-x">
          @foreach (wp_get_nav_menu_items('Footer 2') as $key => $item)
          <li
            role="none"
            class="tw-text-lg tw-mb-2 md:tw-leading-4 tw-border-gray-mid {{ $key === 0 ? 'sm:tw-pr-4' : 'sm:tw-px-4'}}"
          >
            <a role="menuitem" href="{{ $item->url }}" class="hover:tw-text-primary-light tw-border-b hover:tw-border-b-primary tw-inline-block">{{ $item->title }}</a>
          </li>
          @endforeach
        </ul>
      </nav>
    </div>

    <div class="tw-mt-8 lg:tw-mt-0 md:tw-flex md:tw-items-center lg:tw-flex-col lg:tw-justify-end lg:tw-items-start xl:tw-w-1/4 tw-text-gray-mid">
      <p class="tw-mr-4 tw-mb-4 md:tw-mb-0 lg:tw-mb-4 tw-text-xl tw-text-lighter">
        Follow us on:
      </p>

      <ul class="tw-flex">
        @foreach ($social_media_footer as $key => $item)
        <li
          class="tw-text-3xl tw-mr-4 tw-flex tw-justify-center tw-items-center"
        >
          <a
            href="{{ $item['link'] }}"
            aria-label="{{ $item['text'] }}"
            title="{{ $item['text'] }}"
            class="tw-text-gray-mid hover:tw-text-white"
          >
            <inline-svg name="{{ $item['icon'] }}" class="tw-relative tw-bottom-px tw-left-px" svg-classes="tw-h-10 tw-w-10"></inline-svg>
          </a>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
</footer>
