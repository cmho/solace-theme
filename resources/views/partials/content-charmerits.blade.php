<h3>Merits</h3>
<select id="merits">
  @foreach(App\Merits::listGrouped() as $group=>$merits)

  @endforeach
</select>
<ul class="merits">
  @foreach(get_field('merits') as $merit)
    <li>{{ get_the_title($merit['merit']) }}{{ get_field('requires_specification', $merit['merit']) ? " (".$merit['specification'].")" : '' }}{{ count(get_field('allowed_ratings', $merit['merit'])) > 1 ? " ".$merit['rating'] : '' }}{{ $merit['description'] ? '<div>'.$merit['description'].'</div>' : '' }}</li>
  @endforeach
</ul>
