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
          <section id="character-sheet" class="grey">
            <div class="wrapper">
              @include('partials.content-basics')
              @include('partials.content-attributes')
              @include('partials.content-skills-merits-misc')
            </div>
          </section>
          <section id="questionnaire" class="yellow">
            <div class="wrapper">
              <div class="row">
                <div class="col-xs-12">
                  <h3>Questionnaire</h3>
                  @include('partials.content-questionnaire')
                </div>
              </div>
            </div>
          </section>
          <section id="controls" class="grey">
            <div class="wrapper">
              <div class="row">
                <div class="col-xs-12">
                  <input type="hidden" name="author" value="{{ wp_current_user()->ID }}" />
                  <input type="hidden" name="action" value="update_character" />
                  <input type="submit" value="Save Character" />
                </div>
              </div>
            </div>
          </div>
        </form>
      @endif
    </div>
  @endwhile
@endsection
