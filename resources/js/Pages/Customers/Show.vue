<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps(['customer', 'deliveries']);

const form = useForm({});

const deleteCustomer = () => {
    form.delete(route('customers.destroy', props.customer));
};

const reais = (val) => val.toLocaleString('pt-br', {
    style: 'currency',
    currency: 'BRL'
});

const kg = (val) => Number(val).toFixed(2) + ' KG';

</script>
 
<template>

    <Head :title="`${customer.name} - Customers`" />

    <AuthenticatedLayout>
        <template #header>
            Customer
        </template>

        <span class="text-gray-500">Name: </span>
        <p class="text-2xl mt-2">{{ customer.name }}</p>

        <hr class="my-5">

        <span class="text-gray-500">Delivery Table: </span>

        <Link :href="route('deliveries.bulk-create', customer.id)"
            class=" ml-6 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        Update Table
        </Link>

        <div class="relative overflow-x-auto">
            <table class="w-full whitespace-nowrap mt-5">
                <thead v-if="deliveries.data.length !== 0">
                    <tr>
                        <th class="text-left px-5">
                            Poscode from
                        </th>
                        <th class="text-left px-5">
                            Poscode to
                        </th>
                        <th class="text-left px-5">
                            Weight from
                        </th>
                        <th class="text-left px-5">
                            Weight to
                        </th>
                        <th class="text-left px-5">
                            Cost
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="delivery in deliveries.data" :key="delivery.id"
                        class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-y py-3 px-5">
                            {{ delivery.from_postcode }}
                        </td>
                        <td class="border-y py-3 px-5">
                            {{ delivery.to_postcode }}
                        </td>
                        <td class="border-y py-3 px-5">
                            {{ kg(delivery.from_weight) }}
                        </td>
                        <td class="border-y py-3 px-5">
                            {{ kg(delivery.to_weight) }}
                        </td>
                        <td class="border-y py-3 px-5">
                            {{ reais(delivery.cost) }}
                        </td>
                    </tr>
                    <tr v-if="deliveries.data.length === 0">
                        <td class="px-6 py-4 border-y" colspan="4">No deliveries found.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <pagination class="mt-6" :links="deliveries.links" />

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
