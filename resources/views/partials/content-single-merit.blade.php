<section class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <h2>Merit: {{ get_the_title() }} ({{ App\Merit::dots() }})</h2>
      </div>
      <div class="col-md-8 col-xs-12">
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
