@extends('layouts.app')

@section('pre-content')
  @include('partials.page-header')
@endsection

@section('content')
  @if (have_posts())
    @php($counter = 1)

    <h2 class="md:tw-text-5xl-i tw-text-gray-dark tw-mb-8-i">
      {!! __('Recommended stories', 'sage') !!}
    </h2>

    <section class="tw-mb-8 tw-grid md:tw-grid-cols-2 tw-gap-8">
      @while (have_posts()) @php(the_post())
        @if ($counter <= 2)
          <card
            title="{{ get_the_title() }}"
            class="card-xl-component"
            description="{{ wp_trim_words( get_the_content(), 30, '...') }}"
            image="{{ get_the_post_thumbnail_url() }}"
            link="{{ get_permalink() }}"
            alt-image="{{ App\View\Composers\App::alt_image(get_the_ID()) }}"
            date="{{ get_the_date() }}"
          ></card>
        @endif

        @if ($counter == 2)
          </section>

          <div class="tw-pb-12">
            <div class="tw-border-t tw-border-gray-light"></div>
          </div>

          <div class="tw-flex tw-justify-between tw-items-center tw-mb-8 tw-flex-wrap">
            <h2 class="md:tw-text-5xl-i tw-text-gray-dark">
              {!! __('More stories from around our network', 'sage') !!}
            </h2>

            <div class="tw-flex tw-items-center tw-min-w-300">
              <n-dropdown-menu
                class="tw-z-10 n-dropdown-menu tw-w-full"
                label="Category: {{ $dropdown_title }}"
                :items="{{ json_encode($dropdown_categories) }}"
              ></n-dropdown-menu>
            </div>
          </div>

          <section class="tw-grid md:tw-grid-cols-2 xl:tw-grid-cols-4 tw-gap-8 tw-mb-8">
        @endif

        @if ($counter > 2)
          <card
            title="{{ get_the_title() }}"
            class="card-component"
            description="{{ wp_trim_words( get_the_content(), 30, '...') }}"
            image="{{ get_the_post_thumbnail_url() }}"
            link="{{ get_permalink()}}"
            alt-image="{{ App\View\Composers\App::alt_image(get_the_ID()) }}"
            date="{{ get_the_date('M j, Y') }}"
            four-columns
          ></card>
        @endif

        @php($counter++)
      @endwhile
    </section>
  @endif

  <div class="tw-flex tw-flex-col md:tw-flex-row md:tw-justify-between md:tw-items-center tw-text-xl">
    {!! $pagination_results !!}

    {!! $custom_pagination !!}
  </div>
@endsection
