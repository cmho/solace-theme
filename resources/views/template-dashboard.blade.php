{{--
  Template Name: Dashboard
--}}

@php
    global $post;
@endphp

@extends('layouts.dashboard')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <div class="section">
      <h2>Characters</h2>
      <form id="character-search">
        <label for="search">Filter Characters</label>
        <input name="search" type="search" />
        <button class="button" type="submit">Search</button>
      </form>
      @if(App\Characters::activeList())
        <ol class="characters">
          @foreach(App\Characters::activeList() as $post)
            @php(setup_postdata($post))
            <li>
              <h3><a href="#">@php(the_title())</a></h3>
              <div class="health">
                <h4>Health</h4>
                {{ App\Character::printSquaresInteractable(get_field('health_current')) }}
              </div>
              <div class="willpower">
                <h4>Willpower</h4>
                {{ App\Character::printSquaresInteractable(get_field('willpower_current')) }}
              </div>
            </li>
          @endforeach
          @php(wp_reset_postdata())
        </ol>
      @endif
    </div>
  @endwhile
@endsection
