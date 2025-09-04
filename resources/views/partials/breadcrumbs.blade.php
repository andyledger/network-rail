<div class="tw-hidden sm:tw-block {{ !empty($noBorder) ? '' : 'tw-border-b tw-border-gray-light' }}">
  <div class="tw-container tw-relative tw-py-3 md:tw-py-4">
    <nav aria-label="breadcrumb" class="tw-hidden sm:tw-block">
      <ul class="tw-flex tw-flex-wrap tw-text-base">
        @foreach ($breadcrumbs as $element)
          <li class="<?php echo isset($element['link']) ? 'tw-flex tw-items-center' : 'tw-opacity-75'?> tw-text-sm">
            @if ( isset($element['link']) )
              <a href="<?php echo $element['link']?>" class="tw-underline hover:tw-text-hyperlinks">
                {!! $element['title'] !!}
              </a>

              <inline-svg name="ut_arrow_right2" aria-hidden="true" class="tw-px-4"></inline-svg>
            @endif

            @if ( !isset($element['link']) )
              <span>
                {!! $element['title'] !!}
              </span>
            @endif
          </li>
        @endforeach
      </ul>
    </nav>
  </div>
</div>
