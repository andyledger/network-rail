@extends('layouts.app')

@section('pre-content')
  @if (get_field('alert_message_activate', 'option'))
    <emergency-banner
      title="{{ get_field('alert_message_title', 'option') }}"
      description="{{ get_field('alert_message', 'option') }}"
    ></emergency-banner>
  @endif

  <h1 class="tw-sr-only">Network Rail homepage</h1>

  <main-slider :slides="{{ json_encode($main_slider) }}"></main-slider>
@endsection

@section('content')

  @include('components.feedback-banner', ['centered' => true])

  <section class="tw-mb-8 tw-grid md:tw-grid-cols-2 tw-gap-8 tw-pt-4">
    <card
      v-for="(item, i) in {{ json_encode($main_stories) }}"
      class="card-xl-component"
      :key="i"
      :title="item.title"
      :description="item.description"
      :image="item.imgUrl"
      :link="item.link"
      :alt-image="item.altImage"
    ></card>
  </section>

  <div class="tw-pb-12">
    <div class="tw-border-t tw-border-gray-light"></div>
  </div>

  <section class="sm:tw-flex tw-justify-between tw-mb-8">
    <h2>
      {!! __('Stories around our network', 'sage') !!}
    </h2>

    <div class="tw-flex tw-items-center">
      <a href="{{ get_home_url() }}/stories" class="tw-cursor-pointer tw-border tw-border-gray-light tw-p-3 tw-text-sm tw-text-gray-dark tw-rounded tw-inline-flex tw-items-center tw-justify-between tw-underline hover:tw-text-hyperlinks">
        <span class="tw-mr-8">
          More stories
        </span>

        <inline-svg name="ut_arrow_right2"></inline-svg>
      </a>
    </div>
  </section>

  <section class="tw-grid md:tw-grid-cols-2 xl:tw-grid-cols-4 tw-gap-8 tw-mb-8">
    <card
      v-for="(item, i) in {{ json_encode($stories_around) }}"
      class="card-component"
      :key="i"
      :title="item.title"
      :description="item.description"
      :image="item.imgUrl"
      :link="item.link"
      :date="item.date"
      :alt-image="item.altImage"
      four-columns
    ></card>
  </section>
@endsection

@section('pre-footer')
  @include('partials.find-us')
@endsection
