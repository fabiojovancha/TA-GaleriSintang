<script setup>
import NavBar from '@/Components/NavBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    purchaseOrderDetail: Array
})

// function deletePurchase(id) {
//     if (confirm('Yakin ingin menghapus Purchase Order ini?')) {
//         router.delete(route('purchase-order.destroy', id), {
//             onSuccess: () => {
//                 alert('Purchase Order berhasil dihapus.');
//             },
//             onError: () => {
//                 alert('Gagal menghapus Purchase Order.');
//             }
//         })
//     }
// }
</script>

<template>
    <Head title="Purchase Order" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Purchase Order
                </h2>
                <Link :href="route('purchase-order-detail.create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Add Purchase Order
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
                                    <th class="py-2 px-4 text-left border">Tanggal</th>
                                    <th class="py-2 px-4 text-left border">Total Harga</th>
                                    <th class="py-2 px-4 text-left border">Tipe Pembayaran</th>
                                    <th class="py-2 px-4 text-left border">Supplier</th>
                                    <th class="py-2 px-4 text-left border">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in purchaseOrder" :key="item.id">
                                    <td class="py-2 px-4 border">{{ item.id }}</td>
                                    <td class="py-2 px-4 border">{{ item.tanggal }}</td>
                                    <td class="py-2 px-4 border">Rp {{ item.totalHarga}}</td>
                                    <td class="py-2 px-4 border">{{ item.pembayaran ? item.pembayaran.tipe : 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ item.supplier ? item.supplier.nama : 'N/A' }}</td>
                                    <td class="py-2 px-4 border">
                                        <div class="flex gap-2">
                                            <PrimaryButton>
                                                Detail
                                            </PrimaryButton>
                                        </div>
                                        <div class="flex gap-2">
                                            <DangerButton @click="deletePurchase(item.id)">
                                                Delete
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="purchaseOrder.length === 0">
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
