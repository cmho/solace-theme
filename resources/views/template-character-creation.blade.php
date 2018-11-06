{{--
  Template Name: Character Creation Template
--}}

@php
  $user = wp_get_current_user();
  // TODO: redirect if no current user
  $is_admin = in_array('administrator', $user->roles);
@endphp

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <div id="character-sheet">
      <section class="grey">
        <div class="wrapper">
          <div class="row center-xs">
            <div class="col-xs-12">
              @include('partials.page-header')
            </div>
          </div>
        </div>
      </section>
      @if($_GET['method'] == 'wizard')

      @else
        @include('partials.content-character-form')
      @endif
    </div>
  @endwhile
@endsection
