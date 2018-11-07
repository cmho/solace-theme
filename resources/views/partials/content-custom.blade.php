@if(have_rows('sections'))
  @while(have_rows('sections'))
    @php(the_row())
    @if(get_row_layout() == 'single_text_column')
      <section class="{{ get_sub_field('color') }}">
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
                  {!! get_sub_field('content') !!}
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    @elseif(get_row_layout() == 'image_and_text')
      <section class="{{ get_sub_field('color') }}">
        <div class="wrapper">
          <div class="row top-xs">
            @if(get_sub_field('image_position') == 'left')
              <div class="col-md-5 col-xs-12 side-image">
                <img src="{{ get_sub_field('image')['sizes']['large'] }}" />
              </div>
            @endif
            <div class="col-md-7 col-xs-12">
                <div class="box">
                  <div class="content">
                    <h2>{{ get_sub_field('heading') }}</h2>
                    {!! get_sub_field('content') !!}
                  </div>
                </div>
              </div>
              @if(get_sub_field('image_position') == 'right')
                <div class="col-md-5 col-xs-12 side-image">
                  <img src="{{ get_sub_field('image')['sizes']['large'] }}" />
                </div>
              @endif
            </div>
          </div>
        </div>
      </section>
    @elseif(get_row_layout() == 'centered_content')
      <section class="{{ get_sub_field('color') }}">
        <div class="wrapper">
          <div class="row center-xs">
            <div class="col-xs-12">
              <h2>{{ get_sub_field('heading') }}</h2>
              <div class="center">
                {!! get_sub_field('content') !!}
              </div>
            </div>
          </div>
        </div>
      </section>
    @elseif(get_row_layout() == 'two_column_text')
      <section class="yellow">
        <div class="wrapper">
          <h2>{{ get_sub_field('heading') }}</h2>
          <div class="twocols">
            {!! get_sub_field('content') !!}
          </div>
        </div>
      </section>
    @endif
  @endwhile
@endif
