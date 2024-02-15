<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <div class="container my-auto">
        <div class="row justify-content-center">
            <Link href="/" class="col-1">
                <ApplicationLogo class="container" />
            </Link>
        </div>

        <div class="row justify-content-center">
            <div class="col-4">
                <slot/>
            </div>
        </div>
    </div>
</template>
