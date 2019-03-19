<template>
    <li class="character" :data-character="character.ID">

    </li>
</template>

<script>
    import Conditions from './conditions.vue';

    export default {
        data () {
            return {
                conditions: [],
                health: 0,
                willpower: 0,
            };
        },
        created () {
            return;
        },
        methods: {

        }
    }
</script>
