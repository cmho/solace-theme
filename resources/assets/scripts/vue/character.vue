<template>
    <li class="character" :data-character="character.ID">
        <h3><a href="#">{{ character.post_title }}</a></h3>
        <div class="character-content">
        <div class="health" data-health="{{ character.meta_content.current_health }}">
            <h4>Health</h4>
            {{ App\Character::printSquaresInteractable(get_field('current_health')) }}
        </div>
        <div class="willpower" data-willpower="{{ character.meta_content.current_willpower }}">
            <h4>Willpower</h4>
            {{ App\Character::printSquaresInteractable(get_field('current_willpower')) }}
        </div>
        <div class="integrity">
            <h4>Integrity</h4>
            <span class="current-integrity">{{ character.meta_content.integrity }}</span> <button type="button" class="button small breaking-point">Breaking Point</button>
        </div>
        <div class="conditions">
            <h4>Conditions</h4>
            <conditions></conditions>
            <form class="condition-form">
            <div class="row">
                <div class="form-row" id="select-control">
                <label for="conditions_list">Condition</label>
                <select class="conditions_list" name="condition">
                    @foreach(App\Conditions::list() as $condition)
                    <option value="{{ $condition->ID }}">{{ get_the_title($condition->ID)}}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-row" id="note-control">
                <label for="note">Note</label>
                <input type="text" name="note" class="condition_note" />
                </div>
            </div>
            <button type="button" class="button small add-condition">Add</button>
            <input type="hidden" name="conditions" val="{{ character.meta_content.conditions.length }}" />
            </form>
        </div>
        <div class="notes">
            <h4>Storyteller Notes</h4>
            <textarea name="st_notes">{!! character.meta_content.st_notes !!}</textarea>
        </div>
        </div>
    </li>
</template>

<script>
    import Conditions from 'conditions'
    import Condition from 'condition'

    export default {
        components: {
            Character
        },
        data () {
            return {
                characters: []
            };
        },
        created () {
            this.getCharacters();
        },
        methods: {
            getCharacters() {
                this.$http.get('/wp-json/dashboard/v1/storytellers/characters').then(function(res) {
                    this.characters = res.body;
                }, function(res) {
                    console.log('error', res);
                });
            }
        }
    }
</script>