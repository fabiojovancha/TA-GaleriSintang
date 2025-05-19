<script setup>
import { ref } from 'vue';
import NavBar from '@/Components/NavBar.vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  salesOrder: Object
});

const salesOrder = ref(props.salesOrder);

const salesOrderDetails = ref(salesOrder.value.details);

const handleQuantityChange = (detail, newQuantity) => {
  if (newQuantity > detail.barang.jumlah) {
    alert('Jumlah tidak boleh melebihi stok barang.');
    return;
  }

  detail.jumlah = newQuantity;
};
</script>

<template>
  <Head title="Detail Purchase Order" />
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Detail Sales Order - {{ salesOrder.id }}
        </h2>
        <!-- <Link :href="route('sales-order-detail.create', salesOrder.id)" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Add Sales Order Detail
        </Link> -->
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="space-y-4">
              <!-- Data Sales Order -->
              <div class="flex items-center gap-4">
                <strong class="text-lg">ID:</strong>
                <span>{{ salesOrder.id }}</span>
              </div>
              <div class="flex items-center gap-4">
                <strong class="text-lg">Tanggal:</strong>
                <span>{{ salesOrder.tanggal }}</span>
              </div>
              <div class="flex items-center gap-4">
                <strong class="text-lg">Total Harga:</strong>
                <span>Rp {{ salesOrder.totalHarga.toLocaleString('id-ID') }}</span>
              </div>
              <div class="flex items-center gap-4">
                <strong class="text-lg">Tipe Pembayaran:</strong>
                <span>{{ salesOrder.pembayaran ? salesOrder.pembayaran.tipePembayaran : 'N/A' }}</span>
              </div>
              <div class="flex items-center gap-4">
                <strong class="text-lg">Customer:</strong>
                <span>{{ salesOrder.customer ? salesOrder.customer.nama : 'N/A' }}</span>
              </div>
            </div>

            <div class="mt-8">
              <h3 class="text-xl font-semibold">Detail Sales Order</h3>
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
                  <tr v-for="detail in salesOrderDetails" :key="detail.id">
                    <td class="py-2 px-4 border">{{ detail.id }}</td>
                    <td class="py-2 px-4 border">{{ detail.barang ? detail.barang.nama : 'N/A' }}</td>
                    <td class="py-2 px-4 border">
                      <!-- Input untuk mengubah jumlah -->
                      <input
                        v-model="detail.jumlah"
                        type="number"
                        min="1"
                        :max="detail.barang.jumlah"
                        @change="handleQuantityChange(detail, detail.jumlah)"
                        class="border px-2 py-1 rounded"
                      />
                    </td>
                    <td class="py-2 px-4 border">Rp. {{ (detail.barang.harga_jual).toLocaleString('id-ID') }}</td>
                    <td class="py-2 px-4 border">Rp. {{ (detail.barang.harga_jual * detail.jumlah).toLocaleString('id-ID') }}</td>
                  </tr>
                  <tr v-if="salesOrderDetails.length === 0">
                    <td colspan="5" class="py-2 px-4 text-center border">Tidak ada detail untuk sales order ini.</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="mt-6">
              <Link :href="route('sales-order')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Kembali ke Daftar Sales Order
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
