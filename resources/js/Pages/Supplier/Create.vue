<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    nama: '',
    alamat: '',
    noTelp: '',
});

function submitForm() {
    form.post(route('supplier.store'), { 
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
    <Head title="Add Supplier" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add Supplier
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
                <form @submit.prevent="submitForm" class="grid gap-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input
                            id="nama"
                            v-model="form.nama"
                            type="text"
                            placeholder="Nama"
                            class="border rounded px-4 py-2 w-full"
                            required
                        />
                    </div>
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input
                            id="alamat"
                            v-model="form.alamat"
                            type="text"
                            placeholder="Alamat"
                            class="border rounded px-4 py-2 w-full"
                            required
                        ></input>
                    </div>
                    <div>
                        <label for="noTelp" class="block text-sm font-medium text-gray-700">no Telp</label>
                        <input
                            id="noTelp"
                            v-model="form.noTelp"
                            type="text"
                            placeholder="no Telp"
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
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
