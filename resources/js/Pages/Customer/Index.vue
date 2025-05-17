<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, Link, router} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    customer: Array
})

function editCustomer(item) {
    router.get(route('customer.edit', item.id))
}

function deleteCustomer(id) {
    if (confirm('Yakin ingin menghapus customer ini?')) {
        router.delete(route('customer.destroy', id), {
            onSuccess: () => {
                alert('customer berhasil dihapus.');
            },
            onError: () => {
                alert('Gagal menghapus customer.');
            }
        })
    }
}
</script>

<template>
    <Head title="Page customer" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Customer
                </h2>
                <Link :href="route('customer.create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Add customer
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
                                <tr v-for="item in customer" :key="item.id">
                                    <td class="py-2 px-4 border">{{ item.id }}</td>
                                    <td class="py-2 px-4 border">{{ item.nama }}</td>
                                    <td class="py-2 px-4 border">{{ item.alamat }}</td>
                                    <td class="py-2 px-4 border">{{ item.noTelp }}</td>
                                    <td class="py-2 px-4 border">
                                        <div class="flex gap-2">
                                            <PrimaryButton @click="editCustomer(item)">
                                                Edit
                                            </PrimaryButton>
                                            <DangerButton @click="deleteCustomer(item.id)">
                                                Delete
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="customer.length === 0">
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

