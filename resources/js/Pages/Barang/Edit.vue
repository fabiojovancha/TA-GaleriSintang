<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    barang: Object,
    tipeBarang: Object
});

const form = useForm({
    nama: props.barang.nama,
    deskripsi: props.barang.deskripsi,
    harga_beli: props.barang.harga_beli,
    harga_jual: props.barang.harga_jual,
    jumlah: props.barang.jumlah,
    tipe_barang_id: props.barang.tipe_barang_id,
});


function submitForm() {
    console.log(form);  
    form.put(route('barang.update', props.barang.id), {
        onSuccess: () => {
            router.visit(route('barang')); 
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
}

</script>

<template>
    <Head title="Edit Barang" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Barang
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
                <form @submit.prevent="submitForm" class="grid gap-4">
                    <!-- Menampilkan ID Barang -->
                    <div>
                        <label for="id" class="block text-sm font-medium text-gray-700">ID Barang</label>
                        <input
                            id="id"
                            v-model="form.id"
                            type="text"
                            class="border rounded px-4 py-2 w-full"
                            disabled
                            :placeholder="props.barang.id"
                        />
                    </div>
                    
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input
                            id="nama"
                            v-model="form.nama"
                            type="text"
                            class="border rounded px-4 py-2 w-full"
                            required
                        />
                    </div>
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea
                            id="deskripsi"
                            v-model="form.deskripsi"
                            class="border rounded px-4 py-2 w-full"
                            rows="4"
                            required
                        ></textarea>
                    </div>
                    <div>
                        <label for="harga_beli" class="block text-sm font-medium text-gray-700">Harga Beli</label>
                        <input
                            id="harga_beli"
                            v-model="form.harga_beli"
                            type="number"
                            class="border rounded px-4 py-2 w-full"
                            required
                        />
                    </div>
                    <div>
                        <label for="harga_jual" class="block text-sm font-medium text-gray-700">Harga Jual</label>
                        <input
                            id="harga_jual"
                            v-model="form.harga_jual"
                            type="number"
                            class="border rounded px-4 py-2 w-full"
                            required
                        />
                    </div>
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                        <input
                            id="jumlah"
                            v-model="form.jumlah"
                            type="number"
                            class="border rounded px-4 py-2 w-full"
                            required
                        />
                    </div>
                    <div>
                        <label for="tipe_barang_id" class="block text-sm font-medium text-gray-700">Tipe Barang</label>
                        <input
                            id="tipe_barang_id"
                            v-model="form.tipe_barang_id"
                            type="text"
                            class="border rounded px-4 py-2 w-full"
                            required
                        />
                    </div>

                    <div class="flex justify-between items-center">
                        <Link :href="route('barang')" class="text-gray-600 hover:underline">Kembali</Link>
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
