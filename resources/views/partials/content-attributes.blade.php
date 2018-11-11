<div class="row">
  <div class="col-xs-12">
    <h3>Attributes</h3>
  </div>
  <div class="col-md-4 col-xs-12">
    <h4>Mental</h4>
    <div class="row between-xs middle-xs">
      <label>Intelligence</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('intelligence') ? get_field('intelligence') : 1))
        <input type="hidden" value="{{ get_field('intelligence') ? get_field('intelligence') : 1 }}" name="intelligence" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Wits</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('wits') ? get_field('wits') : 1))
        <input type="hidden" value="{{ get_field('wits') ? get_field('wits') : 1 }}" name="wits" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Resolve</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('resolve') ? get_field('resolve') : 1))
        <input type="hidden" value="{{ get_field('resolve') ? get_field('resolve') : 1 }}" name="resolve" />
      </div>
    </div>
  </div>
  <div class="col-md-4 col-xs-12">
    <h4>Physical</h4>
    <div class="row between-xs middle-xs">
      <label>Strength</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('strength') ? get_field('strength') : 1))
        <input type="hidden" value="{{ get_field('strength') ? get_field('strength') : 1 }}" name="strength" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Dexterity</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('dexterity') ? get_field('dexterity') : 1))
        <input type="hidden" value="{{ get_field('dexterity') ? get_field('dexterity') : 1 }}" name="dexterity" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Stamina</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('stamina') ? get_field('stamina') : 1))
        <input type="hidden" value="{{ get_field('intelligence') ? get_field('intelligence') : 1 }}" name="stamina" />
      </div>
    </div>
  </div>
  <div class="col-md-4 col-xs-12">
    <h4>Social</h4>
    <div class="row between-xs middle-xs">
      <label>Presence</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('presence') ? get_field('presence') : 1))
        <input type="hidden" value="{{ get_field('presence') ? get_field('presence') : 1 }}" name="presence" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Manipulation</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('manipulation') ? get_field('manipulation') : 1))
        <input type="hidden" value="{{ get_field('manipulation') ? get_field('manipulation') : 1 }}" name="manipulation" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Composure</label>
      <div class="dots">
        @php(App\Character::printDots(get_field('composure') ? get_field('composure') : 1))
        <input type="hidden" value="{{ get_field('composure') ? get_field('composure') : 1 }}" name="composure" />
      </div>
    </div>
  </div>
</div>
