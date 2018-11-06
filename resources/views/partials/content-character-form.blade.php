<section id="character-sheet" class="grey">
  <div class="wrapper">
    @include('partials.content-basics')
    @include('partials.content-attributes')
    @include('partials.content-skills-merits-misc')
  </div>
</section>
<section id="questionnaire" class="yellow">
  <div class="wrapper">
    <div class="row">
      <div class="col-xs-12">
        <h3>Questionnaire</h3>
        @include('partials.content-questionnaire')
      </div>
    </div>
  </div>
</section>
<section id="controls" class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-xs-12">
        <input type="hidden" name="author" value="{{ wp_get_current_user()->ID }}" />
        <input type="hidden" name="action" value="update_character" />
        <input type="submit" value="Save Character" />
      </div>
    </div>
  </div>
</div>
