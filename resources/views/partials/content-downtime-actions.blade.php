@if(($_GET['character'] != 'null' && $_GET['character']))
    @php
        // redirect if not an appropriate user
        $char = get_post(intval($_GET['character']));
        if ($char->post_author != wp_get_current_user()->ID) {
            header('Location'.App\App::dashboardLink());
        }
    @endphp
    <div class="button-row right">
        <a href="#" class="button">New Action</a>
    </div>
    @foreach(App\Downtimes::listDowntimes as $game=>$downtimes)
        @php
            $gamepost = get_post($game->ID)
        @endphp
        <h3>{{ get_the_title($gamepost) }}</h3>
        @if(date('Ymd') >= get_field('downtimes_open', $game) && date('Ymd') <= get_field('downtimes_close', $game))
            <p class="downtime-status">Downtimes are currently <strong>open</strong>. They will close at 11:59 PM on {{ date('m/d/y', strtotime(get_field('downtimes_close', $game))) }}.</p>
        @endif
        @foreach($downtimes as $downtime)
            <div class="downtime">
                <h4>{{ get_the_title($downtime) }}</h4>
                <p class="assets"><strong>Assets:</strong> {{ get_field('assets', $downtime) }}</p>
                <p class="goal"><strong>Goal:</strong> {{ get_field('goal', $downtime) }}</p>
                <div class="description">
                    {!! get_field('description', $downtime) !!}
                </div>
                @if(get_field('response', $downtime))
                    <hr />
                    <div class="response">
                        {!! get_field('response', $downtime) !!}
                    </div>
                @endif
                @if(App\App::isAdmin())
                    <a href="{{ get_the_permalink($downtime) }}/?mode=respond">{{ (get_field('response', $downtime)) ? 'Edit Response' : 'Respond' }}</a>
                @endif
            </div>
        @endforeach
    @endforeach
@elseif(App\App::isAdmin() && $_GET['game'] != null)
    @php
      $game = get_post($_GET['game'])
    @endphp
    test
@else
  no game specified
@endif
