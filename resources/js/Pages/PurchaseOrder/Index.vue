<script setup>
import NavBar from '@/Components/NavBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Inertia } from '@inertiajs/inertia';
import { computed } from 'vue';
import { onMounted } from 'vue';


import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-bs5';


const props = defineProps({
    purchaseOrder: Array
})


function goToDetail(id) {
    router.get(route('purchase-order.show', id));
}

const sortedPurchaseOrder = computed(() => {
    return props.purchaseOrder.slice().sort((a, b) => {
        return new Date(b.tanggal) - new Date(a.tanggal);
    });
});

function updateStatusToCompleted(id) {
    if (confirm('Apakah Anda yakin ingin mengubah status menjadi selesai?')) {
        Inertia.put(route('purchase-order.update-status', id));
    }
}

onMounted(() => {
    $('#purchaseTable').DataTable({
    paging: true,
    searching: true,
    info: true,
    responsive: true,
    });
});

function formatDate(dateString) {
  if (!dateString) return '';
  const date = new Date(dateString);
  const bulanIndo = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ];
  const tanggal = date.getDate();
  const bulan = bulanIndo[date.getMonth()];
  const tahun = date.getFullYear();
  return `${tanggal} ${bulan} ${tahun}`;
}

</script>


<template>
    <Head title="Purchase Order" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Purchase Order
                </h2>
                <Link :href="route('purchase-order.create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Add Purchase Order
                </Link>
            </div>
        </template>
        
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table id="purchaseTable" class="w-full bg-white border border-gray-200 shadow">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 text-left border">ID</th>
                                    <th class="py-2 px-4 text-left border">Tanggal</th>
                                    <th class="py-2 px-4 text-left border">Total Harga</th>
                                    <th class="py-2 px-4 text-left border">Tipe Pembayaran</th>
                                    <th class="py-2 px-4 text-left border">Supplier</th>
                                    <th class="py-2 px-4 text-left border">Status</th>
                                    <th class="py-2 px-4 text-left border">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in sortedPurchaseOrder" :key="item.id">
                                    <td class="py-2 px-4 border">{{ item.po_id }}</td>
                                    <td class="py-2 px-4 border">{{ formatDate(item.tanggal) }}</td>
                                    <td class="py-2 px-4 border">Rp. {{ (item.totalHarga).toLocaleString('id-ID')}}</td>
                                    <td class="py-2 px-4 border">{{ item.pembayaran ? item.pembayaran.tipePembayaran : 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ item.supplier ? item.supplier.nama : 'N/A' }}</td>
                                    <td class="py-2 px-4 border">{{ item.status }}</td>
                                    <td class="py-2 px-4 border">
                                        <div class="flex gap-2">
                                            <PrimaryButton @click="goToDetail(item.id)">
                                                <font-awesome-icon icon="eye"/>
                                            </PrimaryButton>
                                            <a :href="route('purchase-order.pdf', item.id)" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                                <font-awesome-icon icon="file-pdf" />
                                            </a>
                                            <DangerButton v-if="item.status === 'Process'" @click="updateStatusToCompleted(item.id)">
                                                <font-awesome-icon icon="check" />
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
