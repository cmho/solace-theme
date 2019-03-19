<template>
    <ol class="characters" v-if="info.characters">
        <character v-for="character in info.characters" :key="character.ID"></character>
    </ol>
</template>
