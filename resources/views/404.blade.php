@extends('splash.app')

@section('content')
  <div class="background">
    <img src="{{ get_field('404_background', 'option')['url'] }}" aria-hidden />
  </div>
  <div class="content">
    <h2>@include('partials.page-header')</h2>
    <p class="explanation">Page not found</p>
  </div>
@endsection