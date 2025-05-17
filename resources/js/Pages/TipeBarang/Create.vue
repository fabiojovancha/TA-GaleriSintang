<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    nama: '',
});

function submitForm() {
    form.post(route('tipeBarang.store'), { 
        onSuccess: () => {
            router.visit(route('tipeBarang')); 
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
}
</script>

<template>
    <Head title="Add Tipe Barang" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add Tipe Barang
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
                    <div class="flex justify-between items-center">
                        <Link :href="route('tipeBarang')" class="text-gray-600 hover:underline">Kembali</Link>
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
