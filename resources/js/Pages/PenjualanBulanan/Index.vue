<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    salesOrder: Array
});

const selectedMonth = ref(null);

function goToDetailMonth(month) {
    selectedMonth.value = month;
}

function closeDetail() {
    selectedMonth.value = null;
}

const monthlySales = computed(() => {
    const result = {};
    props.salesOrder.forEach(order => {
        const date = new Date(order.tanggal);
        const monthKey = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`; // e.g. "2025-04"

        if (!result[monthKey]) {
            result[monthKey] = 0;
        }
        result[monthKey] += order.totalHarga;
    });

    return Object.entries(result).map(([month, total]) => ({
        month,
        total
    }));
});

const salesOrderBySelectedMonth = computed(() => {
    if (!selectedMonth.value) return [];
    return props.salesOrder.filter(order => {
        const date = new Date(order.tanggal);
        const monthYear = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`; // Format YYYY-MM
        return monthYear === selectedMonth.value;
    });
});
</script>

<template>
    <Head title="Sales Order" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Penjualan Bulanan
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
                <!-- Total Penjualan per Bulan -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Total Penjualan per Bulan</h3>
                        <table class="w-full bg-white border border-gray-300 shadow">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border text-left">Bulan</th>
                                    <th class="py-2 px-4 border text-left">Total Penjualan</th>
                                    <th class="py-2 px-4 border text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in monthlySales" :key="item.month">
                                    <td class="py-2 px-4 border">{{ item.month }}</td>
                                    <td class="py-2 px-4 border">Rp. {{ item.total.toLocaleString('id-ID') }}</td>
                                    <td class="py-2 px-4 border">
                                    <div class="flex gap-2">
                                        <PrimaryButton @click="goToDetailMonth(item.month)">
                                            Detail
                                        </PrimaryButton>
                                        <a
                                            :href="route('sales-order.monthly-pdf', encodeURIComponent(item.month))"
                                            target="_blank"
                                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                                        >
                                            <font-awesome-icon icon="file-pdf" />
                                        </a>
                                    </div>
                                    </td>
                                </tr>
                                <tr v-if="monthlySales.length === 0">
                                    <td colspan="3" class="py-2 px-4 text-center border">Tidak ada data.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-if="selectedMonth" class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Detail Penjualan Bulan {{ selectedMonth }}</h3>
                            <button @click="closeDetail" class="text-red-500 underline">Tutup</button>
                        </div>

                        <table class="w-full bg-white border border-gray-300 shadow">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border text-left">ID</th>
                                    <th class="py-2 px-4 border text-left">Tanggal</th>
                                    <th class="py-2 px-4 border text-left">Total Harga</th>
                                    <th class="py-2 px-4 border text-left">Tipe Pembayaran</th>
                                    <th class="py-2 px-4 border text-left">Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in salesOrderBySelectedMonth" :key="item.id">
                                    <td class="py-2 px-4 border">{{ item.id }}</td>
                                    <td class="py-2 px-4 border">{{ item.tanggal }}</td>
                                    <td class="py-2 px-4 border">Rp. {{ item.totalHarga.toLocaleString('id-ID') }}</td>
                                    <td class="py-2 px-4 border">
                                        {{ item.pembayaran ? item.pembayaran.tipePembayaran : 'N/A' }}
                                    </td>
                                    <td class="py-2 px-4 border">
                                        {{ item.customer ? item.customer.nama : 'N/A' }}
                                    </td>
                                </tr>
                                <tr v-if="salesOrderBySelectedMonth.length === 0">
                                    <td colspan="6" class="py-2 px-4 text-center border">Tidak ada data pada bulan ini.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
