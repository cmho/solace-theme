{{--
  Template Name: Character List Template
--}}

@php
  $user = wp_get_current_user();
  $is_admin = in_array('administrator', $user->roles);
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
          <div class="col-xs-12">
            @include('partials.content-character-list')
          </div>
        </div>
      </div>
    </section>
  @endwhile
@endsection
