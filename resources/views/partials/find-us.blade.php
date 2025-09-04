<section class="tw-bg-gray-lighter">
  <div class="tw-container tw-py-8 lg:tw-py-12 xl:tw-py-16 md:tw-grid md:tw-grid-cols-2 md:tw-gap-8">
    @foreach ($social_media_find_us as $element)
      <div class="tw-mb-8 md:tw-mb-0 lg:tw-flex lg:tw-items-start">
        <div class="tw-hidden lg:tw-flex tw-items-center tw-mb-4">
          <div
            class="tw-mr-6"
          >
            <inline-svg
              name="{{$element['class']}}"
              class="tw-h-16 tw-w-16"
              svg-classes="tw-h-16 tw-w-16"
              style="color: {{ $element['color'] }}"
            ></inline-svg>
          </div>
        </div>

        <div>
          <div class="tw-flex tw-items-center tw-mb-4">
            <div
              class="lg:tw-hidden tw-rounded-full tw-inline-block tw-mr-4"
            >
              <inline-svg
                name="{{$element['class']}}"
                class="tw-h-12 tw-w-12"
                svg-classes="tw-h-12 tw-w-12"
                style="color: {{ $element['color'] }}"
              ></inline-svg>
            </div>

            <h4 class="tw-font-bold tw-text-lg tw-mb-0">Find us on {{$element['name']}}</h4>
          </div>

          <p class="tw-mb-4 tw-children-underline tw-children-font-bold">
            {!! $element['text'] !!}
          </p>

          <a
            href="{{ $element['url'] }}"
            target="_blank"
            rel="noopener noreferrer"
            class="tw-underline tw-font-bold"
          >Visit us on {{$element['name']}}</a>
        </div>
      </div>
    @endforeach
  </div>
</section>
