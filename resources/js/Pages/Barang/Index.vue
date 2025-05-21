<script setup>
import { onMounted } from 'vue';
import { router, Link, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-bs5';

defineProps({
  barang: Array
});

function editBarang(id) {
  router.get(route('barang.edit', id));
}

function deleteBarang(id) {
  if (confirm('Yakin ingin menghapus barang ini?')) {
    router.delete(route('barang.destroy', id), {
      onSuccess: () => alert('Barang berhasil dihapus.'),
      onError: () => alert('Gagal menghapus barang.')
    });
  }
}



const canvasStore = useCanvasStore();
import { useCanvasStore } from '@/Stores/canvasStore';

onMounted(() => {
    window.Echo.channel('barang-channel')
        .listen('StokBarangMenipis', (event) => {
            console.log('Pop-up muncul, event diterima:', event);
            canvasStore.show({
                nama: event.nama,
                jumlah: event.jumlah,
                jumlah_beli: event.jumlah_beli
            });
        });
    
    $('#barangTable').DataTable({
    paging: true,
    searching: true,
    info: true,
    responsive: true,
    });
});

</script>


<template>
  <Head title="Page Barang" />
  <AuthenticatedLayout>
    <template #header>
      <div class="d-flex justify-content-between align-items-center">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Barang</h2>
        <Link :href="route('barang.create')" class="btn btn-primary">Add Barang</Link>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <table id="barangTable" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Deskripsi</th>
                  <th>Harga Beli</th>
                  <th>Harga Jual</th>
                  <th>Jumlah</th>
                  <th>Tipe</th>
                  <th>Waktu Pengiriman</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="b in barang" :key="b.id">
                  <td>{{ b.id }}</td>
                  <td>{{ b.nama }}</td>
                  <td>{{ b.deskripsi }}</td>
                  <td>{{ `Rp ${Number(b.harga_beli).toLocaleString('id-ID')}` }}</td>
                  <td>{{ `Rp ${Number(b.harga_jual).toLocaleString('id-ID')}` }}</td>
                  <td>{{ b.jumlah }}</td>
                  <td>{{ b.tipeBarang ? b.tipeBarang.nama : 'Tipe tidak ditemukan' }}</td>
                  <td>{{ b.lead_time }}</td>
                  <td>
                    <span v-if="b.butuh_beli" class="text-danger font-weight-bold">
                      Perlu dibeli ({{ b.jumlah_beli }} pcs)
                    </span>
                    <span v-else class="text-success">Stok aman</span>
                  </td>
                  <td>
                    <PrimaryButton @click="editBarang(b)">
                        <font-awesome-icon icon="pen" class="cursor-pointer" />
                    </PrimaryButton>
                    <DangerButton @click="deleteBarang(b.id)">
                        <font-awesome-icon icon="trash" class="cursor-pointer" />
                    </DangerButton>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

  <!-- Real-time Canvas Notification -->
  <div v-show="canvasStore.showCanvas" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="w-full max-w-md bg-white shadow-lg p-6 overflow-y-auto max-h-[80vh]">
      <h2 class="text-xl font-semibold mb-4 text-gray-800">⚠️ Stok Barang Menipis</h2>
      <div v-if="canvasStore.canvasData.length > 0">
        <ul class="space-y-4">
          <li v-for="(item, index) in canvasStore.canvasData" :key="index" class="border-b pb-2">
            <p><strong>Nama:</strong> {{ item.nama }}</p>
            <p><strong>Jumlah Sekarang:</strong> {{ item.jumlah }}</p>
            <p><strong>Jumlah yang Harus Dibeli:</strong> {{ item.jumlah_beli }}</p>
          </li>
        </ul>
      </div>
      <div class="mt-4 flex justify-end gap-2">
        <button @click="canvasStore.hide()" class="btn btn-secondary">
          Tutup
        </button>
      </div>
    </div>
  </div>
</template>
