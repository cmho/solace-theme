@php
  global $post;
  $user = wp_get_current_user();
  $char = App::isAdmin() ? null : App\Character::currentChar()->ID;
@endphp
@if(App\App::currentDowntimePeriod())
  <div class="button-row right">
    <a href="{{ App\App::newDowntimeLink() }}" class="button">New Action</a>
  </div>
@endif
@foreach(App\Downtimes::listDowntimes($char) as $game=>$downtimes)
  @php
      $gamepost = get_post($game);
  @endphp
  <h3 id="{{ $gamepost->post_name }}">{{ $gamepost->post_title }}</h3>
  @if(App\Downtimes::isOpen($game))
    <p class="downtime-status">Downtimes are currently <strong>open</strong>. They will close at 11:59 PM on {{ date('m/d/y', strtotime(get_field('downtimes_close', $game))) }}.</p>
  @endif
  @if($downtimes)
    @foreach($downtimes as $post)
      @php(setup_postdata($post))
      <div class="downtime box">
        <div class="content">
          <h4><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h4>
          @if(App\App::isAdmin())
            <p class="character"><strong>Character:</strong> <a href="{{ get_permalink(get_field('character')) }}" target="_blank">{{ get_post(get_field('character'))->post_title }}</a></p>
          @endif
          <p class="assets"><strong>Assets:</strong> {{ get_field('assets') }}</p>
          <p class="goal"><strong>Goal:</strong> {{ get_field('goal') }}</p>
          <div class="description">
            @php(the_content())
          </div>
          @if(get_field('response') && (get_field('downtimes_visible', $gamepost) || App\App::isAdmin()))
            <hr />
            <div class="response">
              <h5>Response:</h5>
              {!! get_field('response') !!}
            </div>
          @endif
          @if(App\App::isAdmin())
            <div class="button-row">
              <a href="{{ get_the_permalink() }}#response" button small>{{ (get_field('response')) ? 'Edit Response' : 'Respond' }}</a>
            </div>
          @elseif(App\Downtimes::isOpen($game))
            <div class="button-row">
              <a href="{{ get_the_permalink() }}edit" class="button small">Edit</a>
            </div>
          @endif
        </div>
      </div>
    @endforeach
    @php(wp_reset_postdata())
  @else
    <p><em>No downtimes for this game.</em></p>
  @endif
@endforeach
