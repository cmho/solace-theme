@php
  global $wp_query;
@endphp

@extends('layouts.app')

@section('content')
  <section class="grey">
    <div class="wrapper">
      <div class="row center-xs">
        @include('partials.page-header')
      </div>
      <div class="row">
        @php
          $count = 0;
        @endphp
        @if (!have_posts())
          <div class="alert alert-warning col-xs-12">
            {{ __('Sorry, no results were found.', 'sage') }}
          </div>
          {!! get_search_form(false) !!}
        @endif

        @while (have_posts()) @php the_post() @endphp
          @php
            $count++;
          @endphp
          <div class="col-md-6 col-xs-12">
            <div class="box">
              @include('partials.content')
            </div>
          </div>
        @endwhile
        @if($count > 0 && $count % 2 == 1)
          <div class="col-md-6 col-xs-12 end-card">
            *
          </div>
        @endif


        {!! get_the_posts_navigation() !!}
      </div>
    </div>
  </section>
@endsection
