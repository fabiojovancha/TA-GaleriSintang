<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, Link, router} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    supplier: Array
})

function editSupplier(item) {
    router.get(route('supplier.edit', item.id))
}

function deleteSupplier(id) {
    if (confirm('Yakin ingin menghapus supplier ini?')) {
        router.delete(route('supplier.destroy', id), {
            onSuccess: () => {
                alert('Supplier berhasil dihapus.');
            },
            onError: () => {
                alert('Gagal menghapus Supplier.');
            }
        })
    }
}
</script>

<template>
    <Head title="Page Supplier" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Supplier
                </h2>
                <Link :href="route('supplier.create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Add Supplier
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
                                    <th class="py-2 px-4 text-left border">Alamat</th>
                                    <th class="py-2 px-4 text-left border">No Telpon</th>
                                    <th class="py-2 px-4 text-left border">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in supplier" :key="item.id">
                                    <td class="py-2 px-4 border">{{ item.id }}</td>
                                    <td class="py-2 px-4 border">{{ item.nama }}</td>
                                    <td class="py-2 px-4 border">{{ item.alamat }}</td>
                                    <td class="py-2 px-4 border">{{ item.noTelp }}</td>
                                    <td class="py-2 px-4 border">
                                        <div class="flex gap-2">
                                            <PrimaryButton @click="editSupplier(item)">
                                                Edit
                                            </PrimaryButton>
                                            <DangerButton @click="deleteSupplier(item.id)">
                                                Delete
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="supplier.length === 0">
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

