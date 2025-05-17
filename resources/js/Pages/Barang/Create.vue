<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


const props = defineProps({
    tipeBarangs: Array,
});

const form = useForm({
    nama: '',
    deskripsi: '',
    harga_beli: '',
    harga_jual: '',
    jumlah: '',
    tipe_barang_id: '',
});

function submitForm() {
    form.post(route('barang.store'), { 
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
    <Head title="Add Barang" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add Barang
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
                <form @submit.prevent="submitForm" class="grid gap-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input
                            id="nama"
                            v-model="form.nama"
                            type="text"
                            placeholder="Nama Barang"
                            class="border rounded px-4 py-2 w-full"
                            required
                        />
                    </div>
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea
                            id="deskripsi"
                            v-model="form.deskripsi"
                            placeholder="Deskripsi Barang"
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
                            placeholder="Harga Beli"
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
                            placeholder="Harga Jual"
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
                            placeholder="Jumlah Barang"
                            class="border rounded px-4 py-2 w-full"
                            required
                        />
                    </div>
                    <div>
                        <label for="tipe_barang_id" class="block text-sm font-medium text-gray-700">Tipe Barang</label>
                        <select
                            id="tipe_barang_id"
                            v-model.number="form.tipe_barang_id"
                            class="border rounded px-4 py-2 w-full"
                            required
                        >
                            <option value="" disabled selected>Pilih Tipe Barang</option>
                            <option
                                v-for="tipe in props.tipeBarangs"
                                :key="tipe.id"
                                :value="tipe.id"
                            >
                                {{ tipe.nama }}
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-between items-center">
                        <Link :href="route('barang')" class="text-gray-600 hover:underline">Kembali</Link>
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
