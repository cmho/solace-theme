@if(have_rows('sections'))
  @php
    $count = 1;
  @endphp
  @while(have_rows('sections'))
    @php(the_row())
    @if(get_row_layout() == 'single_text_column')
      <section id="section-{{ $count }}" class="{{ get_sub_field('color') }}">
        <div class="wrapper">
          <div class="row center-xs">
            <div class="col-xs-12">
              <h2>{{ get_sub_field('heading') }}</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="content">
                  {{ get_sub_field('content') }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    @elseif(get_row_layout() == 'image_and_text')
      <section id="section-{{ $count }}" class="{{ get_sub_field('color') }}">
        <div class="wrapper">
          <div class="row top-xs">
            <div class="col-md-7 col-xs-12">
                <div class="box">
                  <div class="content">
                    <h2>{{ get_sub_field('heading') }}</h2>
                    {{ get_sub_field('content') }}
                  </div>
                </div>
              </div>
              <div class="col-md-5 col-xs-12 side-image">
                <img src="{{ get_sub_field('image')['sizes']['large'] }}" />
              </div>
            </div>
          </div>
        </div>
      </section>
    @elseif(get_row_layout() == 'centered_content')
      <section id="section-{{ $count }}" class="{{ get_sub_field('color') }}">
        <div class="wrapper">
          <div class="row center-xs">
            <div class="col-xs-12">
              <h2>{{ get_sub_field('heading') }}</h2>
              <div class="center">
                {{ get_sub_field('content') }}
              </div>
            </div>
          </div>
        </div>
    @endif
    @php
      $count++;
    @endphp
  @endwhile
@endif
