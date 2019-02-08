{{--
  Template Name: Dashboard
--}}

@php
    global $post;
@endphp

@extends('layouts.dashboard')

@section('header')
  <h1><a href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a></h1>
  <form>
    <span class="beat-count">{{ App\Beat::count() }}</span> <button type="button" id="beat-button" class="large button">Beat!</button>
  </form>
@endsection

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <section>
      <form id="character-search">
        <label for="search">Filter Characters</label>
        <input name="search" type="search" />
        <button class="button" type="submit">Search</button>
      </form>
      @if(App\Characters::activeList())
        <ol class="characters">
          @foreach(App\Characters::activeList() as $post)
            @php(setup_postdata($post))
            <li data-character="{{ $post->ID }}">
              <h3><a href="#">@php(the_title())</a></h3>
              <div class="health" data-health="{{ get_field('current_health') }}">
                <h4>Health</h4>
                {{ App\Character::printSquaresInteractable(get_field('current_health')) }}
              </div>
              <div class="willpower" data-willpower="{{ get_field('current_willpower') }}">
                <h4>Willpower</h4>
                {{ App\Character::printSquaresInteractable(get_field('current_willpower')) }}
              </div>
              <div class="integrity">
                <h4>Integrity</h4>
                <span class="current-integrity">{{ get_field('integrity') }}</span> <button type="button" class="button small breaking-point">Breaking Point</button>
              </div>
              <div class="conditions">
                <h4>Conditions</h4>
                <form>
                  <label for="conditions_list">Condition</label>
                  <select id="conditions_list">
                    @foreach(App\Conditions::list() as $condition)
                      <option value="{{ $condition->ID }}">{{ get_the_title($condition->ID)}}</option>
                    @endforeach
                  </select>
                  <label for="condition_note">Note</label>
                  <input type="text" name="condition_note" id="condition_note" />
                  <button type="button" class="button small" id="add-condition">Add</button>
                  <input type="hidden" name="conditions" val="{{ count(get_field('conditions')) }}" />
                </form>
                @if(get_field('conditions'))
                  <ul>
                    @foreach(get_field('conditions') as $condition)
                      <li><strong>{{ get_the_title($condition['condition']->ID) }}</strong> <button type="button" class="button small resolve-button">Resolve</button><br />
                        {{ $condition['note'] }}
                      </li>
                    @endforeach
                  </ul>
                @endif
              </div>
            </li>
          @endforeach
          @php(wp_reset_postdata())
        </ol>
      @endif
    </section>
    <audio controls id="ding">
      <source src="{{get_theme_file_uri() }}/dist/media/ding.mp3" type="audio/mpeg"></source>
    </audio>
  @endwhile
@endsection
