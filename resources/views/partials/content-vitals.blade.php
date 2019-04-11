<h3>Health</h3>
<div class="dots center" id="health">
  @php(App\Character::printSquares((get_field('stamina') || get_field('size') ? get_field('stamina')+get_field('size') : 6)))
</div>
<input type="hidden" name="health" value="{{ get_field('health') }}" />
<input type="hidden" name="current_health" value="{{ get_field('current_health') }}" />

<h3>Willpower</h3>
<div class="dots center" id="willpower">
  @php(App\Character::printSquares((get_field('composure') || get_field('resolve') ? 5+get_field('resolve') : 6)))
</div>
<input type="hidden" name="willpower" value="{{ get_field('willpower') }}" />
<input type="hidden" name="current_willpower" value="{{ get_field('current_willpower') }}" />

<h3>Integrity</h3>
<div class="dots center">
  @php(App\Character::printDotsTen((get_field('integrity') ? get_field('integrity') : 7)))
  <input type="hidden" name="integrity" value="{{ (get_field('integrity') ? get_field('integrity') : 7) }}" />
</div>

<div class="form-row">
  <label for="size">Size</label>
  <input type="number" name="size" min="0" max="10" value="{{ get_field('size') ? get_field('size') : 5 }}" />
</div>
<div class="form-row">
  <label for="speed">Speed</label>
  <input type="number" disabled name="speed" value="{{ App\Character::speedFinal($post) }}" />
</div>
<div class="form-row">
  <label for="defense">Defense</label>
  <input type="number" disabled name="defense" value="{{ App\Character::defenseFinal($post) }}" />
</div>
<div class="form-row">
  <label for="armor">General Armor</label>
  <input type="text" name="general_armor" value="{{ App\Character::getArmorGeneral() }}" />
</div>
<div class="form-row">
  <label for="armor">Ballistic Armor</label>
  <input type="text" name="ballistic_armor" value="{{ App\Character::getArmorBallistic() }}" />
</div>
<div class="form-row">
  <label for="initiative_mod">Initiative Modifier</label>
  <input type="number" disabled name="initiative_mod" value="{{ App\Character::initiativeFinal($post) }}" />
</div>
