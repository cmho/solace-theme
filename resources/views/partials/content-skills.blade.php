<div id="skills-row">
  <h3>Skills</h3>
  <div id="mental-skills">
    <h4>Mental <span id="mental-skills-count" class="hidden"></span></h4>
    <div class="row between-xs middle-xs">
      <label>Academics</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('academics')))
        <input type="hidden" name="academics" value="{{ get_field('academics') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Computer</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('computer')))
        <input type="hidden" name="computer" value="{{ get_field('computer') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Crafts</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('crafts')))
        <input type="hidden" name="crafts" value="{{ get_field('crafts') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Investigation</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('investigation')))
        <input type="hidden" name="investigation" value="{{ get_field('investigation') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Medicine</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('medicine')))
        <input type="hidden" name="medicine" value="{{ get_field('medicine') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Occult</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('occult')))
        <input type="hidden" name="occult" value="{{ get_field('occult') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Politics</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('politics')))
        <input type="hidden" name="politics" value="{{ get_field('politics') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Science</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('science')))
        <input type="hidden" name="science" value="{{ get_field('science') }}" />
      </div>
    </div>
  </div>
  <div id="physical-skills">
    <h4>Physical <span id="physical-skills-count" class="hidden"></span></h4>
    <div class="row between-xs middle-xs">
      <label>Athletics</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('athletics')))
        <input type="hidden" name="athletics" value="{{ get_field('athletics') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Brawl</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('brawl')))
        <input type="hidden" name="brawl" value="{{ get_field('brawl') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Drive</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('drive')))
        <input type="hidden" name="drive" value="{{ get_field('drive') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Firearms</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('firearms')))
        <input type="hidden" name="firearms" value="{{ get_field('firearms') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Larceny</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('larceny')))
        <input type="hidden" name="larceny" value="{{ get_field('larceny') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Stealth</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('stealth')))
        <input type="hidden" name="stealth" value="{{ get_field('stealth') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Survival</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('survival')))
        <input type="hidden" name="survival" value="{{ get_field('survival') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Weaponry</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('weaponry')))
        <input type="hidden" name="weaponry" value="{{ get_field('weaponry') }}" />
      </div>
    </div>
  </div>
  <div id="social-skills">
    <h4>Social <span id="social-skills-count" class="hidden"></span></h4>
    <div class="row between-xs middle-xs">
      <label>Animal Ken</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('animal_ken')))
        <input type="hidden" name="animal_ken" value="{{ get_field('animal_ken') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Empathy</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('empathy')))
        <input type="hidden" name="empathy" value="{{ get_field('empathy') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Expression</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('expression')))
        <input type="hidden" name="expression" value="{{ get_field('expression') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Intimidation</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('intimidation')))
        <input type="hidden" name="intimidation" value="{{ get_field('intimidation') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Leadership</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('leadership')))
        <input type="hidden" name="leadership" value="{{ get_field('leadership') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Persuasion</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('persuasion')))
        <input type="hidden" name="persuasion" value="{{ get_field('persuasion') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Streetwise</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('streetwise')))
        <input type="hidden" name="streetwise" value="{{ get_field('streetwise') }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Subterfuge</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('subterfuge')))
        <input type="hidden" name="subterfuge" value="{{ get_field('subterfuge') }}" />
      </div>
    </div>
  </div>
  <div id="skill-specialties">
    <h3>Skill Specialties <span id="skill-specialty-count"></span></h3>
    <div class="row specialty-form-row">
      <select id="skills_list">
        @foreach(get_field_object("field_5c45fad0556fd")['choices'] as $value=>$label)
          <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
      </select>
      <input type="text" id="specialty_name" />
      <button id="add-specialty" type="button">Add</button>
      <input type="hidden" name="skill_specialties" value="{{ count(get_field('skill_specialties')) }}" />
    </div>
    <div class="row">
      <ul class="skill-specialties">
        @foreach(get_field('skill_specialties') as $i=>$sksp)
          <li><strong class="skill">{{ $sksp['skill'] }}:</strong> <span class="specialty">{{ $sksp['specialty'] }}</span> <button type="button" class="delete"><i class='fas fa-trash'></i></button><input type='hidden' name='skill_specialties_{{ $i }}_skill' value='{{ $sksp['skill'] }}' /><input type='hidden' name='skill_specialties_{{ $i }}_specialty' value='{{ $sksp['specialty'] }}' /></li>
        @endforeach
        @if(App\Character::getSubSkillSpecialties($post->ID))
          @foreach(App\Character::getSubSkillSpecialties($post->ID) as $sksp)
            <li data-phantom="true"><strong class="skill">{{ $sksp['skill'] }}:</strong> <span class="specialty">{{ $sksp['specialty'] }}</span></li>
          @endforeach
        @endif
      </ul>
    </div>
  </div>
</div>
