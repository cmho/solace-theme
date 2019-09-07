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
      <div id="characters" class="tab-content">
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
                    <p><a href="#combat" class="tab-link button small" data-id="references-tab">combat cheat sheet</a></p>
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
      </div>
      <div id="roll" class="tab-content">
        <div class="button-row center roll-row">
          <button class="button">Generate Card</button>
        </div>
        <span class="whatever-roll"></span>
      </div>
      <div id="references" class="tab-content">
        <h2>References</h2>
        <div id="combat" class="combat">
          <h2>OH GOD WE'RE IN COMBAT HELP</h2>
          <div class="combat-content">
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
            </ol>
          </div>
        </div>
      </div>
      <div id="equipment" class="tab-content">
        
      </div>
      <div id="tools" class="tab-content">
        <h2>Heal All Characters</h2>
        <form class="heal-form">
          <div>
            <label for="weeks_field">Weeks of Healing</label>
            <input type="number" class="weeks-field" name="weeks_field" />
          </div>
          <button class="button small heal-button" type="button">Heal</button>
        </form>
        <h2>Grant XP</h2>
        <form class="xp-form">
          <div>
            <label for="character">Character</label>
            <select name="character">
              <option value="all">All</option>
              @foreach(\App\Characters::getActivePCs() as $char)
                <option value="{{$char->ID}}">{{$char->post_title}}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label for="reason">Reason</label>
            <input type="text" name="reason" />
          </div>
          <div>
            <label for="amount">Amount</label>
            <input type="number" name="amount" />
          </div>
          <button class="button small xp-button" type="submit">Grant</button>
        </form>
      </div>
    </section>
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
    <nav class="dashboard-tabs">
      <div class="wrapper">
        <div class="row center-xs middle-xs">
          <div class="tab">
            <a href="#" data-id="characters-tab">
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
              <span>Characters</span>
            </a>
          </div>
          <div class="tab">
            <a href="#" data-id="roll-tab">
              <div class="icon">
                <i class="fas fa-dice"></i>
              </div>
              <span>Card Draw</span>
            </a>
          </div>
          <div class="tab">
            <a href="#" data-id="equipment-tab">
              <div class="icon">
                <i class="fas fa-hammer"></i>
              </div>
              <span>Equipment</span>
            </a>
          </div>
          <div class="tab">
            <a href="#" data-id="references-tab">
              <div class="icon">
                <i class="fas fa-book"></i>
              </div>
              <span>Reference</span>
            </a>
          </div>
          <div class="tab">
            <a href="#" data-id="tools-tab">
              <div class="icon">
                <i class="fas fa-tools"></i>
              </div>
              <span>Tools</span>
            </a>
          </div>
        </div>
      </div>
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
        <dl id="downtimes">
          @foreach(App\Downtimes::listDowntimes($char->ID) as $g => $actions)
            @php($game = get_post($g))
            <dt><a href="#">{{ $game->post_title }}</a></dt>
            <dd>
              @if($actions)
                @foreach($actions as $action)
                  <div class="action">
                    <h3>{{ get_the_title($action->ID) }}</h3>
                    <p class="action-type"><strong>Action Type:</strong> {{ ucwords(get_field('action_type', $action->ID)) }}</p>
                    <p class="assets"><strong>Assets:</strong> {{ get_field('assets', $action->ID) }}</p>
                    <p class="goal"><strong>Goal:</strong> {{ get_field('goal', $action->ID) }}</p>
                    <div class="description">
                      {!! apply_filters('the_content', '<strong>Description:</strong> '.$action->post_content) !!}
                    </div>
                    @if(get_field('response', $action->ID))
                      <div class="response">
                        <strong>Response:</strong> {!! get_field('response', $action->ID) !!}
                      </div>
                    @endif
                  </div>
                @endforeach
              @endif
            </dd>
          @endforeach
        </dl>
      </div>
      <div class="rumors tab-content" id="rumor">
        <h2>Rumors</h2>
        <dl id="rumors">
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
              <a href="#" data-id="character-tab">
                <div class="icon">
                  <i class="fas fa-user"></i>
                </div>
                <span>Character</span>
              </a>
            </div>
            <div class="tab">
              <a href="#" data-id="equipment-tab">
                <div class="icon">
                  <i class="fas fa-hammer"></i>
                </div>
                <span>Equipment</span>
              </a>
            </div>
            <div class="tab">
              <a href="#" data-id="downtime-tab">
                <div class="icon">
                  <i class="far fa-list-alt"></i>
                </div>
                <span>Downtimes</span>
              </a>
            </div>
            <div class="tab">
              <a href="#" data-id="rumor-tab">
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
      <div id="virtues" class="hide">
        @php($virtue = get_field('virtue', $char))
        <h2>Virtue: {{ $virtue }}</h2>
        @if($virtue == 'Hopeful')
          <p>Somehow, your character doesn’t despair at the World of Darkness but remains optimistic, believing that everything will work out eventually. Regain Willpower when your character refuses to abandon hope, putting herself at risk in expectation of a better tomorrow.</p>
        @elseif($virtue == 'Loving')
          <p>Your character is defined by a great love, perhaps for an ideal or an institution, but usually for a person or group of people. Regain Willpower when your character puts themselves in danger for the object of their love.</p>
        @elseif($virtue == 'Honest')
          <p>Your character’s defining duty is to the truth. Although the World of Darkness puts every pressure on her to dissemble or tell white lies to protect others, her sense of self is built on fundamental honesty. Regain Willpower when your character puts herself in danger by refusing to lie.</p>
        @elseif($virtue == 'Humble')
          <p>Your character doesn’t want power or status. Even if he earns a position of authority, he sees himself as one of the guys. Putting himself above others would deny the importance of their lives. Regain Willpower when your character turns down the opportunity for power that would solve his problems.</p>
        @elseif($virtue == 'Trustworthy')
          <p>When your character makes a promise, she keeps it. Her sense of self relies on others being able to trust and believe in her. Regain Willpower when she keeps a promise, even only an implied one, despite keeping it putting her at risk.</p>
        @elseif($virtue == 'Loyal')
          <p>Your character is loyal to a group, possibly the other player’s characters. His loyalty isn’t blind—he’s capable of seeing the flaws in whatever cause he’s signed up to—but once given it’s unshakable. Regain Willpower when he puts himself in danger by refusing to act against the group’s interests.</p>
        @elseif($virtue == 'Ambitious')
          <p>Your character is going places. She has goals she wants to accomplish, and the drive to achieve them. In some people who don’t deserve the accolades they seek, ambition is a Vice—for her it’s a guiding mission. Regain Willpower when your character puts herself at risk for the sake of following her long-term goal.</p>
        @elseif($virtue == 'Just')
          <p>Your character is driven by a sense of fair play and justice—the desire to see everyone get what they deserve. They’ll stick their neck out to make sure everyone is treated fairly, even if that acts against their own interests. That includes punishing those who deserve it and owning up to their own wrongdoing. Regain Willpower when your character’s drive for Justice leaves their own goals half-done.</p>
        @elseif($virtue == 'Peaceful')
          <p>Your character is a pacifist in a dirty, dangerous world. Whether it’s because of deeply-held religious beliefs, philosophical decision or simple lack of stomach for violence, he can’t bring himself to hurt another human being. Regain Willpower when your character resolves a conflict that puts him at risk without the use of bloodshed.</p>
        @elseif($virtue == 'Generous')
          <p>Your character gains comfort from giving to others. They might be especially charitable or just be willing to lend possessions and aid to her friends, no questions asked. They’re often taken for granted, but they know they make a difference. Regain Willpower when your character has deprived themselves of a vital resource through their generosity, putting themselves at risk.</p>
        @elseif($virtue == 'Righteous')
          <p>Your character knows he walks in a corrupt world and he’s angry about it. He’s willing to confront hypocrisy and evil where he sees it, no matter who it pisses off, and to Hell with the consequences. At best, he’s a defender of those the system grinds down. At worst, he’s a stone-faced, uncompromising obstacle to the powerful, just waiting to be taken out. Regain Willpower when your character’s refusal to let injustice go unopposed puts him in danger.</p>
        @elseif($virtue == 'Courageous')
          <p>Your character is simply straight-up brave. She gets a thrill from meeting and overcoming challenges, whether they’re physical or social. She’s not necessarily stubborn or even especially confident—true bravery is the willingness to carry on despite being afraid, not the absence of fear. Regain Willpower when your character’s bravery causes or prolongs risk or danger to her.</p>
        @elseif($virtue == 'Patient')
          <p>Your character doesn’t believe in rushing in half-cocked or unaware. She wants to plan every course of action and bides her time when investigating, waiting for situations to develop and play out for a while before she intervenes. The World of Darkness doesn’t wait anyone, however, and her preparations are often overtaken by events. Regain Willpower when your character is caught wrong-footed because she was too busy planning to properly react to events.</p>
        @endif
      </div>
      <div id="vices" class="hide">
        @php($vice = get_field('vice', $char))
        <h2>Vice: {{ $vice }}</h2>
        @if($vice == 'Pessimistic')
          <p>Your character has a tendency to wallow in bad situations, vocally bemoaning his lot and believing that everything is hopeless. Regain a Willpower point when he refuses to act in  a scene because he believes anything he does will be fruitless.</p>
        @elseif($vice == 'Hateful')
          <p>Your character is blinded by hatred for something—a person, a group or belief. His antipathy is so strong it prevents him from seeing clearly and leads him into fruitless attacks on the source of his hatred. Regain a Willpower point when he spends time in a scene persecuting the object of his hate.</p>
        @elseif($vice == 'Deceitful')
          <p>Your character can’t tell the truth to save her life. She might be in the habit of telling little white lies or be covering up one major secret, but deception is the cornerstone of her personality. Regain a Willpower point when she successfully maintains a lie despite others having the opportunity to see through it.</p>
        @elseif($vice == 'Arrogant')
          <p>For your character, self-image becomes self-aggrandizement. They define themself by being “better” than other people, whether that’s by lording their superiority in an Attribute or Skill, expressing dominance in a social situation, or basking in other characters looking up to them. Regain a Willpower point when they take an opportunity to express their greater worth relative to someone else.</p>
        @elseif($vice == 'Untrustworthy')
          <p>Your character can’t be relied on. She might mean well and even keep promises when it costs her nothing, but when the stakes are raised and there’s a choice between her own self-interest and keeping her word, her word loses. Regain a Willpower point when your character breaks a promise for her own sake.</p>
        @elseif($vice == 'Treacherous')
          <p>Your character’s loyalties are defined by what’s convenient, not for any sentiment towards loyalty itself. He will turn on allies if given a better offer or simply walk away from responsibilities if he finds them too difficult. Regain a Willpower point when your character betrays a person or group, but be very careful about using this Vice against other players’ characters.</p>
        @elseif($vice == 'Ambitious')
          <p>Your character wants to get ahead, above and beyond the respect that she receives for her actions. She craves advancement—not necessarily to lead, but in some measure of rank. Regain a Willpower point when your character attempts to increase her social standing instead of pursuing more useful activity.</p>
        @elseif($vice == 'Cruel')
          <p>Your character has a mean streak, an instinct to twist the knife and inflict pain once he has someone at his mercy. He might habitually refuse surrender in combat or be the bastard boss who humiliates employees just because it makes him feel better. Regain a Willpower point when your character needlessly victimizes someone in his power.</p>
        @elseif($vice == 'Violent')
          <p>Your character loves getting their way by means of physical force. They frequently go for blood to settle conflict. Regain a Willpower point when your character resolves a scene by using needless violence.</p>
        @elseif($vice == 'Greedy')
          <p>It’s not that he wants it more than anyone else, it’s more that he needs it. Your character likes to hoard resources that might come in useful one day, rather than allowing others to use them now, minimizing his future risk at their expense. Regain a Willpower point when you deny another character an advantage by taking it yourself.</p>
        @elseif($vice == 'Corrupt')
          <p>Your character is an expert at getting what she wants out of systems. A habitual abuser of institutions, once she’s in a position of authority she turns that office to furthering either her own ends or those of the highest bidder. Regain a Willpower point when your character misuses status or influence over a group on behalf of herself or another interested party.</p>
        @elseif($vice == 'Cowardly')
          <p>Your character shies away from danger, going beyond simple caution to true cowardice. If danger must be faced, he would much rather someone else face it—regain a point of Willpower when your character persuades or tricks another character into a risky situation instead of doing it himself.</p>
        @elseif($vice == 'Hasty')
          <p>Your character doesn’t have the patience for long, convoluted plans, but prefers to improvise as she goes. She frequently enters situations she doesn’t fully understand—but this Vice isn’t the measure of how well she copes when rushing in, only that she acts before thinking. Being able to quickly adapt, as many Hasty characters are, is determined by the Wits Attribute. Regain a point of Willpower when your character forces a scene to start by taking decisive action.</p>
        @endif
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
