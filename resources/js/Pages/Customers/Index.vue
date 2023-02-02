<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { useForm, Head, Link } from '@inertiajs/vue3';

defineProps(['customers']);

// const form = useForm({
//     message: '',
// });
</script>
 
<template>

    <Head title="Customers" />

    <AuthenticatedLayout>
        <template #header>
            Customers
        </template>

        <Link :href="route('customers.create')"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        Create Customer
        </Link>

        <table class="w-full whitespace-nowrap mt-6">
            <tr v-for="customer in customers.data" :key="customer.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-y">
                    <Link class="flex items-center px-6 py-4" :href="`/customers/${customer.id}`" tabindex="-1">
                    {{ customer.name }}
                    </Link>
                </td>
            </tr>
            <tr v-if="customers.data.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">No customers found.</td>
            </tr>
        </table>
        <!-- 
            ADD SEARCH
            <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
          <form @submit.prevent="form.post(route('customers.store'), { onSuccess: () => form.reset() })">
              <textarea v-model="form.message" placeholder="What's on your mind?"
                  class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
              <InputError :message="form.errors.message" class="mt-2" />
              <PrimaryButton class="mt-4">Chirp</PrimaryButton>
          </form>
      </div> -->

        <pagination class="mt-6" :links="customers.links" />
    </AuthenticatedLayout>
</template>
