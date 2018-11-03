<section class="grey">
  <div class="wrapper">
    <div class="row center-xs">
      <div class="col-xs-12">
        <h2>Merit: {{ get_the_title() }} {{ join(', ', get_field('allowed_ratings')) }}</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="content">
            @if(get_field('prerequisites'))
              <p><strong>Prerequisites:</strong> {{ get_field('prerequisites') }}</p>
              {{ get_field('description') }}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
