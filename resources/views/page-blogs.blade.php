<?php use App\View\Composers\App; ?>

@extends('layouts.app')

@section('pre-content')
  @include('partials.page-header')
@endsection

@section('content')
  <div class="tw-flex tw-justify-between tw-items-center tw-mb-8 tw-flex-wrap">
    <h2 class="md:tw-text-5xl-i tw-text-gray-dark">
      {!! __('Featured blogs', 'sage') !!}
    </h2>

      @if (count($get_blogs) <= 2)
    <div class="tw-flex tw-items-center tw-min-w-300">
      <n-dropdown-menu
        class="tw-z-10 n-dropdown-menu tw-w-full"
        label="Category: {{ App::get_taxonomy_name_by_slug('cat_name', 'blog_category') }}"
        :items="{{ json_encode($dropdown_blog_categories) }}"
      ></n-dropdown-menu>
    </div>
      @endif
  </div>

  @php($counter = 1)

  <section class="tw-mb-8 tw-grid md:tw-grid-cols-2 tw-gap-8">
    @foreach ($get_blogs as $element)
      @if ($counter <= 2)
    <card
      title="{{ get_the_title($element->ID) }}"
      class="card-xl-component"
      description="{{ wp_trim_words( get_the_content(null, false, $element->ID), 30, '...') }}"
      image="{{ get_the_post_thumbnail_url($element->ID) }}"
      link="{{ get_permalink($element->ID) }}"
      alt-image="{{ App::alt_image($element->ID) }}"
      date="{{ get_the_date('M j, Y', $element->ID) }}"
    ></card>
      @endif

      @if ($counter == 2)
  </section>
      @endif

      @if (count($get_blogs) > 2 && $counter == 2)
  <div class="tw-pb-12">
    <div class="tw-border-t tw-border-gray-light"></div>
  </div>

  <div class="tw-flex tw-justify-between tw-items-center tw-mb-8 tw-flex-wrap">
    <h2 class="md:tw-text-5xl-i tw-text-gray-dark">
      {!! __('More blogs from Network Rail', 'sage') !!}
    </h2>

    <div class="tw-flex tw-items-center tw-min-w-300">
      <n-dropdown-menu
        class="tw-z-10 n-dropdown-menu tw-w-full"
        label="Category: {{ App::get_taxonomy_name_by_slug('cat_name', 'blog_category') }}"
        :items="{{ json_encode($dropdown_blog_categories) }}"
      ></n-dropdown-menu>
    </div>
  </div>
      @endif
  
      @if (count($get_blogs) > 2 && $counter == 2)
  <section class="tw-grid md:tw-grid-cols-2 xl:tw-grid-cols-4 tw-gap-8 tw-mb-8 xxx">
      @endif

      @if ($counter > 2)
    <card
      title="{{ get_the_title($element->ID) }}"
      class="card-component"
      description="{{ wp_trim_words( get_the_content(null, false, $element->ID), 30, '...') }}"
      image="{{ get_the_post_thumbnail_url($element->ID) }}"
      link="{{ get_permalink($element->ID)}}"
      alt-image="{{ App::alt_image($element->ID) }}"
      date="{{ get_the_date('M j, Y', $element->ID) }}"
      four-columns
    ></card>
      @endif

      @php($counter++)
    @endforeach
  </section>
@endsection
