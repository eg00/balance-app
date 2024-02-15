<script setup lang="ts">
import OperationsTable from '@/Components/OperationsTable.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Operation } from '@/types/Operation';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const search = ref('')
const props =defineProps({
    operations: {
        type: Object,
        required: true,
    },
});

const filterOperations = computed(() => {
    if(search.value === '') return props.operations.data
    return props.operations.data.filter((operation: Operation) => {
        return operation.description.toLowerCase().includes(search.value.toLowerCase())
    })
})


</script>

<template>
    <Head title="Operations"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Operations
            </h2>
        </template>

        <div class="card my-4 shadow-sm">

            <div class="card-header d-flex justify-content-end">
                <input
                    class="form-control w-50"
                    type="text"
                    name="search"
                    placeholder="search..."
                    v-model="search"
                />
            </div>

            <div class="card-body">
                <div class="row">
                    <OperationsTable class="col" :operations="filterOperations"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
