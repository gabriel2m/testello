<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { Dropzone } from 'dropzone';

const props = defineProps(['customer']);

const dropRef = ref(null);

const customPreview = `
      <div class="dz-preview dz-processing dz-image-preview dz-complete">
        <div class="dz-image">
          <img data-dz-thumbnail>
        </div>
        <div class="dz-details">
          <div class="dz-size"><span data-dz-size></span></div>
            <div class="dz-filename"><span data-dz-name></span></div>
          </div>
          <div class="dz-progress">
            <span class="dz-upload" data-dz-uploadprogress></span>
          </div>
          <div class="dz-error-message"><span data-dz-errormessage></span></div>
          <div class="dz-success-mark">
            <svg width="54" height="54" viewBox="0 0 54 54" fill="white" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.2071 29.7929L14.2929 25.7071C14.6834 25.3166 15.3166 25.3166 15.7071 25.7071L21.2929 31.2929C21.6834 31.6834 22.3166 31.6834 22.7071 31.2929L38.2929 15.7071C38.6834 15.3166 39.3166 15.3166 39.7071 15.7071L43.7929 19.7929C44.1834 20.1834 44.1834 20.8166 43.7929 21.2071L22.7071 42.2929C22.3166 42.6834 21.6834 42.6834 21.2929 42.2929L10.2071 31.2071C9.81658 30.8166 9.81658 30.1834 10.2071 29.7929Z" />
            </svg>  
          </div>  
          <div class="dz-error-mark">
            <svg width="54" height="54" viewBox="0 0 54 54" fill="white" xmlns="http://www.w3.org/2000/svg">
              <path d="M26.2929 20.2929L19.2071 13.2071C18.8166 12.8166 18.1834 12.8166 17.7929 13.2071L13.2071 17.7929C12.8166 18.1834 12.8166 18.8166 13.2071 19.2071L20.2929 26.2929C20.6834 26.6834 20.6834 27.3166 20.2929 27.7071L13.2071 34.7929C12.8166 35.1834 12.8166 35.8166 13.2071 36.2071L17.7929 40.7929C18.1834 41.1834 18.8166 41.1834 19.2071 40.7929L26.2929 33.7071C26.6834 33.3166 27.3166 33.3166 27.7071 33.7071L34.7929 40.7929C35.1834 41.1834 35.8166 41.1834 36.2071 40.7929L40.7929 36.2071C41.1834 35.8166 41.1834 35.1834 40.7929 34.7929L33.7071 27.7071C33.3166 27.3166 33.3166 26.6834 33.7071 26.2929L40.7929 19.2071C41.1834 18.8166 41.1834 18.1834 40.7929 17.7929L36.2071 13.2071C35.8166 12.8166 35.1834 12.8166 34.7929 13.2071L27.7071 20.2929C27.3166 20.6834 26.6834 20.6834 26.2929 20.2929Z" />
          </svg>  
        </div>
      </div>
    `;

onMounted(() => {
    if (dropRef.value !== null) {
        new Dropzone(dropRef.value, {
            chunking: true,
            maxFilesize: 400000000,
            chunkSize: 1000000,
            previewTemplate: customPreview,
            url: route('deliveries.bulk-store', props.customer.id),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            previewsContainer: dropRef.value.parentElement.querySelector('.preview-container')
        })

        if (dropRef.value.querySelector('.dz-default')) {
            dropRef.value.querySelector('.dz-default').innerHTML = `
            <div style="display: flex; justify-content: center;">
              <svg width="10em" height="10em" viewBox="0 0 16 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="pointer-events: none;">
                <path fill-rule="evenodd" d="m 8.0274054,0.49415269 a 5.53,5.53 0 0 0 -3.594,1.34200001 c -0.766,0.66 -1.321,1.52 -1.464,2.383 -1.676,0.37 -2.94199993,1.83 -2.94199993,3.593 0,2.048 1.70799993,3.6820003 3.78099993,3.6820003 h 8.9059996 c 1.815,0 3.313,-1.43 3.313,-3.2270003 0,-1.636 -1.242,-2.969 -2.834,-3.194 -0.243,-2.58 -2.476,-4.57900001 -5.1659996,-4.57900001 z m 2.3539996,5.14600001 -1.9999996,-2 a 0.5,0.5 0 0 0 -0.708,0 l -2,2 a 0.5006316,0.5006316 0 1 0 0.708,0.708 l 1.146,-1.147 v 3.793 a 0.5,0.5 0 0 0 1,0 v -3.793 l 1.146,1.147 a 0.5006316,0.5006316 0 0 0 0.7079996,-0.708 z"/>
              </svg>
            </div>
            <p style="text-align: center; margin: 0;"><strong>Drag and drop files to upload</strong></p>
            <p style="text-align: center; margin-top: 0;"><small style="color: #999;">Your files will be added automatically</small></p>
            <button class="dz-button" type="button" style="border: 2px solid currentColor; padding: 10px; border-radius: 5px; font-weight: 700;">or select files</button>
          `
        }
    }
})
</script>
 
<template>

    <Head :title="`Update Delivery Table - ${customer.name} - Customers`" />

    <AuthenticatedLayout>
        <template #header>
            Update Delivery Table - {{ customer.name }}
            <Link :href="route('customers.show', customer.id)"
                class="ml-5 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Go Back
            </Link>
        </template>

        <div class="text-indigo-400">
            <div ref="dropRef" class="dropzone custom-dropzone border-dashed border-2 border-indigo-200 p-7"></div>
            <div class="dropzone preview-container"></div>
            <p class="mt-2 text-gray-600 underline">Just drop your files and the deliveries will be created</p>
        </div>
    </AuthenticatedLayout>

</template>
