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
      <div class="button-row right roll-row">
        <button class="js-modal button small" data-modal-content-id="whatever-roller">Generate Card</button>
      </div>
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
                  <a href="{{ get_the_permalink() }}" target="_blank" class="full-sheet-link">Full Sheet <i class="fas fa-external-link-alt"></i></a>
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
                <div class="vitals">
                  <h4>Vitals</h4>
                  <dl>
                    <dt>Size</dt>
                    <dd>{{ get_field('size') }}</dd>
                    <dt>Speed</dt>
                    <dd>{{ get_field('strength')+5 }}</dd>
                    <dt>Defense</dt>
                    <dd>{{ min(get_field('wits'), get_field('dexterity'))+get_field('athletics') }}</dd>
                    <dt>Initiative Mod</dt>
                    <dd>{{ get_field('dexterity')+get_field('composure') }}</dd>
                  </dl>
                  <p><a href="#" class="js-modal button small" data-modal-content-id="combat-pls-help">combat cheat sheet</a></p>
                </div>
                <div class="conditions">
                  <h4>Conditions (<a href="#" class="js-modal" data-modal-content-id="condition-form">Add</a>)</h4>
                  <ul class="char-conditions">
                    @if(get_field('conditions'))
                      @foreach(get_field('conditions') as $condition)
                        <li>{{ $condition['condition']->post_title }}{{ $condition['note'] ? ' ('.$condition['note'].')' : '' }} <button type="button" class="button resolve-button">Resolve</button> <button class="delete-button" type="button"><i class="fas fa-trash"></i><span class="sr-only">Delete</span></button></li>
                      @endforeach
                    @endif
                  </ul>
                </div>
                <div class="char-equipment">
                  <h4>Equipment (<a href="#" class="js-modal" data-modal-content-id="equipment-form">Add</a>)</h4>
                  <ul class="equipment-list">
                    @if(get_field('equipment'))
                      @foreach(App\Equipment::sortEquipment(get_field('equipment')) as $equipment)
                        @include('partials.content-equipment-list', ['equipment' => $equipment])
                      @endforeach
                    @endif
                  </ul>
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
    <div id="combat-pls-help" class="hide">
      <h2>OH GOD WE'RE IN COMBAT HELP</h2>
      <ol>
        <li>Have players declare intent: can this be resolved without getting into rounds?</li>
        <li>If not, start down and dirty combat.</li>
        <li>Have all players generate initiative (either by drawing a card or app)</li>
        <li>Starting from the top initiative, each player takes an action:
          <ol>
            <li>Attack (usually str + brawl - defense, or dex + firearms (- defense if they're close-range)). Damage is successes + weapon damage - defender's applicable armor
              <ol>
                <li>If there are multiple people attacking the same person in a round, the defender's Defense decreases by one each round.</li>
              </ol>
            </li>
            <li>Move (equal to your speed). Can make an athletics draw to move faster.</li>
            <li>Retrieve an item/draw a weapon (unless quick draw)</li>
            <li>Take cover: barely concealed (-1), partially concealed (-1), substantially concealed (-3). If durability is greater than the weapon's damage, it can't break through the cover, though it subtracts from the durability with damage. Human shields have durability of stamina + armor and using them constitutes a breaking point.</li>
            <li>Misc: use an advantage, activate a Relic, look around at the environment, say a short phrase, etc.</li>
          </ol>
        </li>
        <li>Specific combat maneuvers:
          <ol>
            <li>Dodge: Add dex to their defense against all attacks this round, but forefeit other actions.</li>
            <li>Disarm: Dex + brawl - defense</li>
            <li>Grapple: str + brawl - defense. On exceptional success, pick a move from below list. Both characters in a grapple make a str+brawl on the lower initiative every turn. The winner picks a move. Either can also do dex+athletics to Break Free or Take Cover if they win.
              <ol>
                <li>Break Free from the grapple. You throw off your opponent; you’re both no longer grappling. Succeeding at this move is a reflexive action; you can take another action immediately afterwards.</li>
                <li>Control Weapon, either by drawing a weapon that you have holstered or turning your opponent’s weapon against him. You keep control until your opponent makes a Control Weapon move.</li>
                <li>Damage your opponent by dealing bruising damage equal to your drawn successes. If you previously succeeded at a Control Weapon action, add the weapon bonus to your successes and it becomes lethal damage.</li>
                <li>Disarm your opponent, removing a weapon from the grapple entirely. You must first have succeeded at a Control Weapon move.</li>
                <li>Drop Prone, throwing both of you to the ground (see Going Prone below). You must Break Free before rising.</li>
                <li>Clench your opponent in place. Both of you sacrifice your Defense against incoming attacks.</li>
                <li>Restrain your opponent with duct tape, zip ties, or a painful joint lock. Your opponent is immobilized. You can only use this move if you’ve already succeeded in a Hold move. If you use equipment to Restrain your opponent, you can leave the grapple.</li>
                <li>Shift you and your opponent up to your Speed. The path must be relatively clear of obstructions. At the end of the movement you may optionally Drop Prone as well.</li>
                <li>Take Cover using your opponent’s body. Any ranged attacks made until the end of the turn automatically hit him (see Human Shields above).</li>
              </ol>
            </li>
            <li>Feint: Dex+subterfuge, on a success opponent loses defense for the next turn. Successive attempts take an additional -2 every time.</li>
            <li>Covering Fire: Dex + firearms - 3, sacrifice defense, declare firing area. Characters in field either take the weapon's damage, or sacrifice their turn to find cover or drop prone.</li>
            <li>Killing Blow: Deal damage equal to their full pool + weapon damage while sacrificing defense. Defender must be restrained. Almost always a breaking point.</li>
            <li>Go Prone: Drop to ground. Ranged attacks take a -2, brawl/weaponry takes a +2. Getting up takes an action.</li>
            <li>Hold: wait until end of turn. Ask holding players at end of round if they want to act; if not, continue with next round as normal.</li>
          </ol>
        </li>
    </div>
    <div id="condition-form" class="hide">
      <form class="condition-form">
        <h2>Add Condition</h2>
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
      </form>
    </div>
    <div id="equipment-form" class="hide">
      <form class="equipment-form">
        <h2>Add Equipment</h2>
        <div class="form-row">
          <label for="item">Item</label>
          <select class="equipment_list" name="item">
            @foreach(App\Equipment::list() as $item)
              <option value="{{ $item->ID }}">{{ get_the_title($item->ID) }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-row">
          <label for="uses">Uses (if applicable)</label>
          <input type="number" value="" name="uses" />
        </div>
        <div class="form-row">
          <label for="note">Note</label>
          <textarea name="note" rows="4"></textarea>
        </div>
        <button type="button" class="button small add-equipment">Add</button>
      </form>
    </div>
    <div id="whatever-roller" class="hide">
        <span class="whatever-roll"></span>
      </div>
  @elseif(App::isLoggedIn())
    @if($char)
      @include('partials.content-dashboard-character')
      <div class="equipment tab-content" id="equipment">
        <h2>Equipment</h2>
        @if(get_field('equipment', $char))
          <ul class="equipment-list">
            @foreach(App\Equipment::sortEquipment(get_field('equipment', $char)) as $equipment)
              @include('partials.content-equipment-list', ['equipment' => $equipment])
            @endforeach
          </ul>
        @else
          <p><em>None.</em></p>
        @endif
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
          @foreach(App\Games::listGamesForRumors() as $game)
            <dt><a href="#">{{ $game->post_title }}</a></dt>
            <dd>
              <ul>
                @foreach(App\Rumors::listRumors($game->ID, $char->ID) as $rumor)
                  <li>{!! apply_filters('the_content', $rumor->post_content) !!}</li>
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
