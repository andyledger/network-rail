@extends('layouts.app')

@section('pre-content')
  @include('partials.page-header')
@endsection

@section('content')
  <algolia-search-page></algolia-search-page>
@endsection
