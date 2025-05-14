<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    supplier: Object
});

const form = useForm({
    nama: props.supplier.nama,
    alamat: props.supplier.alamat,
    noTelp: props.supplier.noTelp,
});

function submitForm() {
    console.log(form); 
    form.put(route('supplier.update', props.supplier.id), {
        onSuccess: () => {
            router.visit(route('supplier')); 
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
}

</script>

<template>
    <Head title="Edit Supplier" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Supplier
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
                <form @submit.prevent="submitForm" class="grid gap-4">
                    <div>
                        <label for="id" class="block text-sm font-medium text-gray-700">ID Supplier</label>
                        <input
                            id="id"
                            v-model="form.id"
                            type="text"
                            class="border rounded px-4 py-2 w-full"
                            disabled
                            :placeholder="props.supplier.id"
                        />
                    </div>
                    
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama </label>
                        <input
                            id="nama"
                            v-model="form.nama"
                            type="text"
                            class="border rounded px-4 py-2 w-full"
                            required
                        />
                    </div>
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea
                            id="alamat"
                            v-model="form.alamat"
                            class="border rounded px-4 py-2 w-full"
                            rows="4"
                            required
                        ></textarea>
                    </div>
                    <div>
                        <label for="noTelp" class="block text-sm font-medium text-gray-700">noTelp</label>
                        <input
                            id="noTelp"
                            v-model="form.noTelp"
                            type="number"
                            class="border rounded px-4 py-2 w-full"
                            required
                        />
                    </div>

                    <div class="flex justify-between items-center">
                        <Link :href="route('supplier')" class="text-gray-600 hover:underline">Kembali</Link>
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        >
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
