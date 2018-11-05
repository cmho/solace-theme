<section id="basics" color="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-4 col-sm-6 col-xs-12 center">
        <div class="form-row">
          <label for="post_title">Character Name</label>
          <input type="text" name="post_title" value="" />
        </div>
        <div class="form-row">
          <label for="family">Family</label>
          <select name="family">
            @php(print_r(get_field_object('field_5bdcf10d1a80b')))
            @foreach(get_field_object('field_5bdcf10d1a80b')['choices'] as $value=>$label)
              <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
          </select>
        </div>
        @if($is_admin)
          <div class="form-row">
            <label for="is_npc"><input type="checkbox" name="is_npc" value="true" /> Is NPC?</label>
          </div>
          <div class="form-row">
            <label for="is_secret"><input type="checkbox" name="is_secret" value="true" /> Is Secret?</label>
          </div>
        @endif
      </div>
      <div class="col-md-8 col-sm-6 col-xs-12">
        <div class="box">
          <div class="content">
            <div class="form-row">
              <label for="quote">Quote</label>
              <input type="text" name="quote" value="" />
            </div>
            <div class="form-row">
              <label for="public_blurb">Public Blurb</label>
              <textarea name="public_blurb" rows="8"></textarea>
            </div>
            <dl>
              <dt>Status</dt>
              <dd>{{ get_field('status') }}</dd>
              <dt>Virtue</dt>
              <dd>{{ get_field('virtue') }}</dd>
              <dt>Vice</dt>
              <dd>{{ get_field('vice') }}</dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
