<section id="character-sheet" class="grey">
  <div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12 center">
      <h2>Character: {{ get_the_title() }}</h2>
      @if(get_field('family') != "other")
        <p class="family">{{ get_field('family') }} Family</p>
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
