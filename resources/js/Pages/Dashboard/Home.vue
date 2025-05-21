<script setup>
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { onMounted, ref } from 'vue'
import { Chart, registerables } from 'chart.js'
import Cards from '@/Components/Cards.vue'

Chart.register(...registerables)

const props = defineProps({
  salesData: Array,
  totalBarang: Number,
  totalPO: Number,
  totalSO: Number,
  barangHampirHabis: Array,
  recentPO: Array,
  recentSO: Array,
  topSelling: Array
})

const chartRef = ref(null)

onMounted(() => {
  const ctx = chartRef.value.getContext('2d')
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: props.salesData.map(item => item.month),
      datasets: [{
        label: 'Total Penjualan',
        data: props.salesData.map(item => item.total),
        backgroundColor: 'rgba(255, 159, 64, 0.6)',
        borderColor: 'rgba(255, 159, 64, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })
})
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
    </template>

    <div class="py-6 px-4 space-y-6 max-w-7xl mx-auto">
      <!-- Summary Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <Cards title="Total Barang" :value="totalBarang" class="border-l-4 border-orange-500" />
        <Cards title="Total Purchase Order" :value="totalPO" class="border-l-4 border-orange-400" />
        <Cards title="Total Sales Order" :value="totalSO" class="border-l-4 border-orange-300" />
        <Cards title="Barang Hampir Habis" :value="barangHampirHabis.length" class="border-l-4 border-red-500 bg-red-50" />
      </div>

      <!-- Chart & Low Stock -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart -->
        <div class="bg-white rounded-xl shadow p-6 col-span-1 lg:col-span-2 border-l-4 border-orange-400">
          <h3 class="text-lg font-bold text-orange-600 mb-4">Grafik Penjualan per Bulan</h3>
          <div class="h-64">
            <canvas ref="chartRef" class="w-full h-full"></canvas>
          </div>
        </div>

        <!-- Low Stock -->
        <div class="bg-red-50 rounded-xl shadow p-6 border-l-4 border-red-500">
          <h3 class="text-lg font-bold text-red-600 mb-4">Barang Hampir Habis</h3>
          <table class="w-full text-sm text-left text-red-700">
            <thead class="text-red-600 bg-red-100">
              <tr>
                <th class="px-4 py-2 border-b border-red-200">Nama</th>
                <th class="px-4 py-2 border-b border-red-200">Stok</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in barangHampirHabis" :key="item.id" class="hover:bg-red-100 transition-colors">
                <td class="px-4 py-2 border-b border-gray-200">{{ item.nama }}</td>
                <td class="px-4 py-2 border-b border-gray-200">{{ item.jumlah }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Recent PO, SO & Top Selling -->
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        <!-- Recent PO -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-orange-300">
          <h3 class="text-lg font-bold text-gray-700 mb-4">Purchase Order Terbaru</h3>
          <ul class="divide-y divide-gray-200 text-sm text-gray-700">
            <li v-for="po in recentPO" :key="po.id" class="py-2">
              <strong class="text-orange-600">PO #{{ po.po_id }}</strong> - {{ po.supplier }}<br>
              <span class="text-xs text-gray-500">{{ po.status }}</span>
            </li>
          </ul>
        </div>

        <!-- Recent SO -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-orange-400">
          <h3 class="text-lg font-bold text-gray-700 mb-4">Sales Order Terbaru</h3>
          <ul class="divide-y divide-gray-200 text-sm text-gray-700">
            <li v-for="so in recentSO" :key="so.id" class="py-2">
              <strong class="text-orange-600">SO #{{ so.so_id }}</strong> - {{ so.customer }}<br>
              <span class="text-xs text-gray-500">{{ so.status }}</span>
            </li>
          </ul>
        </div>

        <!-- Top Selling Items -->
        <div class="bg-orange-50 rounded-xl shadow p-6 border-l-4 border-orange-500">
          <h3 class="text-lg font-bold text-orange-600 mb-4">Top Selling Item</h3>
          <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-orange-100 text-orange-700">
              <tr>
                <th class="px-4 py-2 border-b border-orange-200">Nama Barang</th>
                <th class="px-4 py-2 border-b border-orange-200">Total Terjual</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in topSelling" :key="item.nama" class="hover:bg-orange-100 transition-colors duration-150">
                <td class="px-4 py-2 border-b border-gray-200">{{ item.nama }}</td>
                <td class="px-4 py-2 border-b border-gray-200">{{ item.total_terjual }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
