<section id="experience-expenditure" class="grey">
  <div class="wrapper">
    <div class="row center-xs">
      <div class="col-xs-12">
        <h2>Experience Expenditure: {{ App\Experience::getCharacter()->post_title }}</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2 col-xs-12">
        <div class="box">
          <div class="content">
            @php(print_r(App\Experience::getDiff()))
            <dl>
              @foreach(App\Experience::getDiff() as $diff)

              @endforeach
            </dl>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
