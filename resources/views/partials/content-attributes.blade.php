<section id="attributes" class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-xs-12">
        <h3>Attributes</h3>
      </div>
      <div class="col-md-4 col-xs-12">
        <h4>Mental</h4>
        <div class="row between-xs middle-xs">
          <label>Intelligence</label>
          <div class="dots">
            @php(App\Character:printDots(get_field('intelligence')))
          </div>
        </div>
        <div class="row between-xs middle-xs">
          <label>Wits</label>
          <div class="dots">
            @php(App\Character:printDots(get_field('wits')))
          </div>
        </div>
        <div class="row between-xs middle-xs">
          <label>Resolve</label>
          <div class="dots">
            @php(App\Character:printDots(get_field('resolve')))
          </div>
        </div>
      </div>
      <div class="col-md-4 col-xs-12">
        <h4>Physical</h4>
        <div class="row between-xs middle-xs">
          <label>Strength</label>
          <div class="dots">
            @php(App\Character:printDots(get_field('strength')))
          </div>
        </div>
        <div class="row between-xs middle-xs">
          <label>Dexterity</label>
          <div class="dots">
            @php(App\Character:printDots(get_field('dexterity')))
          </div>
        </div>
        <div class="row between-xs middle-xs">
          <label>Stamina</label>
          <div class="dots">
            @php(App\Character:printDots(get_field('stamina')))
          </div>
        </div>
      </div>
      <div class="col-md-4 col-xs-12">
        <h4>Social</h4>
        <div class="row between-xs middle-xs">
          <label>Presence</label>
          <div class="dots">
            @php(App\Character:printDots(get_field('presence')))
          </div>
        </div>
        <div class="row between-xs middle-xs">
          <label>Manipulation</label>
          <div class="dots">
            @php(App\Character:printDots(get_field('manipulation')))
          </div>
        </div>
        <div class="row between-xs middle-xs">
          <label>Composure</label>
          <div class="dots">
            @php(App\Character:printDots(get_field('composure')))
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
