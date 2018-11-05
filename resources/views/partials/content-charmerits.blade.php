@php
  global $post;
@endphp

<h3>Merits</h3>
<select id="merits">
  @foreach(App\Merits::listGrouped() as $group=>$merits)
    <optgroup label="{{ $group }}">
      @foreach($merits as $post)
        @php(setup_postdata($post))
        <option value="{{ get_the_ID() }}" data-ratings="{{ get_field('allowed_ratings') }}" data-specification="{{ get_field('requires_specification') }}" data-description="{{ get_field('requires_description') }}">{{ get_the_title() }} ({{ App\Merit::dots() }})</option>
      @endforeach
      @php(wp_reset_postdata())
    </optgroup>
  @endforeach
</select>
<ul class="merits">
  @foreach(get_field('merits') as $merit)
    <li>{{ get_the_title($merit['merit']) }}{{ get_field('requires_specification', $merit['merit']) ? " (".$merit['specification'].")" : '' }}{{ count(get_field('allowed_ratings', $merit['merit'])) > 1 ? " ".$merit['rating'] : '' }}{{ $merit['description'] ? '<div>'.$merit['description'].'</div>' : '' }}</li>
  @endforeach
</ul>
