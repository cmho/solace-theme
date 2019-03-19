<template>
  <ol class="characters" v-if="info.characters">
      <character v-for="character in info.characters" :key="character.ID"></character>
  </ol>
</template>

<script>
import axios from 'axios';
import Character from './character.vue';

export default {
  data: {
    characters: [],
  },
  components: {
    Character
  },
  methods: function() {
    axios.get('/wp-json/solace/v1/dashboard/characters').then(function(response) {
      self.data.characters = JSON.parse(response);
    });
  }
}
</script>
