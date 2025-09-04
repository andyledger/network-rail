<div class="tw-block tw-overflow-hidden {{ !empty($noBorder) ? '' : 'tw-border-b tw-border-gray-light' }}">
  <div class="md:tw-container tw-pl-4 md:tw-pl-inherit tw-relative tw-py-3 md:tw-py-4 tw-h-40px md:tw-h-48px">
    <nav aria-label="breadcrumb" class="tw-block tw-overflow-x-scroll tw-pb-4 -tw-mt-4">
      <ul class="tw-flex tw-text-base">
        @foreach ($breadcrumbs as $element)
          <li class="tw-flex-shrink-0 <?php echo isset($element['link']) ? 'tw-flex tw-items-center' : 'tw-opacity-75'?> {{ $loop->last ? 'tw-pr-10' : null }}">
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
