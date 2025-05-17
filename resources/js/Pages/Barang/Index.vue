<script setup>
import { ref, onMounted } from 'vue';
import NavBar from '@/Components/NavBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    barang: Array
});

const showCanvas = ref(false);
const canvasData = ref(null);

function editBarang(item) {
    router.get(route('barang.edit', item.id));
}

function deleteBarang(id) {
    if (confirm('Yakin ingin menghapus barang ini?')) {
        router.delete(route('barang.destroy', id), {
            onSuccess: () => {
                alert('Barang berhasil dihapus.');
            },
            onError: () => {
                alert('Gagal menghapus barang.');
            }
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
});


</script>

<template>
    <Head title="Page Barang" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Barang
                </h2>
                <Link :href="route('barang.create')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Add Barang
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="w-full bg-white border border-gray-200 shadow">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 text-left border">ID</th>
                                    <th class="py-2 px-4 text-left border">Nama</th>
                                    <th class="py-2 px-4 text-left border">Deskripsi</th>
                                    <th class="py-2 px-4 text-left border">Harga Beli</th>
                                    <th class="py-2 px-4 text-left border">Harga Jual</th>
                                    <th class="py-2 px-4 text-left border">Jumlah</th>
                                    <th class="py-2 px-4 text-left border">Tipe</th>
                                    <th class="py-2 px-4 text-left border">Status</th>
                                    <th class="py-2 px-4 text-left border">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in barang" :key="item.id">
                                    <td class="py-2 px-4 border">{{ item.id }}</td>
                                    <td class="py-2 px-4 border">{{ item.nama }}</td>
                                    <td class="py-2 px-4 border">{{ item.deskripsi }}</td>
                                    <td class="py-2 px-4 border">Rp {{ item.harga_beli.toLocaleString('id-ID') }}</td>
                                    <td class="py-2 px-4 border">Rp {{ item.harga_jual.toLocaleString('id-ID') }}</td>
                                    <td class="py-2 px-4 border">{{ item.jumlah }}</td>
                                    <td class="py-2 px-4 border">{{ item.tipeBarang ? item.tipeBarang.nama : 'Tipe tidak ditemukan' }}</td>
                                    <td class="py-2 px-4 border">
                                        <span v-if="item.butuh_beli" class="text-red-600 font-semibold">
                                            Perlu dibeli ({{ item.jumlah_beli }} pcs)
                                        </span>
                                        <span v-else class="text-green-600">
                                            Stok aman
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border">
                                        <div class="flex gap-2">
                                            <PrimaryButton @click="editBarang(item)">
                                                <font-awesome-icon icon="pen" class="cursor-pointer" />
                                            </PrimaryButton>
                                            <DangerButton @click="deleteBarang(item.id)">
                                                <font-awesome-icon icon="trash" class="cursor-pointer" />
                                            </DangerButton>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="barang.length === 0">
                                    <td colspan="9" class="py-2 px-4 text-center border">Tidak ada data.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Real-time Canvas Notification -->
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
            <button @click="canvasStore.hide()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Tutup
            </button>
            <!-- <button @click="canvasStore.clear(); canvasStore.hide()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Bersihkan Semua
            </button> -->
        </div>
    </div>
</div>
</template>
