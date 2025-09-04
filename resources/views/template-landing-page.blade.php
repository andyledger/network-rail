{{--
  Template Name: Landing page
--}}

@extends('layouts.app')

@section('pre-content')
    @include('partials.page-landing-header')
@endsection

@section('content')
  @while(have_posts()) @php(the_post())
    @php(the_content())
    @include('components.feedback-banner', ['centered' => false])
  @endwhile
@endsection
