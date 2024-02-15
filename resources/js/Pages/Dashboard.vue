<script setup lang="ts">
import OperationsTable from '@/Components/OperationsTable.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Balance } from '@/types/Balance';
import { Operation } from '@/types/Operation';
import { Head } from '@inertiajs/vue3';

import { onMounted, onUnmounted, ref } from 'vue';

const balance = ref<Balance>({amount: 0, currency: '', updated_at: ''});
const operations = ref<Operation[]>([]);
let timerId: number;
const getData = () => {
    window.axios.get(route('user'))
        .then(({data}) => {
            balance.value = data.data.balance
            operations.value = data.data.operations
        })
}
timerId = setInterval(getData, 5000)

onMounted(() => {
    getData()
})
onUnmounted(() => {
    clearInterval(timerId)
})


</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Balance
            </h2>
        </template>

        <div class="card my-4 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h2>Balance : {{balance.amount}} {{balance.currency}}</h2>
                        <small>Updated at : {{balance.updated_at}}</small>
                    </div>
                    <OperationsTable class="col-6" :operations="operations"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
