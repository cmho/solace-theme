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
      <div class="row" id="basics-row">
        <div class="{{ !isset($print) ? 'col-md-4 col-sm-6 col-xs-12 center' : 'col-xs-6' }}">
          <h2>{!! get_the_title() !!}</h2>
          @if(get_field('family') != "other")
            <p class="family">{{ get_field('family') }}</p>
          @endif
          @if(!get_field('is_npc'))
            <p class="played-by">Played by {{ get_the_author_meta('nickname') }}</p>
          @endif
          @if(App\App::isAdmin() || (get_field('status') == 'In Progress' || get_field('status') == 'in_progress') || App\Character::sumExperience() > 0)
            <div class="button-row center">
              <a href="{{ get_the_permalink() }}?mode=edit" class="button">Edit Character</a>
            </div>
          @endif
        </div>
        <div class="{{ !isset($print) ? 'col-md-8 col-sm-6 col-xs-12' : 'col-xs-6' }}">
          <div class="box">
            <div class="content">
              @if(get_field('quote'))
                <p class="quote">{!! get_field('quote') !!}</p>
              @endif
              @if(get_field('public_blurb'))
                <div class="blurb">
                  {!! get_field('public_blurb') !!}
                </div>
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
        <div class="{{ !isset($print) ? 'col-md-4 col-xs-12' : 'col-xs-4' }}">
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
        <div class="{{ !isset($print) ? 'col-md-4 col-xs-12' : 'col-xs-4' }}">
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
        <div class="{{ !isset($print) ? 'col-md-4 col-xs-12' : 'col-xs-4' }}">
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
        <div class="{{ !isset($print) ? 'col-md-4 col-xs-12' : 'col-xs-4' }}">
          <h3>Skills</h3>
          @php(App\Character::printSkills($post->ID))
          <h3>Skill Specialties</h3>
          <ul class="skill-specialties">
            @foreach(get_field('skill_specialties') as $i=>$sksp)
              <li><strong class="skill">{{ $sksp['skill'] }}:</strong> <span class="specialty">{{ $sksp['specialty'] }}</span></li>
            @endforeach
            @if(App\Character::getSubSkillSpecialties($post->ID))
              @foreach(App\Character::getSubSkillSpecialties($post->ID) as $sksp)
                <li data-phantom="true"><strong class="skill">{{ $sksp['skill'] }}:</strong> <span class="specialty">{{ $sksp['specialty'] }}</span></li>
              @endforeach
            @endif
          </ul>
        </div>
        <div class="{{ !isset($print) ? 'col-md-4 col-xs-12' : 'col-xs-4' }}">
          <h3>Merits</h3>
          @if(get_field('merits'))
            <ul class="merits">
              @foreach(get_field('merits') as $i => $merit)
                <li>
                  {{ $merit['merit']->post_title }}{{ get_field('requires_specification', $merit['merit']->ID) ? " (".$merit['specification'].")" : '' }}{{ count(get_field('allowed_ratings', $merit['merit']->ID)) > 1 ? " ".$merit['rating'] : '' }}{{ $merit['description'] ? '<div>'.$merit['description'].'</div>' : '' }}
                  @if(App\Merit::addlBenefits($merit['merit']->ID))
                    <ul>
                      @foreach(App\Merit::addlBenefits($merit['merit']->ID) as $k => $ab)
                        @foreach($ab['benefits'] as $j => $benefit)
                          @if(($benefit['type'] == 'Merit') && ($ab['rating'] <= $merit['rating']))
                            <li>
                              {{ $benefit['merit']->post_title }}<span class="specification">{{ get_field('merits')[$i]['additional_specifications'][$k]['specifications'][$j]['specification'] ? " (".get_field('merits')[$i]['additional_specifications'][$k]['specifications'][$j]['specification'].")" : '' }}</span><span class='rating'>{{ $benefit['rating'] ? ' '.$benefit['rating'] : '' }}</span>
                            </li>
                          @endif
                        @endforeach
                      @endforeach
                    </ul>
                  @endif
                </li>
              @endforeach
            </ul>
          @else
            <p><em>None</em></p>
          @endif
          @if(!isset($print))
            <h3>Equipment</h3>
            @if(get_field('equipment'))
              <ul class="equipment">
                @foreach(get_field('equipment') as $equipment)
                  @include('partials.content-equipment-list')
                @endforeach
              </ul>
            @else
              <p><em>None</em></p>
            @endif
          @endif
        </div>
        <div class="{{ !isset($print) ? 'col-md-4 col-xs-12' : 'col-xs-4' }}">
          <h3>Health</h3>
          <div class="dots center">
            @php(App\Character::printSquaresInteractable(get_field('current_health')))
          </div>

          <h3>Willpower</h3>
          <div class="dots center">
            @php(App\Character::printSquaresInteractable(get_field('current_willpower')))
          </div>

          <h3>Integrity</h3>
          <div class="dots center">
            @php(App\Character::printDotsTen(get_field('integrity')))
          </div>

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
  @if(isset($print) && get_field('equipment'))
    <section id="equipment-print">
      <div class="wrapper">
        <div class="row">
          <div class="col-xs-12">
            <h3>Equipment</h3>
            @if(get_field('equipment'))
              <ul class="equipment">
                @foreach(App\Equipment::sortEquipment(get_field('equipment')) as $equipment)
                  @include('partials.content-equipment-list')
                @endforeach
              </ul>
            @else
              <p><em>None</em></p>
            @endif
          </div>
        </div>
      </div>
    </section>
  @endif
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
