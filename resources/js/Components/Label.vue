<script setup>
defineProps(['value']);
</script>

<template>
    <label class="text-dark">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
