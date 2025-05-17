<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import NavBar from '@/Components/NavBar.vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  salesOrder: Object,
  barang: Array,
});

const form = useForm({
  items: [
    {
      barang_id: null,
      jumlah: 1,
      harga_jual: 0,
    },
  ],
});

const addItem = () => {
  form.items.push({
    barang_id: null,
    jumlah: 1,
    harga_jual: 0,
  });
};

const removeItem = (index) => {
  form.items.splice(index, 1);
};

const updateHargaBarang = (index) => {
  const selected = props.barang.find(b => b.id === form.items[index].barang_id);
  form.items[index].harga_jual = selected ? selected.harga_jual : 0;
};

const submitForm = () => {
  form.post(route('sales-order-detail.store-multiple', props.salesOrder.id), {
    onSuccess: () => {
      alert('Semua detail sales order berhasil ditambahkan');
    },
    onError: (error) => {
      console.error(error);
    },
  });
};
</script>

<template>
    <div>
      <Head title="Tambah Detail sales Order" />
      <AuthenticatedLayout>
        <template #header>
          <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
              Tambah Detail sales Order
            </h2>
          </div>
        </template>
  
        <div class="py-12">
          <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                <form @submit.prevent="submitForm">
                  <div class="space-y-6">
                    <div v-for="(item, index) in form.items" :key="index" class="border-b pb-4 mb-4">
                      <div class="space-y-2">
                        <label class="text-lg">Pilih Barang</label>
                        <select v-model="item.barang_id" class="w-full p-2 border rounded" @change="updateHargaBarang(index)" required>
                          <option v-for="barangItem in barang" :key="barangItem.id" :value="barangItem.id">
                            {{ barangItem.nama }}
                          </option>
                        </select>
  
                        <label class="text-lg">Jumlah</label>
                        <input
                          type="number"
                          v-model="item.jumlah"
                          min="1"
                          class="w-full p-2 border rounded"
                          required
                        />
  
                        <label class="text-lg">Harga Barang</label>
                        <input
                          type="number"
                          :value="item.harga_jual"
                          class="w-full p-2 border rounded bg-gray-100"
                          readonly
                        />
  
                        <button type="button" @click="removeItem(index)" class="mt-2 text-red-500 hover:underline">
                          Hapus Barang Ini
                        </button>
                      </div>
                    </div>
  
                    <button type="button" @click="addItem" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                      Tambah Barang
                    </button>
  
                    <div class="mt-6">
                      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Submit Semua Barang
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </AuthenticatedLayout>
    </div>
  </template>
  
 