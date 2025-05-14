<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, Link, router} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    tipeBarang: Array
})

function editTipeBarang(item) {
    router.get(route('tipeBarang.edit', item.id))
}

function deleteTipeBarang(id) {
    if (confirm('Yakin ingin menghapus tipeBarang ini?')) {
        router.delete(route('tipeBarang.destroy', id), {
            onSuccess: () => {
                alert('tipeBarang berhasil dihapus.');
            },
            onError: () => {
                alert('Gagal menghapus tipeBarang.');
            }
        })
    }
}
</script>

<template>
    <Head title="Page tipeBarang" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Tipe Barang
                </h2>
                <Link :href="route('tipeBarang.create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Add Tipe Barang
                </Link>
            </div>
        </template>
        
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="w-full bg-white border border-gray-200 shadow">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 text-left border">ID</th>
                                    <th class="py-2 px-4 text-left border">Nama</th>
                                    <th class="py-2 px-4 text-left border">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in tipeBarang" :key="item.id">
                                    <td class="py-2 px-4 border">{{ item.id }}</td>
                                    <td class="py-2 px-4 border">{{ item.nama }}</td>
                                    <td class="py-2 px-4 border">
                                        <div class="flex gap-2">
                                            <PrimaryButton @click="edittipeBarang(item)">
                                                Edit
                                            </PrimaryButton>
                                            <DangerButton @click="deletetipeBarang(item.id)">
                                                Delete
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="tipeBarang.length === 0">
                                    <td colspan="6" class="py-2 px-4 text-center border">Tidak ada data.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

