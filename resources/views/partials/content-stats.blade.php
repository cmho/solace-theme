<h2>Characters by Family</h2>
<div class="row">
    @foreach(App\Characters::getInitiations() as $fam => $members)
        <div class="col-md-4 col-xs-12">
            <h3>{{ $fam }}</h3>
            <ul>
                @foreach($members as $member)
                    <li>{{ $member['rating'] > 3 ? '<strong>' : '' }}<a href="{{ $member['link'] }}">{{ $member['name'] }}</a>{{ $member['rating'] > 3 ? '</strong>' : '' }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>

<h2>Skill Spread</h2>