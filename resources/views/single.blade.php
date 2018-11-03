@php
  $user = wp_get_current_user();
  $is_author = $post->post_author == wp_get_current_user()->ID;
  $is_admin = in_array('administrator', $user->roles);
  if (in_array(get_post_type(), array('downtime', 'character'))) {
    if (!$is_author && !$is_admin) {
      header('Location:'.home_url('/'));
    }
  }
@endphp

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-single-'.get_post_type())
  @endwhile
@endsection
