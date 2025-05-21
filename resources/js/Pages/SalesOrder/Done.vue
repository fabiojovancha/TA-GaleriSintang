<script setup>
import NavBar from '@/Components/NavBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    salesOrder: Array
})


function goToDetail(id) {
    router.get(route('sales-order.show', id));
}

const sortedSalesOrder = props.salesOrder.slice().sort((a, b) => {
    return new Date(b.tanggal) - new Date(a.tanggal);
});

function updateStatusToCompleted(id) {
    if (confirm('Apakah Anda yakin ingin mengubah status menjadi selesai?')) {
        Inertia.put(route('purchase-order.update-status', id));
    }
}
</script>


<template>
    <Head title="Sales Order" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Sales Order Selesai
                </h2>
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
                                    <th class="py-2 px-4 text-left border">Customer</th>
                                    <th class="py-2 px-4 text-left border">Status</th>
                                    <th class="py-2 px-4 text-left border">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in sortedSalesOrder" :key="item.id">
                                    <td class="py-2 px-4 border">{{ item.id }}</td>
                                    <td class="py-2 px-4 border">{{ item.tanggal }}</td>
                                    <td class="py-2 px-4 border">Rp. {{ (item.totalHarga).toLocaleString('id-ID')}}</td>
                                    <td class="py-2 px-4 border">{{ item.pembayaran ? item.pembayaran.tipePembayaran : 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ item.customer ? item.customer.nama : 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ item.status }}</td>
                                    <td class="py-2 px-4 border">
                                        <div class="flex gap-2">
                                            <PrimaryButton @click="goToDetail(item.id)">
                                                <font-awesome-icon icon="eye"/>
                                            </PrimaryButton>
                                            <a :href="route('purchase-order.pdf', item.id)" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                                <font-awesome-icon icon="file-pdf" />
                                            </a>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <tr v-if="salesOrder.length === 0">
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
