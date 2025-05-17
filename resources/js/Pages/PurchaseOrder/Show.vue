<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
  purchaseOrder: Object
});
</script>

<template>
  <Head title="Detail Purchase Order" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Detail Purchase Order - {{ purchaseOrder.id }}
        </h2>
        <Link
        v-if="purchaseOrder.status !== 'Selesai'"
        :href="route('purchase-order-detail.create', purchaseOrder.id)"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        Add Purchase Order Detail
      </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="space-y-4">
              <!-- Data Purchase Order -->
              <div class="flex items-center gap-4">
                <strong class="text-lg">ID:</strong>
                <span>{{ purchaseOrder.id }}</span>
              </div>
              <div class="flex items-center gap-4">
                <strong class="text-lg">Tanggal:</strong>
                <span>{{ purchaseOrder.tanggal }}</span>
              </div>
              <div class="flex items-center gap-4">
                <strong class="text-lg">Total Harga:</strong>
                <span>Rp {{ purchaseOrder.totalHarga.toLocaleString('id-ID') }}</span>
              </div>
              <div class="flex items-center gap-4">
                <strong class="text-lg">Tipe Pembayaran:</strong>
                <span>{{ purchaseOrder.pembayaran ? purchaseOrder.pembayaran.tipePembayaran : 'N/A' }}</span>
              </div>
              <div class="flex items-center gap-4">
                <strong class="text-lg">Supplier:</strong>
                <span>{{ purchaseOrder.supplier ? purchaseOrder.supplier.nama : 'N/A' }}</span>
              </div>
            </div>

            <div class="mt-8">
              <h3 class="text-xl font-semibold">Detail Purchase Order</h3>
              <table class="w-full mt-4 bg-white border border-gray-200 shadow">
                <thead>
                  <tr>
                    <th class="py-2 px-4 text-left border">ID Detail</th>
                    <th class="py-2 px-4 text-left border">Nama Barang</th>
                    <th class="py-2 px-4 text-left border">Jumlah</th>
                    <th class="py-2 px-4 text-left border">Harga Satuan</th>
                    <th class="py-2 px-4 text-left border">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="detail in purchaseOrder.details" :key="detail.id">
                    <td class="py-2 px-4 border">{{ detail.id }}</td>
                    <td class="py-2 px-4 border">{{ detail.barang ? detail.barang.nama : 'N/A' }}</td>
                    <td class="py-2 px-4 border">{{ detail.jumlah }}</td>
                    <td class="py-2 px-4 border">Rp. {{ (detail.barang.harga_beli).toLocaleString('id-ID') }}</td>
                    <td class="py-2 px-4 border">Rp. {{ (detail.barang.harga_beli * detail.jumlah).toLocaleString('id-ID') }}</td>
                  </tr>
                  <tr v-if="purchaseOrder.details.length === 0">
                    <td colspan="5" class="py-2 px-4 text-center border">Tidak ada detail untuk purchase order ini.</td>
                    
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="mt-6">
              <Link :href="route('purchase-order')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Kembali ke Daftar Purchase Order
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
