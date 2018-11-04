@php
  function printDots($amt) {
    for($i = 1; $i <= 5; $i++) {
      if($i > $amt) {
        echo '<i class="far fa-circle"></i>';
      } else {
        echo '<i class="fas fa-circle"></i>';
      }
    }
    echo '<span class="sr-only">'.$amt.'</span>';
  }

  function printDotsTen($amt) {
    for($i = 1; $i <= 10; $i++) {
      if($i > $amt) {
        echo '<i class="far fa-circle"></i>';
      } else {
        echo '<i class="fas fa-circle"></i>';
      }
    }
    echo '<span class="sr-only">'.$amt.'</span>';
  }

  function printSquares($amt) {
    for($i = 1; $i <= 5; $i++) {
      echo '<i class="far fa-square"></i>';
    }
    echo '<span class="sr-only">'.$amt.'</span>';
  }
@endphp

<section id="character-sheet" class="grey">
  <div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12 center">
      <h2>Character: {{ get_the_title() }}</h2>
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
            <p><em>{{ get_field('quote') }}</em></p>
          @endif
          @if(get_field('public_blurb'))
            {{ get_field('public_blurb') }}
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
      <div class="row">
        <label>Intelligence</label>
        <div class="dots">
          @php(printDots(get_field('intelligence')))
        </div>
      </div>
      <div class="row">
        <label>Wits</label>
        <div class="dots">
          @php(printDots(get_field('wits')))
        </div>
      </div>
      <div class="row">
        <label>Resolve</label>
        <div class="dots">
          @php(printDots(get_field('resolve')))
        </div>
      </div>
    </div>
    <div class="col-md-4 col-xs-12">
      <h4>Physical</h4>
      <div class="row">
        <label>Strength</label>
        <div class="dots">
          @php(printDots(get_field('strength')))
        </div>
      </div>
      <div class="row">
        <label>Dexterity</label>
        <div class="dots">
          @php(printDots(get_field('dexterity')))
        </div>
      </div>
      <div class="row">
        <label>Stamina</label>
        <div class="dots">
          @php(printDots(get_field('stamina')))
        </div>
      </div>
    </div>
    <div class="col-md-4 col-xs-12">
      <h4>Social</h4>
      <div class="row">
        <label>Presence</label>
        <div class="dots">
          @php(printDots(get_field('presence')))
        </div>
      </div>
      <div class="row">
        <label>Manipulation</label>
        <div class="dots">
          @php(printDots(get_field('manipulation')))
        </div>
      </div>
      <div class="row">
        <label>Composure</label>
        <div class="dots">
          @php(printDots(get_field('composure')))
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <h3>Skills</h3>
        <h4>Mental</h4>
        <div class="row">
        <label>Academics</label>
        <div class="dots">
          @php(printDots(get_field('academics')))
        </div>
      </div>
      </div>
      <div class="col-md-4 col-xs-12">
        <h3>Merits</h3>
        <ul class="merits">
          @foreach(get_field('merits') as $merit)
            <li>{{ get_the_title($merit['merit']) }}{{ get_field('requires_specification', $merit['merit']) ? " (".$merit['specification'].")" : '' }}{{ count(get_field('allowed_ratings', $merit['merit'])) > 1 ? " ".$merit['rating'] : '' }}</li>
          @endforeach
      </div>
      <div class="col-md-4 col-xs-12">
        <h3>Health</h3>
        @php(printSquares(get_field('stamina')+get_field('size')))

        <h3>Willpower</h3>
        @php(printSquares(get_field('composure')+get_field('resolve')))

        <h3>Integrity</h3>
        @php(printDotsTen(get_field('integrity')))
      </div>
    </div>
  </div>
</div>
