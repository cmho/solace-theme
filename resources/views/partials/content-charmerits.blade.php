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
<input type="hidden" name="merits" value="{{ count(get_field('merits')) }}" />
<button type="button" id="add-merit">Add</button>
<ul class="merits">
  @foreach(get_field('merits') as $i=>$merit)
    <li>{{ get_the_title($merit['merit']) }}{{ get_field('requires_specification', $merit['merit']) ? " (".$merit['specification'].")" : '' }}{{ count(get_field('allowed_ratings', $merit['merit'])) > 1 ? " ".$merit['rating'] : '' }}<i class='fas fa-pencil-alt'></i><i class='fas fa-trash'></i>{{ $merit['description'] ? '<div>'.$merit['description'].'</div>' : '' }}<input type='hidden' name='merits_{{ $i }}_merit' value='{{ $merit['merit']->ID }}' /><input type='hidden' name='merits_{{ $i }}_rating' value='{{ $merit['rating'] }}' /><input type='hidden' name='merits_{{ $i }}_specification' value='{{ $merit['specification'] }}' /><input type='hidden' name='merits_{{ $i }}_description' value='{{ $merit['description'] }}' /></li>
  @endforeach
</ul>
