<script setup lang="ts">
import { Operation } from '@/types/Operation';

defineProps({
    operations: {type: Array<Operation>, required: true},
})
</script>

<template>
    <div>
        <h3>Operations</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Amount</th>
                <th scope="col">date </th>
                <th scope="col">description</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="operation in operations" :key="operation.id">
                <th>{{ operation.id }}</th>
                <td>{{ operation.amount }}</td>
                <td>{{ operation.created_at }}</td>
                <td>{{ operation.description }}</td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<style scoped>

</style>
