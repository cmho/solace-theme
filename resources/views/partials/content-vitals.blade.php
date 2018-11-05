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
