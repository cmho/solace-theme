{{--
  Template Name: Print All Template
--}}

@extends('layouts.print')

@section('content')
  @foreach(App\Characters::activeList() as $post)
    @php(setup_postdata($post))
    <article>
      @include('partials.content-single-character')
    </article>
  @endforeach
  @php(wp_reset_postdata())
@endsection
