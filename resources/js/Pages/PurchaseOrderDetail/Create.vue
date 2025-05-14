<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  purchaseOrder: Object,
  barang: Array,
});

const form = useForm({
  purchase_order_id: '',
  barang_id: '',
  jumlah: '',
  harga: '',
});

watch(
  () => props.purchaseOrder,
  (newVal) => {
    if (newVal && newVal.id) {
      form.purchase_order_id = newVal.id;
    }
  },
  { immediate: true } // supaya langsung jalan kalau sudah ada saat mounted
);

const addDetail = () => {
  form.post(route('purchase-order-detail.store'), {
    onSuccess: () => {
      alert('Detail berhasil ditambahkan');
      // Reset form kalau mau
      form.barang_id = '';
      form.jumlah = '';
      form.harga = '';
    },
  });
};
</script>


<template>
<AuthenticatedLayout>
  <div>
    <h2 class="text-xl font-semibold leading-tight">Detail Purchase Order - {{ props.purchaseOrder.id }}</h2>

    <form @submit.prevent="addDetail">
      <div>
        <label for="barang_id">Barang</label>
        <select v-model="form.barang_id" required>
          <option v-for="barang in props.barang" :key="barang.id" :value="barang.id">
            {{ barang.name }} (Rp {{ barang.harga }})
          </option>
        </select>
      </div>
      <div>
        <label for="jumlah">Jumlah</label>
        <input type="number" v-model="form.jumlah" required min="1" />
      </div>
      <div>
        <label for="harga">Harga</label>
        <input type="number" v-model="form.harga" required />
      </div>
      <button type="submit">Add Detail</button>
    </form>

    <h3 class="mt-4">Daftar Purchase Order Detail</h3>
    <ul>
      <li v-for="detail in props.purchaseOrder.details" :key="detail.id">
        Barang: {{ detail.barang.name }}, Jumlah: {{ detail.jumlah }}, Harga: Rp {{ detail.harga }}
      </li>
    </ul>
  </div>
</AuthenticatedLayout>
</template>
