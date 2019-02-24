@php
  global $wp_query;
@endphp

@extends('layouts.app')

@section('content')
  <section class="grey">
    <div class="wrapper">
      <div class="row center-xs">
        <div class="col-xs-12">
          @include('partials.page-header')
          @if (!have_posts())
            <div class="alert alert-warning">
              {{ __('Sorry, no results were found.', 'sage') }}
            </div>
            {!! get_search_form(false) !!}
          @endif

          @while (have_posts()) @php the_post() @endphp
            <div class="col-md-6 col-xs-12">
              <div class="box">
                @include('partials.content')
              </div>
            </div>
          @endwhile
          @if($wp_query->current_post % 2 == 1)
            <div class="col-md-6 col-xs-12 end-card">
              *
            </div>
          @endif

          {!! get_the_posts_navigation() !!}
        </div>
      </div>
    </div>
  </section>
@endsection
