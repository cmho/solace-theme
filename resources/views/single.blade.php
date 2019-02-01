@php
  $user = wp_get_current_user();
  $is_author = $post->post_author == wp_get_current_user()->ID;
  $is_admin = in_array('administrator', $user->roles);
  if (in_array(get_post_type(), array('downtime', 'character'))) {
    if (!$is_author && !$is_admin) {
      header('Location:'.home_url('/'));
    } else if (get_post_type() == 'character' && get_query_var('mode') == 'edit' && get_field('status') != 'in_progress' && App\Character::sumExperience() <= 0) {
      header('Location:'.get_the_permalink($post));
    }
  }
@endphp

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-single-'.get_post_type())
  @endwhile
@endsection
