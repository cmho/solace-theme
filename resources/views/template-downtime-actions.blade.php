{{--
  Template Name: Downtime Actions Template
--}}

@php
  if (!App\App::isAdmin() && $_GET['character'] == null) {
    $characters = get_posts(array(
      'post_type' => 'character',
      'post_author' => wp_get_current_user()->ID,
      'posts_per_page' => -1,
      'orderby' => 'date_modified',
      'order' => 'DESC',
      'meta_query' => array(
        array(
          'key' => 'status',
          'value' => 'Active'
        )
      )
    ));
    if (count($characters) > 0) {
      header('Location:'.App\App::downtimesLink().'?character='.$characters[0]->ID);
    } else {
      header('Location:'.App\App::dashboardLink());
    }
    die(1);
  }
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
            @include('partials.content-downtime-actions')
          </div>
        </div>
      </div>
    </section>
  @endwhile
@endsection
