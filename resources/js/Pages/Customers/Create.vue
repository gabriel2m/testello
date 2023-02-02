<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    remember: false,
});
</script>
 
<template>

    <Head title="Create Customer" />

    <AuthenticatedLayout>
        <template #header>
            Create Customer
        </template>

        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('customers.store'))">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <PrimaryButton class="mt-6" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    store
                </PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
