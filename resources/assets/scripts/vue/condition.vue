<template>
    <li>
        {{ condition.condition.post_title }}{{ condition.note ? ' ('+condition.note+')' : '' }}
        <button type="button" class="button resolve-button">Resolve</button>
        <button class="delete-button" type="button"><i class="fas fa-trash"></i><span class="sr-only">Delete</span></button>
    </li>
</template>