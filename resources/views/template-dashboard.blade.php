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
            <li data-character="{{ $post->ID }}">
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
                  @if(get_field('conditions'))
                    <ul class="char-conditions">
                      @foreach(get_field('conditions') as $condition)
                        <li>{{ $condition['condition']->post_title }}{{ $condition['note'] ? ' ('.$condition['note'].')' : '' }} <button type="button" class="button resolve-button">Resolve</button></li>
                      @endforeach
                    </ul>
                  @endif
                  <form id="condition-form">
                    <div class="row">
                      <div class="form-row" id="select-control">
                        <label for="conditions_list">Condition</label>
                        <select id="conditions_list">
                          @foreach(App\Conditions::list() as $condition)
                            <option value="{{ $condition->ID }}">{{ get_the_title($condition->ID)}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-row" id="note-control">
                        <label for="condition_note">Note</label>
                        <input type="text" name="condition_note" id="condition_note" />
                      </div>
                    </div>
                    <button type="button" class="button small add-condition">Add</button>
                    <input type="hidden" name="conditions" val="{{ count(get_field('conditions')) }}" />
                  </form>
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
      <div class="character-sheet" data-id="{{ $char->ID }}">
        <h2>{{ get_the_title($char->ID) }}</h2>
        <div class="character-content">
          <div class="health" data-health="{{ get_field('current_health', $char->ID) }}">
            <h3>Health</h3>
            {{ App\Character::printSquaresInteractable(get_field('current_health', $char->ID)) }}
          </div>
          <div class="willpower" data-willpower="{{ get_field('current_willpower', $char->ID) }}">
            <h3>Willpower</h3>
            {{ App\Character::printSquaresInteractable(get_field('current_willpower', $char->ID)) }}
          </div>
          <p><strong>Virtue:</strong> {{ get_field('virtue', $char->ID) }}</p>
          <p><strong>Vice:</strong> {{ get_field('vice', $char->ID) }}</p>
          <p><strong>Integrity:</strong> <span class="current-integrity">{{ get_field('integrity', $char->ID) }}</span></p>
          <h3>Attributes</h3>
          <p><strong>Mental Attributes:</strong> Intelligence {{ get_field('intelligence', $char->ID) }}, Wits {{ get_field('wits', $char->ID) }}, Resolve {{ get_field('resolve', $char->ID) }}</p>
          <p><strong>Physical Attributes:</strong> Strength {{ get_field('strength', $char->ID) }}, Dexterity {{ get_field('dexterity', $char->ID) }}, Stamina {{ get_field('stamina', $char->ID) }}</p>
          <p><strong>Social Attributes:</strong> Presence {{ get_field('presence', $char->ID) }}, Manipulation {{ get_field('manipulation', $char->ID) }}, Composure {{ get_field('composure', $char->ID) }}</p>

          <h3>Skills</h3>
          <p><strong>Mental Skills:</strong> {{ App\Character::mentalSkillsSimple($char->ID) }}</p>
          <p><strong>Physical Skills:</strong> {{ App\Character::physicalSkillsSimple($char->ID) }}</p>
          <p><strong>Social Skills:</strong> {{ App\Character::socialSkillsSimple($char->ID) }}</p>

          <h3>Merits</h3>
          <p>{{ App\Character::meritsSimple($char->ID) }}</p>

          <h3>Equipment</h3>
          @if(get_field('equipment', $char->ID))
            <ul>
              @foreach(get_field('equipment', $char->ID) as $equipment)
                <li>
                  <strong>{{ get_the_title($equipment['item']->ID) }}</strong><br />
                  <dl>
                    <dt>Type</dt>
                    <dd>{{ get_field('type', $equipment['item']->ID) }}</dd>
                    <dt>Size</dt>
                    <dd>{{ get_field('size', $equipment['item']->ID) }}</dd>
                    <dt>Durability</dt>
                    <dd>{{ get_field('durability', $equipment['item']->ID) }}</dd>
                    <dt>Qualities</dt>
                    <dd>{{ join(", ", get_field('qualities', $equipment['item']->ID)) }}</dd>
                    <dt>Notes</dt>
                    <dd>{{ $equipment['note'] }}</dd>
                  </dl>
                </li>
              @endforeach
            </ul>
          @else
            <p><em>None.</em></p>
          @endif

          <h3>Conditions</h3>
          @if(get_field('conditions', $char->ID))
            <ul class="conditions">
              @foreach(get_field('conditions', $char->ID) as $condition)
              <li><strong>{{ get_the_title($condition['condition']->ID) }}</strong><br />
                {{ $condition['note'] }}
              </li>
              @endforeach
            </ul>
          @else
            <p><em>None.</em></p>
          @endif

          <h3>Vitals</h3>
          <p><strong>Size:</strong> {{ get_field('size', $char->ID) }}</p>
          <p><strong>Speed:</strong> {{ get_field('strength', $char->ID)+get_field('dexterity', $char->ID)+5 }}</p>
          <p><strong>Defense:</strong> {{ min(get_field('wits'), get_field('dexterity'))+get_field('athletics') }}</p>
          <p><strong>Armor:</strong> {{ get_field('armor', $char->ID) }}</p>
          <p><strong>Initiative Mod:</strong> {{ get_field('dexterity', $char->ID)+get_field('composure', $char->ID) }}</p>
        </div>
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
