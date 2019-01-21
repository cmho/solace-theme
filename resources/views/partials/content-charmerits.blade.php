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
    @php
        $post = $merit['merit'];
        setup_postdata($post);
    @endphp
    <li><span class="label"><span class="meritname">{{ get_the_title() }}</span><span class="specification">{{ get_field('requires_specification') ? " (".$merit['specification'].")" : '' }}</span><span class="rating">{{ count(get_field('allowed_ratings')) > 1 ? " ".$merit['rating'] : '' }}</span></span><button class="js-modal edit" data-modal-content-id="merits-modal"><i class='fas fa-pencil-alt'></i></button> <button type="button" class="delete"><i class='fas fa-trash'></i></button>{{ $merit['description'] ? '<div>'.$merit['description'].'</div>' : '' }}<input type='hidden' name='merits_{{ $i }}_merit' value='{{ $merit['merit']->ID }}' class='merit-id' /><input type='hidden' name='merits_{{ $i }}_rating' value='{{ $merit['rating'] }}' /><input type='hidden' name='merits_{{ $i }}_specification' value='{{ $merit['specification'] }}' /><input type='hidden' name='merits_{{ $i }}_description' value='{{ $merit['description'] }}' /></li>
  @endforeach
  @php(wp_reset_postdata())
</ul>
<div id="merits-modal" class="hidden">
  <div class="content" id="modal-content">
    <h4></h4>
    <div class="description"></div>
    <div class="prerequisites"></div>
    <div class="form-row" id="ratings-row">
      <label for="ratings">Rating</label>
      <select id="ratings" name="ratings">
      </select>
    </div>
    <div class="form-row" id="specification-row">
      <label>Specification</label>
      <input type="text" name="specification" id="specification" />
    </div>
    <div class="form-row" name="description" id="description-row">
      <label>Description</label>
      <textarea name="description"></textarea>
    </div>
    <div class="form-row">
      <button type="button" id="save-merit">Save</button>
    </div>
  </div>
</div>
