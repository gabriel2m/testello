<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps(['customer']);

const form = useForm({});

const deleteCustomer = () => {
    form.delete(route('customers.destroy', props.customer));
};

</script>
 
<template>

    <Head :title="`${customer.name} - Customer`" />

    <AuthenticatedLayout>
        <template #header>
            Customer
        </template>

        <span class="text-gray-500">Nome: </span>
        <span class="text-2xl">{{ customer.name }}</span>

        <hr class="my-5">

        <Link :href="route('customers.edit', customer.id)"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        Edit Customer
        </Link>

        <DangerButton class="ml-3" @click="deleteCustomer">
            Delete Customer
        </DangerButton>
    </AuthenticatedLayout>

</template>
