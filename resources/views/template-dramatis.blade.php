{{--
  Template Name: Dramatis Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <section class="grey" id="dramatis">
      <div class="wrapper">
        <div class="row center-xs">
          <div class="col-xs-12">
            @include('partials.page-header')
          </div>
        </div>
        <div class="row">
          @include('partials.content-dramatis')
        </div>
      </div>
    </section>
  @endwhile
@endsection
