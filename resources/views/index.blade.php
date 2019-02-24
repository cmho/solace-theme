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
            @include('partials.content-'.get_post_type())
          @endwhile

          {!! get_the_posts_navigation() !!}
        </div>
      </div>
    </div>
  </section>
@endsection
