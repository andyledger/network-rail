<div
  class="tw-relative tw-bg-primary tw-flex tw-items-end tw-h-40 md:tw-h-48 lg:tw-h-56 xl:tw-h-64 2xl:tw-h-72"
>
  <div class="tw-container tw-relative tw-mb-8 md:tw-mb-12">
    <h1
      class="tw-text-3xl md:tw-text-5xl lg:tw-text-6xl tw-font-bold tw-text-white"
    >{!! $title !!}</h1>
  </div>
</div>

@if (!is_single())
  @include('partials.breadcrumbs')
@endif

@if (is_single())
  <div class="tw-border-b tw-border-gray-light">
    <div class="tw-container tw-relative tw-py-3 md:tw-py-4">
      <time
        datetime="{{ $post->post_date }}"
        class="tw-text-lg"
      >{{ get_the_date('F j, Y', $post) }}</time>
    </div>
  </div>
@endif