<section class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <h2>{{ get_the_title() }}</h2>
        <p class="date">{{ get_field('date') }}</p>
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
