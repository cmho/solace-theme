<div class="character-sheet character tab-content" id="character" data-character="{{ $char->ID }}">
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
    <p class="merits">{!! App\Character::meritsSimple($char->ID) !!}</p>

    <h3>Conditions</h3>
      <ul class="conditions">
        @if(get_field('conditions', $char->ID))
          @foreach(get_field('conditions', $char->ID) as $condition)
          <li><strong>{{ get_the_title($condition['condition']->ID) }}</strong><br />
            {{ $condition['note'] }}
          </li>
          @endforeach
        @else
          <li><em>None.</em></li>
        @endif
      </ul>

    <h3>Vitals</h3>
    <p><strong>Size:</strong> {{ get_field('size', $char->ID) }}</p>
    <p><strong>Speed:</strong> {{ get_field('strength', $char)+5 }}</p>
    <p><strong>Defense:</strong> {{ min(get_field('wits', $char), get_field('dexterity', $char))+get_field('athletics', $char) }}</p>
    <p id="init-mod-wrapper"><strong>Initiative Mod:</strong> <span id="initiative-mod">{{ get_field('dexterity', $char)+get_field('composure', $char) }}</span> <button class='js-modal' id="roll-initiative" data-modal-content-id='initiative-roller'>Get Initiative</button></p>
  </div>
</div>
