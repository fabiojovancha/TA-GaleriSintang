<script setup>
import { ref, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed } from 'vue';

const props = defineProps({
    pembayaran: Array,
    customer: Array,
    barang: Array
});

const form = ref({
    tanggal: '',
    status: 'Process',
    pembayaran_id: null,
    customer_id: null,
    details: [
        {
            barang_id: null,
            jumlah: 1,
            harga_jual: 0
        }
    ]
});

onMounted(() => {
    form.value.tanggal = new Date().toISOString().split('T')[0];
});

const addItem = () => {
    form.value.details.push({
        barang_id: null,
        jumlah: 1,
        harga_jual: 0
    });
};

const checkStock = (index) => {
    const selected = props.barang.find(b => b.id === form.value.details[index].barang_id);
    if (selected && form.value.details[index].jumlah > selected.jumlah) {
        alert('Jumlah melebihi stok yang tersedia!');
        form.value.details[index].jumlah = selected.jumlah;  // Reset to max available stock
    }
};

const removeItem = (index) => {
    form.value.details.splice(index, 1);
};

const updateHargaBarang = (index) => {
    const selected = props.barang.find(b => b.id === form.value.details[index].barang_id);
    form.value.details[index].harga_jual = selected ? selected.harga_jual : 0;
};

const totalHarga = computed(() => {
    return form.value.details.reduce((total, item) => {
        return total + (item.jumlah * item.harga_jual);
    }, 0);
});

const submitForm = () => {
    form.value.totalHarga = totalHarga.value;
    router.post(route('sales-order.store'), form.value, {
        onSuccess: () => {
            router.push(route('sales-order'));
            alert('Sales Order & Detail berhasil disimpan.');
        },
        onError: (error) => {
            console.error(error);
            alert('Gagal menyimpan.');
        },
    });
};
</script>

<template>
    <Head title="Create Purchase Order" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create Sales Order</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <form @submit.prevent="submitForm">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium">Tanggal</label>
                                <input type="date" v-model="form.tanggal" class="w-full p-2 border rounded" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Tipe Pembayaran</label>
                                <select v-model="form.pembayaran_id" class="w-full p-2 border rounded" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option v-for="item in props.pembayaran" :value="item.id" :key="item.id">
                                        {{ item.tipePembayaran }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium">customer</label>
                                <select v-model="form.customer_id" class="w-full p-2 border rounded" required>
                                    <option value="" disabled selected>Pilih</option>
                                    <option v-for="s in props.customer" :value="s.id" :key="s.id">
                                        {{ s.nama }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-2">Detail Barang</h3>
                            <div v-for="(item, index) in form.details" :key="index" class="border-b py-4 mb-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 details-end">
                                    <div>
                                        <label class="text-sm">Barang</label>
                                        <select v-model="item.barang_id" @change="updateHargaBarang(index)" class="w-full p-2 border rounded" required>
                                            <option value="" disabled selected>Pilih Barang</option>
                                            <option v-for="b in props.barang" :value="b.id" :key="b.id">
                                                {{ b.nama }}
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-sm">Jumlah</label>
                                        <input type="number" v-model="item.jumlah" min="1" @change="checkStock(index)" class="w-full p-2 border rounded" required />
                                    </div>
                                    <div>
                                        <label class="text-sm">Harga Beli</label>
                                        <input type="number" :value="item.harga_jual" readonly class="w-full p-2 border rounded bg-gray-100" />
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" @click="removeItem(index)" class="text-red-500 text-sm">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" @click="addItem" class="text-sm text-green-600">+ Tambah Barang</button>
                        </div>
                        <div class="mt-4 text-right text-lg font-bold">
                            Total Harga: Rp {{ totalHarga.toLocaleString() }}
                        </div>
                        <div class="mt-6">
                            <PrimaryButton type="submit">Simpan Purchase Order</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
