<div class="row">
  <div class="col-xs-12">
    <h3>Attributes</h3>
  </div>
  <div class="col-md-4 col-xs-12">
    <h4>Mental</h4>
    <div class="row between-xs middle-xs">
      <label>Intelligence</label>
      <div class="dots">
        @php(App\Character::printDots(1))
        <input type="hidden" value="1" name="intelligence" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Wits</label>
      <div class="dots">
        @php(App\Character::printDots(1))
        <input type="hidden" value="1" name="wits" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Resolve</label>
      <div class="dots">
        @php(App\Character::printDots(1))
        <input type="hidden" value="1" name="resolve" />
      </div>
    </div>
  </div>
  <div class="col-md-4 col-xs-12">
    <h4>Physical</h4>
    <div class="row between-xs middle-xs">
      <label>Strength</label>
      <div class="dots">
        @php(App\Character::printDots(1))
        <input type="hidden" value="1" name="strength" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Dexterity</label>
      <div class="dots">
        @php(App\Character::printDots(1))
        <input type="hidden" value="1" name="dexterity" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Stamina</label>
      <div class="dots">
        @php(App\Character::printDots(1))
        <input type="hidden" value="1" name="stamina" />
      </div>
    </div>
  </div>
  <div class="col-md-4 col-xs-12">
    <h4>Social</h4>
    <div class="row between-xs middle-xs">
      <label>Presence</label>
      <div class="dots">
        @php(App\Character::printDots(1))
        <input type="hidden" value="1" name="presence" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Manipulation</label>
      <div class="dots">
        @php(App\Character::printDots(1))
        <input type="hidden" value="1" name="manipulation" />
      </div>
    </div>
    <div class="row between-xs middle-xs">
      <label>Composure</label>
      <div class="dots">
        @php(App\Character::printDots(1))
        <input type="hidden" value="1" name="composure" />
      </div>
    </div>
  </div>
</div>
