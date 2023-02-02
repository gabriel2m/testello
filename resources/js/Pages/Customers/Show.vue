<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps(['customer']);

</script>
 
<template>

    <Head title="Create Customer" />

    <AuthenticatedLayout>
        <template #header>
            Customer
        </template>

        <span class="text-gray-500">Nome: </span>
        <span class="text-2xl">{{ customer.name }}</span> 
    </AuthenticatedLayout>
</template>
