<div id="skills-row">
  <h3>Skills</h3>
  <div id="mental-skills">
    <h4>Mental <span id="mental-skills-count" class="hidden"></span></h4>
    <div class="row between-xs middle-xs">
      <label>Academics</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('academics')))
        <input type="hidden" name="academics" value="{{ get_field('academics') ? get_field('academics') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Computer</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('computer')))
        <input type="hidden" name="computer" value="{{ get_field('computer') ? get_field('computer') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Crafts</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('crafts')))
        <input type="hidden" name="crafts" value="{{ get_field('crafts') ? get_field('crafts') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Investigation</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('investigation')))
        <input type="hidden" name="investigation" value="{{ get_field('investigation') ? get_field('investigation') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Medicine</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('medicine')))
        <input type="hidden" name="medicine" value="{{ get_field('medicine') ? get_field('medicine') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Occult</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('occult')))
        <input type="hidden" name="occult" value="{{ get_field('occult') ? get_field('occult') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Politics</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('politics')))
        <input type="hidden" name="politics" value="{{ get_field('politics') ? get_field('politics') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Science</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('science')))
        <input type="hidden" name="science" value="{{ get_field('science') ? get_field('science') : 0 }}" />
      </div>
    </div>
  </div>
  <div id="physical-skills">
    <h4>Physical <span id="physical-skills-count" class="hidden"></span></h4>
    <div class="row between-xs middle-xs">
      <label>Athletics</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('athletics')))
        <input type="hidden" name="athletics" value="{{ get_field('athletics') ? get_field('athletics') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Brawl</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('brawl')))
        <input type="hidden" name="brawl" value="{{ get_field('brawl') ? get_field('brawl') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Drive</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('drive')))
        <input type="hidden" name="drive" value="{{ get_field('drive') ? get_field('drive') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Firearms</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('firearms')))
        <input type="hidden" name="firearms" value="{{ get_field('firearms') ? get_field('firearms') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Larceny</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('larceny')))
        <input type="hidden" name="larceny" value="{{ get_field('larceny') ? get_field('larceny') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Stealth</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('stealth')))
        <input type="hidden" name="stealth" value="{{ get_field('stealth') ? get_field('stealth') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Survival</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('survival')))
        <input type="hidden" name="survival" value="{{ get_field('survival') ? get_field('survival') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Weaponry</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('weaponry')))
        <input type="hidden" name="weaponry" value="{{ get_field('weaponry') ? get_field('weaponry') : 0 }}" />
      </div>
    </div>
  </div>
  <div id="social-skills">
    <h4>Social <span id="social-skills-count" class="hidden"></span></h4>
    <div class="row between-xs middle-xs">
      <label>Animal Ken</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('animal_ken')))
        <input type="hidden" name="animal_ken" value="{{ get_field('animal_ken') ? get_field('animal_ken') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Empathy</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('empathy')))
        <input type="hidden" name="empathy" value="{{ get_field('empathy') ? get_field('empathy') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Expression</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('expression')))
        <input type="hidden" name="expression" value="{{ get_field('expression') ? get_field('expression') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Intimidation</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('intimidation')))
        <input type="hidden" name="intimidation" value="{{ get_field('intimidation') ? get_field('intimidation') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Leadership</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('leadership')))
        <input type="hidden" name="leadership" value="{{ get_field('leadership') ? get_field('leadership') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Persuasion</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('persuasion')))
        <input type="hidden" name="persuasion" value="{{ get_field('persuasion') ? get_field('persuasion') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Streetwise</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('streetwise')))
        <input type="hidden" name="streetwise" value="{{ get_field('streetwise') ? get_field('streetwise') : 0 }}" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Subterfuge</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('subterfuge')))
        <input type="hidden" name="subterfuge" value="{{ get_field('subterfuge') ? get_field('subterfuge') : 0 }}" />
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
