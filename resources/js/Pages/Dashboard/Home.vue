<script setup>
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { onMounted, ref } from 'vue'
import { Chart, registerables } from 'chart.js'

Chart.register(...registerables)

const props = defineProps({
  salesData: Array
})

const chartRef = ref(null)

onMounted(() => {
  const ctx = chartRef.value.getContext('2d')

  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: props.salesData.map(item => item.month),
      datasets: [{
        label: 'Total Penjualan',
        data: props.salesData.map(item => item.total),
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
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
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <canvas ref="chartRef"></canvas>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
