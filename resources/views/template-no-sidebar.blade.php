{{--
  Template Name: No sidebar
--}}

@extends('layouts.app')

@section('pre-content')
    @include('partials.page-header')
@endsection

@section('content')
  @while(have_posts()) @php(the_post())
    @php(the_content())
    @include('components.feedback-banner', ['centered' => false])
  @endwhile
@endsection
