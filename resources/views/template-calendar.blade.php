{{--
  Template Name: Calendar Template
--}}

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
          <div class="col-md-8 col-md-offset-2 col-xs-12">
            @include('partials.content-calendar')
          </div>
        </div>
      </div>
    </section>
  @endwhile
@endsection
