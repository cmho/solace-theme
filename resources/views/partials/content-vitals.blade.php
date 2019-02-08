<h3>Health</h3>
<div class="dots center" id="health">
  @php(App\Character::printSquares((get_field('stamina') || get_field('size') ? get_field('stamina')+get_field('size') : 6)))
</div>
<input type="hidden" name="current_health" value="{{ get_field('current_health') }}" />

<h3>Willpower</h3>
<div class="dots center" id="willpower">
  @php(App\Character::printSquares((get_field('composure') || get_field('resolve') ? 5+get_field('resolve') : 6)))
</div>
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
  <input type="number" disabled name="speed" value="{{ get_field('strength')+get_field('dexterity')+5 }}" />
</div>
<div class="form-row">
  <label for="defense">Defense</label>
  <input type="number" disabled name="defense" value="{{ min(get_field('wits'), get_field('dexterity'))+get_field('athletics') }}" />
</div>
<div class="form-row">
  <label for="armor">Armor</label>
  <input type="text" name="armor" value="{{ get_field('armor') }}" />
</div>
<div class="form-row">
  <label for="initiative_mod">Initiative Modifier</label>
  <input type="number" disabled name="initiative_mod" value="{{ get_field('dexterity')+get_field('composure') }}" />
</div>
