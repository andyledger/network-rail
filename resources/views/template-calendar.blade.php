{{--
  Template Name: Calendar
--}}

@extends('layouts.app', ['classes' => 'calendar-container'])

@section('pre-content')
    @include('partials.page-header')
@endsection

@section('content')
  @while(have_posts()) @php(the_post())
    @php(the_content())
    @include('components.feedback-banner', ['centered' => true])
  @endwhile
@endsection
