<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12 center">
    <div class="form-row">
      <label for="post_title">Character Name</label>
      <input type="text" name="post_title" value="{!! get_the_title() !!}" />
    </div>
    <div class="form-row">
      <label for="family">Family</label>
      <select name="family">
        @foreach(get_field_object('field_5bdcf10d1a80b')['choices'] as $value=>$label)
          <option value="{{ $value }}"{{ get_field('family') == $value ? ' selected="selected"' : '' }}>{{ $label }}</option>
        @endforeach
      </select>
    </div>
    @if($is_admin)
      <div class="form-row">
        <label for="is_npc"><input type="checkbox" name="is_npc" value="true"{{ get_field('is_npc') ? ' checked="checked"' : '' }} /> Is NPC?</label>
      </div>
      <div class="form-row">
        <label for="is_secret"><input type="checkbox" name="is_secret" value="true"{{ get_field('is_secret') ? ' checked="checked"' : '' }} /> Is Secret?</label>
      </div>
    @endif
  </div>
  <div class="col-md-8 col-sm-6 col-xs-12">
    <div class="box">
      <div class="content">
        <div class="form-row">
          <label for="quote">Quote</label>
          <input type="text" name="quote" value="{!! htmlspecialchars(get_field('quote', false)) !!}" />
        </div>
        <div class="form-row">
          <label for="public_blurb">Public Blurb</label>
          <textarea name="public_blurb" rows="8">{!! get_field('public_blurb', false) !!}</textarea>
        </div>
        <div class="form-row">
          <label for="virtue">Virtue</label>
          <select name="virtue">
            @foreach(get_field_object('field_5bdcf0c71a809')['choices'] as $value=>$label)
              <option value="{{ $value }}"{{ get_field('virtue') == $value ? ' selected="selected"' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-row">
          <label for="vice">Vice</label>
          <select name="vice">
            @foreach(get_field_object('field_5bdcf1081a80a')['choices'] as $value=>$label)
              <option value="{{ $value }}"{{ get_field('vice') == $value ? ' selected="selected"' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        @if($is_admin)
          <div class="form-row">
            <label for="status">Status</label>
            <select name="status">
              @foreach(get_field_object('field_5bdd389ba91cf')['choices'] as $value=>$label)
                <option value="{{ $value }}"{{ get_field('status') == $value ? ' selected="selected"' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
          </div>
        @else
          <input type="hidden" name="status" value="In Progress" />
        @endif
      </div>
    </div>
  </div>
</div>
