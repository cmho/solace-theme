<template>
    <ol class="characters" v-if="info.characters">
        <character v-for="character in info.characters" :key="character.ID"></character>
    </ol>
</template>

<script>
    import Vue from 'vue'
    import VueResource from 'vue-resource'
    import Character from './character.vue'

    Vue.use(VueResource)

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
