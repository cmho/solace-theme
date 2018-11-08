<section id="downtime-action" class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <h2>{!! get_the_title() !!}</h2>
        <dl>
          <dt>Action Type</dt>
          <dd>{{ get_field('action_type') }}</dd>
          <dt>Assets</dt>
          <dd>{{ get_field('assets') }}</dd>
          <dt>Goal</dt>
          <dd>{{ get_field('goal') }}</dd>
      </div>
      <div class="col-md-8 col-xs-12">
        <div class="box">
          <div class="content">
            @php(the_content())
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
