<section>
    <div class="wrapper">
        <div class="row">
            <div class="col-xs-12">
                <h2>Characters by Family</h2>
                <div class="row">
                    @foreach(App\Characters::getInitiations() as $fam => $members)
                        <div class="col-md-4 col-xs-12">
                            <h3>{{ $fam }}</h3>
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
                      <h3>{{ $merit }}</h3>
                      <canvas id="{{ str_replace(" ", "-", strtolower($merit)) }}" data-points="{{ join(",", $spread['counts']) }}"></canvas>
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
                @php($it = App\Characters::getIntegrityTimeline())
                <canvas id="integrity" data-points="{{ join(";", array_map(function($i) { return join(",", array_map(function($c) { return $c['integrity']; }, $i)); }, $it)) }}" data-labels="{{ join(";", array_map(function($i) { return join(",", array_map(function($c) { return $c['date']; }, $i)); }, $it)) }}" data-characters="{{ join(",", array_keys($it)) }}"></canvas>
            </div>
        </div>
    </div>
</section>
