<section id="downtime-action" class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <h2>{!! get_the_title() !!}</h2>
        <p class="action-type"><strong>Action Type:</strong> {{ get_field('action_type') }}</p>
      </div>
      <div class="col-md-8 col-xs-12">
        <div class="box">
          <div class="content">
            <p class="assets"><strong>Assets:</strong> {{ get_field('assets') }}</p>
            <p class="goal"><strong>Goal:</strong> {{ get_field('goal') }}</p>
            @php(the_content())
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
