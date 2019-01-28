{{--
  Template Name: Dashboard
--}}

@extends('layouts.dashboard')

@section('content')
  @php
      global $post;
  @endphp
  @while(have_posts()) @php the_post() @endphp
    <div class="section">
      <h2>Characters</h2>
      <form id="character-search">
        <label for="search">Filter Characters</label>
        <input name="search" type="search" />
        <button class="button" type="submit">Search</button>
      </form>
      @if(App\Characters::listActive())
        <ol class="characters">
          @foreach(App\Characters::listActive() as $post)
            @php(setup_postdata($post))
            <li>
              <a href="#">@php(the_title())</a>
              <div class="health">

              </div>
            </li>
          @endforeach
          @php(wp_reset_postdata())
        </ol>
      @endif
    </div>
  @endwhile
@endsection
