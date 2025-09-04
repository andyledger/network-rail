<header class="site-header tw-z-50 tw-bg-white tw-inset-x-0 tw-top-0" :class="{'active tw-fixed': isMenuOpen}" role="banner">
  <div class="site-header__inner xl:tw-container tw-grid tw-h-full tw-justify-center tw-items-center xl:tw-justify-between tw-p-4 tw-relative">
    <n-menu-button
      :open="!isMenuOpen"
      v-on:click="openMenu()"
      class="xl:tw-hidden"
      :aria-expanded="[isMenuOpen ? 'true' : 'false']"
      aria-controls="the-phone-menu"
    ></n-menu-button>

    <the-phone-menu
      id="the-phone-menu"
      :open="!isMenuOpen"
      :items="{{ json_encode($menu) }}"
    ></the-phone-menu>

    <a
      href="/"
      class="tw-block site-logo"
      aria-label="Network Rail - Home"
    >
      <inline-svg
        name="{{ $logo_type }}"
        :ratio="0.4"
        class="tw-text-12xl tw-text-primary"
      ></inline-svg>
    </a>

    <nav class="tw-hidden xl:tw-block">
      <ul class="tw-justify-center tw-flex tw-flex-grow tw-gap-x-8 2xl:tw-gap-x-10">
        @foreach ($menu as $key => $item)
          <li
            class="tw-relative tw-py-5 tw-cursor-pointer"
            @mouseleave="onMouseLeave({{ $key }})"
            @mouseover="updateActiveItem({{ $key }})"
          >
            <div class="tw-flex tw-items-center">
              <a
                href="{{ $item->url }}"
                class="tw-font-bold tw-text-md tw-flex-grow tw-flex-shrink-0"
                @focus="clearActiveItem({{ $key }})"
              >
                <span>{{ $item->title }}</span>
              </a>

              @if ($item->child_items)
                <button type="button" :aria-label="activeItem === {{ $key }} ? 'Close submenu' : 'Show {{ $item->title }} submenu'" :aria-expanded="activeItem === {{ $key }} ? 'true' : 'false'" class="tw-w-4 2xl:tw-w-7 tw-h-10 tw-flex tw-justify-center tw-items-center tw-flex-shrink-0" @click="toggleActiveItem({{ $key }})">
                  <svg style="fill: currentColor" width="1em" height="1em" class="tw-transition tw-transform" :class="activeItem === {{ $key }} ? 'tw-rotate-0' : 'tw-rotate-180'" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"> <path fill="currentColor" d="M168.5 164.2l148 146.8c4.7 4.7 4.7 12.3 0 17l-19.8 19.8c-4.7 4.7-12.3 4.7-17 0L160 229.3 40.3 347.8c-4.7 4.7-12.3 4.7-17 0L3.5 328c-4.7-4.7-4.7-12.3 0-17l148-146.8c4.7-4.7 12.3-4.7 17 0z"></path> </svg>
                </button>
              @endif
            </div>

            <div
              class="tw-absolute tw-left-1/2 tw-z-10 tw-transition-fade tw-duration-200 tw-top-full "
              :class="[{{ $key }} === activeItem ? 'tw-visible tw-opacity-100' : 'tw-invisible tw-opacity-0']"
            >
              <div class="tw--left-1/2 tw-relative tw-shadow-brand tw-min-w-300">
                @if ($item->child_items)
                <div
                  class="tw-bg-white"
                >
                  <div class="tw-arrow-up"></div>

                  <ul class="tw-px-8 tw-py-3">
                    @foreach ($item->child_items as $child)
                    <li
                      class="tw-py-2 tw-py-2 tw-border-b tw-border-gray-light hover:tw-border-hyperlinks hover:tw-text-hyperlinks"
                    >
                      <a
                        href="{{ $child->url }}"
                        class="tw-text-lg tw-block"
                      >
                        {{ $child->title }}
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                @endif
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </nav>

    <div class="tw-text-gray-dark tw-w-64 tw-hidden md:tw-block tw-justify-self-end">
      <algolia-search
        class-state-results="tw-w-96 tw-absolute tw-right-4 tw-translate-y-3 tw-transform"
      ></algolia-search>
    </div>

    <div
      class="md:tw-hidden tw-cursor-pointer tw-z-10 tw-justify-self-end"
      v-on:click="displaySearchPhone()"
    >
      <inline-svg
        v-show="!isSearchPhone"
        type="button"
        name="nr_magnifying_glass"
        class="tw-text-3xl tw-block"
        aria-label="Open Search"
      ></inline-svg>

      <inline-svg
        v-show="isSearchPhone"
        type="button"
        name="ut_close"
        class="tw-text-3xl tw-block"
        aria-label="Close Search"
      ></inline-svg>
    </div>

    <div
      v-show="isSearchPhone"
      class="site-header__search__input tw-absolute tw-left-0 tw-w-full tw-container md:tw-hidden tw-mt-4"
    >
      <algolia-search
        class-state-results="tw-w-full tw-top-4 inset-x-0"
      ></algolia-search>
    </div>
  </div>
</header>
<div class="site-header__spacer tw-hidden" aria-hidden="true"></div>
<div
  class="tw-fixed tw-inset-0 tw-z-40 tw-bg-black tw-transition-opacity tw-duration-500"
  :class="[isMenuOpen ? 'tw-opacity-50' : 'tw-opacity-0 tw-pointer-events-none']"
></div>