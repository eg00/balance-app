<script setup lang="ts">
defineProps<{
    message?: string;
}>();
</script>

<template>
    <div v-show="message">
        <p class="invalid-feedback">
            {{ message }}
        </p>
    </div>
</template>
