{{--
  Template Name: Downtime Actions Template
--}}

@php
  global $post;
  $user = wp_get_current_user();
  if (!$user) {
    header('Location:'.home_url('/'));
  }
@endphp

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <section class="grey">
      <div class="wrapper">
        <div class="row center-xs">
          <div class="col-xs-12">
            @include('partials.page-header')
          </div>
        </div>
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-xs-12">
            @include('partials.content-downtime-actions')
          </div>
        </div>
      </div>
    </section>
  @endwhile
@endsection
