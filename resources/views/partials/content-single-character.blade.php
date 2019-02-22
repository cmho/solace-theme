@php
  global $post;
@endphp
@if(get_query_var('mode') === 'edit')
  <form action="{{ esc_url( admin_url('admin-post.php') ) }}" method="POST">
    <input type="hidden" name="id" value="{{ get_the_ID() }}" />
    @include('partials.content-character-form')
  </form>
@else
  <section id="character-sheet" class="grey">
    <div class="wrapper">
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12 center">
          <h2>{!! get_the_title() !!}</h2>
          @if(get_field('family') != "other")
            <p class="family">{{ get_field('family') }}</p>
          @endif
          @if(!get_field('is_npc'))
            <p class="played-by">Played by {{ get_the_author() }}</p>
          @endif
          @if(App\App::isAdmin() || (get_field('status') == 'In Progress' || get_field('status') == 'in_progress') || App\Character::sumExperience() > 0)
            <div class="button-row center">
              <a href="{{ get_the_permalink() }}?mode=edit" class="button">Edit Character</a>
            </div>
          @endif
        </div>
        <div class="col-md-8 col-sm-6 col-xs-12">
          <div class="box">
            <div class="content">
              @if(get_field('quote'))
                <p class="quote">{!! get_field('quote') !!}</p>
              @endif
              @if(get_field('public_blurb'))
                {!! get_field('public_blurb') !!}
              @endif
              <dl>
                <dt>Status</dt>
                <dd>{{ get_field('status') }}</dd>
                <dt>Virtue</dt>
                <dd>{{ get_field('virtue') }}</dd>
                <dt>Vice</dt>
                <dd>{{ get_field('vice') }}</dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <h3>Attributes</h3>
        </div>
        <div class="col-md-4 col-xs-12">
          <h4>Mental</h4>
          <div class="row between-xs middle-xs">
            <label>Intelligence</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('intelligence')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Wits</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('wits')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Resolve</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('resolve')))
            </div>
          </div>
        </div>
        <div class="col-md-4 col-xs-12">
          <h4>Physical</h4>
          <div class="row between-xs middle-xs">
            <label>Strength</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('strength')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Dexterity</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('dexterity')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Stamina</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('stamina')))
            </div>
          </div>
        </div>
        <div class="col-md-4 col-xs-12">
          <h4>Social</h4>
          <div class="row between-xs middle-xs">
            <label>Presence</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('presence')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Manipulation</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('manipulation')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Composure</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('composure')))
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col-xs-12">
          <h3>Skills</h3>
          @php(App\Character::printSkills($post->ID));
          <h4>Mental</h4>
          <div class="row between-xs middle-xs">
            <label>Academics</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('academics')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Computer</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('computer')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Crafts</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('crafts')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Investigation</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('investigation')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Medicine</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('medicine')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Occult</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('occult')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Politics</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('politics')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Science</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('science')))
            </div>
          </div>
          <h4>Physical</h4>
          <div class="row between-xs middle-xs">
            <label>Athletics</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('athletics')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Brawl</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('brawl')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>{{ App\Character::hasAssetSkill($post->ID, 'drive') ? '* ' : '' }}Drive</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('drive')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>{{ App\Character::hasAssetSkill($post->ID, 'firearms') ? '* ' : '' }}Firearms</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('firearms')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>{{ App\Character::hasAssetSkill($post->ID, 'larceny') ? '* ' : '' }}Larceny</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('larceny')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>{{ App\Character::hasAssetSkill($post->ID, 'stealth') ? '* ' : '' }}Stealth</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('stealth')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>{{ App\Character::hasAssetSkill($post->ID, 'survival') ? '* ' : '' }}Survival</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('survival')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>{{ App\Character::hasAssetSkill($post->ID, 'weaponryh') ? '* ' : '' }}Weaponry</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('weaponry')))
            </div>
          </div>
          <h4>Social</h4>
          <div class="row between-xs middle-xs">
            <label>Animal Ken</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('animal_ken')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Empathy</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('empathy')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Expression</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('expression')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Intimidation</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('intimidation')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Leadership</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('leadership')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Persuasion</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('persuasion')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Streetwise</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('streetwise')))
            </div>
          </div>
          <div class="row between-xs middle-xs">
            <label>Subterfuge</label>
            <div class="dots">
              @php(App\Character::printDots(get_field('subterfuge')))
            </div>
          </div>
          <h3>Skill Specialties</h3>
          <ul class="skill-specialties">
            @foreach(get_field('skill_specialties') as $i=>$sksp)
              <li><strong class="skill">{{ $sksp['skill'] }}:</strong> <span class="specialty">{{ $sksp['specialty'] }}</span></li>
            @endforeach
          </ul>
        </div>
        <div class="col-md-4 col-xs-12">
          <h3>Merits</h3>
          @if(count(get_field('merits')) > 0)
            <ul class="merits">
              @foreach(get_field('merits') as $merit)
                <li>{{ get_the_title($merit['merit']->ID) }}{{ get_field('requires_specification', $merit['merit']->ID) ? " (".$merit['specification'].")" : '' }}{{ count(get_field('allowed_ratings', $merit['merit']->ID)) > 1 ? " ".$merit['rating'] : '' }}{{ $merit['description'] ? '<div>'.$merit['description'].'</div>' : '' }}</li>
              @endforeach
            </ul>
          @else
            <p><em>None</em></p>
          @endif
          <h3>Equipment</h3>
          @if(get_field('equipment'))
            <ul class="equipment">
              @foreach(get_field('equipment') as $equipment)
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
            <p><em>None</em></p>
          @endif
        </div>
        <div class="col-md-4 col-xs-12">
          <h3>Health</h3>
          <div class="dots center">
            @php(App\Character::printSquares(get_field('stamina')+get_field('size')))
          </div>

          <h3>Willpower</h3>
          <div class="dots center">
            @php(App\Character::printSquares(get_field('composure')+get_field('resolve')))
          </div>

          <h3>Integrity</h3>
          <div class="dots center">
            @php(App\Character::printDotsTen(get_field('integrity')))
          </div>

          <dl>
            <dt>Size</dt>
            <dd>{{ get_field('size') }}</dd>
            <dt>Speed</dt>
            <dd>{{ get_field('strength')+get_field('dexterity')+5 }}</dd>
            <dt>Defense</dt>
            <dd>{{ min(get_field('wits'), get_field('dexterity'))+get_field('athletics') }}</dd>
            <dt>Armor</dt>
            <dd>{{ get_field('armor') }}</dd>
            <dt>Initiative Mod</dt>
            <dd>{{ get_field('dexterity')+get_field('composure') }}</dd>
          </dl>

          <h3>Conditions</h3>
          @if(get_field('conditions'))
            <ul class="conditions">
              @foreach(get_field('conditions') as $condition)
              <li><strong>{{ get_the_title($condition['condition']->ID) }}</strong><br />
                {{ $condition['note'] }}
              </li>
              @endforeach
            </ul>
          @else
            <p><em>None</em></p>
          @endif
        </div>
      </div>
    </div>
  </section>
  <section id="questionnaire" class="yellow">
    <div class="wrapper">
      <div class="row">
        <div class="col-xs-12">
          <h3>Questionnaire</h3>
          <dl class="questionnaire">
            @foreach(App\Character::questionnaire() as $q)
              <dt>{{ $q['label'] }}</dt>
              <dd>{!! $q['value'] !!}</dd>
            @endforeach
            @if(App::isAdmin())
              <dt>Storyteller Notes</dt>
              <dd>{!! get_field('st_notes') !!}</dd>
            @endif
          </dl>
        </div>
      </div>
    </div>
  </section>
  <section id="experience" class="grey">
    <div class="wrapper">
      <div class="row">
        <div class="col-xs-12">
          <h3>Experience</h3>
          <ul>
            @foreach(App\Character::experienceRecords() as $post)
              @php(setup_postdata($post))
              <li>{{ get_the_title() }}: {{ get_field('amount', $post) }}</li>
            @endforeach
            @php(wp_reset_postdata())
          </ul>
          <p><strong>Current Total:</strong> {{ App\Character::sumExperience() }}</p>
        </div>
      </div>
    </div>
  </section>
@endif
