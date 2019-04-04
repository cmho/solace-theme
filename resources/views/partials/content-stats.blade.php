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


                <h2>Skill Spread</h2>
                <div class="row" id="skills-row">
                    @foreach(App\Characters::getSkillSpreads() as $skill => $spread)
                        <div class="col-md-4 col-xs-12">
                            <h3>{{ $skill }}</h3>
                            <canvas id="{{ $skill }}" data-points="{{ join(",", $spread) }}"></canvas>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    jQuery(window).on('load', function() {
        jQuery("#skills-row canvas").each(function(i, elt) {
        var data = jQuery(this)
            .data("points")
            .split(",")
            .map(function(x) {
            return parseInt(x);
            });
        var chart = new Chart(jQuery(this), {
            type: "bar",
            data: {
            labels: [0, 1, 2, 3, 4, 5],
            datasets: [
                {
                data: data,
                fill: false,
                backgroundColor: "yellow",
                borderWidth: 1
                }
            ]
            },
            options: {
            scales: {
                yAxes: [
                {
                    gridLines: {
                    drawTicks: false,
                    color: "rgba(255,255,255,.5)"
                    },
                    ticks: {
                    beginAtZero: true
                    },
                    labels: {
                    fontColor: "white"
                    }
                }
                ],
                xAxes: [
                {
                    gridLines: {
                    color: "rgba(255,255,255,.5)"
                    }
                }
                ]
            },
            legend: {
                display: false
            }
            }
        });
        });
    });
</script>