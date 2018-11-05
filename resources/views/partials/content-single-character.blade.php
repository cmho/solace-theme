<section id="character-sheet" class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-4 col-sm-6 col-xs-12 center">
        <h2>{{ get_the_title() }}</h2>
        @if(get_field('family') != "other")
          <p class="family">{{ get_field('family') }}</p>
        @endif
        @if(!get_field('is_npc'))
          <p class="played-by">Played by {{ get_the_author() }}</p>
        @endif
      </div>
      <div class="col-md-8 col-sm-6 col-xs-12">
        <div class="box">
          <div class="content">
            @if(get_field('quote'))
              <p class="quote">{{ get_field('quote') }}</p>
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
</section>
