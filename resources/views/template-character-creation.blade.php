{{--
  Template Name: Character Creation Template
--}}

@php
  $user = wp_get_current_user();
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
        <form action="{{ esc_url( admin_url('admin-post.php') ) }}" method="POST">
          @include('partials.content-basics')
          <input type="hidden" name="action" value="new_character" />
          <input type="submit" value="Save Character" />
        </form>
      @endif
    </div>
  @endwhile
@endsection
