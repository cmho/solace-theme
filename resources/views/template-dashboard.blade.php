{{--
  Template Name: Dashboard
--}}

@php
    global $post;
    $char = App::currentCharacter();
@endphp

@extends('layouts.dashboard')

@section('header')
  <h1><a href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a></h1>
  @if (App::isAdmin())
    <form>
      <span class="beat-count">{{ App\Beat::count() }}</span> <button type="button" id="beat-button" class="large button">Beat!</button>
    </form>
  @endif
@endsection

@section('content')
  @if(App::isLoggedIn())
    <h2>{{ get_the_title($char->ID) }}</h2>
    <div class="character-sheet">
      <h3>Attributes</h3>
      <p><strong>Mental Attributes:</strong> Intelligence {{ get_field('intelligence', $char->ID) }}, Wits {{ get_field('wits', $char->ID) }}, Resolve {{ get_field('resolve' $char->ID) }}</p>
      <p><strong>Physical Attributes:</strong> Strength {{ get_field('strength', $char->ID) }}, Dexterity {{ get_field('dexterity', $char->ID) }}, Stamina {{ get_field('stamina', $char->ID) }}</p>
      <p><strong>Social Attributes:</strong> Presence {{ get_field('presence', $char->ID) }}, Manipulation {{ get_field('manipulation', $char->ID) }}, Composure {{ get_field('composure', $char->ID) }}</p>
      <h3>Skills</h3>

      <h3>Merits</h3>
      <h3>Equipment</h3>
      <h3>Conditions</h3>
    </div>
  @else
    <form id="login" action="login" method="post">
        <h2>Log In</h2>
        <p class="status"></p>
        <div class="form-row">
          <label for="username">Username</label>
          <input id="username" type="text" name="username">
        </div>
        <div class="form-row">
          <label for="password">Password</label>
          <input id="password" type="password" name="password">
        </div>
        <div class="form-row">
          <a class="lost" href="<?php echo wp_lostpassword_url(); ?>">Lost your password?</a>
        </div>
        <div class="form-row">
          <input class="button" type="submit" value="Log in" name="submit">
        </div>
        <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
    </form>
  @endif
@endsection
