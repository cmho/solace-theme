<section>
    <div class="wrapper">
        <div class="row">
            <div class="col-xs-12">
                <h2>Total Characters: {{ count(App\Characters::getActivePCs())}}</h2>
                <h2>Characters by Family</h2>
                <div class="row">
                    @foreach(App\Characters::getInitiations() as $fam => $members)
                        <div class="col-md-4 col-xs-12">
                            <h3>{{ $fam }} ({{ count($members) }})</h3>
                            <ul>
                                @foreach($members as $member)
                                    <li>{!! $member['rating'] > 3 ? '<strong>' : '' !!}<a href="{{ $member['link'] }}">{{ $member['name'] }}</a> ({{ $member['rating'] ? $member['rating'] : 1 }}){!! $member['rating'] > 3 ? '</strong>' : '' !!}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>


                <h2>Skill Distribution</h2>
                <div class="row" id="skills-row">
                    @foreach(App\Characters::getSkillSpreads() as $skill => $spread)
                        <div class="col-md-4 col-xs-12">
                            <h3>{{ $skill }}</h3>
                            <canvas id="{{ $skill }}" data-points="{{ join(",", $spread['counts']) }}"></canvas>
                            <ul class="rankings">
                              @foreach($spread['characters'] as $i=>$lv)
                                @if($i != 0 && count($lv) > 0)
                                  <li><strong>{{ $i }}:</strong> {{ join(", ", $lv) }}</li>
                                @endif
                              @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <h2>Merit Distribution</h2>
                <div class="row" id="merits-row">
                  @foreach(App\Characters::getMeritSpreads() as $merit => $spread)
                    <div class="col-md-4 col-xs-12">
                      <h3>{{ $merit }} ({{ $spread['total'] }})</h3>
                      @if(count($spread['allowed_ratings']) > 0)
                        <canvas id="{{ str_replace(" ", "-", strtolower($merit)) }}" data-points="{{ join(",", $spread['counts']) }}"></canvas>
                      @endif
                        <ul class="rankings">
                            @foreach($spread['characters'] as $i=>$lv)
                            @if($i != 0 && count($lv) > 0)
                                <li><strong>{{ $i }}:</strong> {{ join(", ", $lv) }}</li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                  @endforeach
                </div>

                <h2>Integrity</h2>
                <div class="button-row right">
                  <button id="snapshot" class="button">Create Snapshot</button>
                </div>
                @php($it = App\Characters::getIntegrityTimeline())
                <canvas id="integrity" data-points="{{ join(";", array_map(function($l) { return join(",", $l); }, $it['characters'])) }}" data-labels="{{ join(",", $it['labels']) }}" data-characters="{{ join(",", array_keys($it['characters'])) }}"></canvas>
                <h3>Averages</h3>
                <ul>
                  @for($i = 0; $i < count($it['averages']); $i++)
                    <li><strong>{{ $it['labels'][$i] }}:</strong> {{ $it['averages'][$i] }}</li>
                  @endfor
                </ul>
            </div>
        </div>
    </div>
</section>
