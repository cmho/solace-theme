{{--
  Template Name: Custom Template
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
      </div>
    </section>
    @include('partials.content-custom')
  @endwhile
@endsection
