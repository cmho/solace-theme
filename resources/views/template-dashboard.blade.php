{{--
  Template Name: Dashboard
--}}

@php
    global $post;
    $char = App\Character::currentChar();
@endphp

@extends('layouts.dashboard')

@section('header')
  <h1><a href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a></h1>
  <form>
    <span class="beat-count">{{ App\Beat::count() }}</span> @if (App::isAdmin())<button type="button" id="beat-button" class="large button">Beat!</button>@endif
  </form>
@endsection

@section('content')
  @if(App::isAdmin())
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
            <li class="character" data-character="{{ $post->ID }}">
              <h3><a href="#">@php(the_title())</a></h3>
              <div class="character-content">
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
                  <ul class="char-conditions">
                    @if(get_field('conditions'))
                      @foreach(get_field('conditions') as $condition)
                        <li>{{ $condition['condition']->post_title }}{{ $condition['note'] ? ' ('.$condition['note'].')' : '' }} <button type="button" class="button resolve-button">Resolve</button> <button class="delete-button" type="button"><i class="fas fa-trash"></i><span class="sr-only">Delete</span></button></li>
                      @endforeach
                    @endif
                  </ul>
                  <form class="condition-form">
                    <div class="row">
                      <div class="form-row" id="select-control">
                        <label for="conditions_list">Condition</label>
                        <select class="conditions_list" name="condition">
                          @foreach(App\Conditions::list() as $condition)
                            <option value="{{ $condition->ID }}">{{ get_the_title($condition->ID)}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-row" id="note-control">
                        <label for="note">Note</label>
                        <input type="text" name="note" class="condition_note" />
                      </div>
                    </div>
                    <button type="button" class="button small add-condition">Add</button>
                    <input type="hidden" name="conditions" val="{{ count(get_field('conditions')) }}" />
                  </form>
                </div>
                <div class="notes">
                  <h4>Storyteller Notes</h4>
                  <textarea name="st_notes">{!! get_field('st_notes') !!}</textarea>
                </div>
              </div>
            </li>
          @endforeach
          @php(wp_reset_postdata())
        </ol>
      @endif
    </section>
  @elseif(App::isLoggedIn())
    @if($char)
      @include('partials.content-dashboard-character')
      <div class="equipment tab-content" id="equipment">
        <h2>Equipment</h2>
        <ul class="equipment">
          @foreach(get_field('equipment', $char) as $equipment)
          <li>
            <strong>{{ get_the_title($equipment['item']->ID) }}</strong><br />
            <dl>
                <dt>Type</dt>
                <dd>{{ get_field('type', $equipment['item']->ID) }}</dd>
                @if(get_field('size', $equipment['item']->ID))
                  <dt>Size</dt>
                  <dd>{{ get_field('size', $equipment['item']->ID) }}</dd>
                @endif
                @if(get_field('durability', $equipment['item']->ID))
                  <dt>Durability</dt>
                  <dd>{{ get_field('durability', $equipment['item']->ID) }}</dd>
                @endif
                @if(get_field('damage', $equipment['item']->ID))
                  <dt>Damage</dt>
                  <dd>{{ get_field('damage', $equipment['item']->ID)}}</dd>
                @endif
                @if(get_field('initiative_modifier', $equipment['item']->ID))
                  <dt>Initiative Modifier</dt>
                  <dd>{{ get_field('initiative_modifier', $equipment['item']->ID)}}</dd>
                @endif
                @if(get_field('required_strength', $equipment['item']->ID))
                  <dt>Required Strength</dt>
                  <dd>{{ get_field('required_strength', $equipment['item']->ID) }}</dd>
                @endif
                @if(get_field('clip_size', $equipment['item']->ID))
                  <dt>Clip Size</dt>
                  <dd>@php(\App\Character::printSquares(get_field('clip_size', $equipment['item']->ID)))</dd>
                @endif
                @if(get_field('general_armor', $equipment['item']->ID))
                  <dt>General Armor</dt>
                  <dd>{{ get_field('general_armor', $equipment['item']->ID) }}</dd>
                @endif
                @if(get_field('ballistic_armor', $equipment['item']->ID))
                  <dt>Ballistic Armor</dt>
                  <dd>{{ get_field('ballistic_armor', $equipment['item']->ID) }}</dd>
                @endif
                @if(get_field('defense', $equipment['item']->ID))
                  <dt>Defense</dt>
                  <dd>{{ get_field('defense', $equipment['item']->ID) }}</dd>
                @endif
                @if(get_field('speed', $equipment['item']->ID))
                  <dt>Speed</dt>
                  <dd>{{ get_field('speed', $equipment['item']->ID) }}</dd>
                @endif
                @if(get_field('cost', $equipment['item']->ID))
                  <dt>Cost</dt>
                  <dd>{{ get_field('cost', $equipment['item']->ID) }}</dd>
                @endif
                <dt>Qualities</dt>
                <dd>{{ join(", ", get_field('qualities', $equipment['item']->ID)) }}</dd>
                <dt>Notes</dt>
                <dd>{!! $equipment['note'] !!}</dd>
            </dl>
          </li>
          @endforeach
        </ul>
      </div>
      <div class="downtime-actions tab-content" id="downtime">
        <h2>Downtime Actions</h2>
        <dl>
          @foreach(App\Downtimes::listDowntimes($char->ID) as $g => $actions)
            @php($game = get_post($g))
            <dt><a href="#">{{ $game->post_title }}</a></dt>
            <dd>
              @foreach($actions as $action)
                <div class="action">
                  <h3>{{ get_the_title($action->ID) }}</h3>
                  <p class="action-type"><strong>Action Type:</strong> {{ get_field('action_type', $action->ID) }}</p>
                  <p class="assets"><strong>Assets:</strong> {{ get_field('assets', $action->ID) }}</p>
                  <p class="goal"><strong>Goal:</strong> {{ get_field('goal', $action->ID) }}</p>
                  <div class="description">
                    {!! apply_filter('the_content', '<strong>Description:</strong> '.$action->post_content) !!}
                  </div>
                  <div class="response">
                    <strong>Response:</strong> {!! get_field('response', $action->ID) !!}
                  </div>
                </div>
              @endforeach
            </dd>
          @endforeach
        </dl>
      </div>
      <div class="rumors tab-content" id="rumor">
        <h2>Rumors</h2>
        <dl>
          @foreach(App\Games::listGames() as $game)
            <dt><a href="#">{{ $game->post_title }}</a></dt>
            <dd>
              <ul>
                @foreach(App\Rumors::listRumors($game->ID, $char->ID) as $rumor)
                  <li>{!! apply_filter('the_content', $rumor->post_content) !!}</li>
                @endforeach
              </ul>
            </dd>
          @endforeach
        </dl>
      </div>
      <div id="merits-modal" class="hidden">
        <div class="content" id="modal-content">
          <h4></h4>
          <div class="description"></div>
          <div class="prerequisites"></div>
        </div>
      </div>
      <nav class="dashboard-tabs">
        <div class="wrapper">
          <div class="row center-xs middle-xs">
            <div class="tab">
              <a href="#" id="character-tab">
                <div class="icon">
                  <i class="fas fa-user"></i>
                </div>
                <span>Character</span>
              </a>
            </div>
            <div class="tab">
              <a href="#" id="equipment-tab">
                <div class="icon">
                  <i class="fas fa-hammer"></i>
                </div>
                <span>Equipment</span>
              </a>
            </div>
            <div class="tab">
              <a href="#" id="downtime-tab">
                <div class="icon">
                  <i class="far fa-list-alt"></i>
                </div>
                <span>Downtimes</span>
              </a>
            </div>
            <div class="tab">
              <a href="#" id="rumor-tab">
                <div class="icon">
                  <i class="far fa-comments"></i>
                </div>
                <span>Rumors</span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div id="initiative-roller">
        <span class="initiative-roll"></span>
      </div>
    @endif
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
  <audio controls id="ding">
    <source src="{{get_theme_file_uri() }}/dist/media/ding.mp3" type="audio/mpeg"></source>
  </audio>
@endsection
