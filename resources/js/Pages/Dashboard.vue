<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Balance
            </h2>
        </template>

        <div class="card my-4 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-6"> </div>
                    <div class="col-6"> </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
