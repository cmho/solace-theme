@php
  global $post;
@endphp
@if(get_query_var('view') === 'rumors')
    @if(App\Characters::activeList())
        @foreach(App\Characters::activeList() as $char)
            @if(App\Character::getRumors($char->ID, get_the_ID()))
                <div class="character">
                    <h2>Rumors for {{ get_the_title($char->ID) }}</h2>
                    @foreach(App\Character::getRumors($char->ID, get_the_ID()) as $post)
                        @php(setup_postdata())
                        <div class="rumor">
                            @php(the_content())
                        </div>
                    @endforeach
                    @php(wp_reset_postdata())
                </div>
            @endif
        @endforeach
    @endif
@elseif(get_query_var('view') === 'downtimes')
    @if(App\Characters::activeList())
        @foreach(App\Characters::activeList() as $char)
            @if(App\Character::getRumors($char->ID, get_the_ID()))
                <div class="character">
                    <h2>Downtimes for {{ get_the_title($char->ID) }}</h2>
                    @foreach(App\Character::getRumors($char->ID, get_the_ID()) as $post)
                        @php(setup_postdata())
                        <div class="downtime">
                            <h3>{{ get_the_title() }}</h3>
                            @php(the_field('response'))
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    @endif
@else
    
@endif