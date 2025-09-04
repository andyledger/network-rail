@extends('layouts.app')

@section('pre-content')
  @include('partials.page-header')
@endsection

@section('content')
  @if ( is_404() )
    <x-alert type="warning" class="tw-text-3xl">
      {!! __('Sorry, but the page you are trying to view does not exist.', 'sage') !!}
    </x-alert>
  @endif
@endsection
