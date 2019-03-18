<template>
    <ul class="char-conditions">
        <condition v-for="(condition, index) in character.meta_content.conditions" :key="index"></condition>
    </ul>
</template>