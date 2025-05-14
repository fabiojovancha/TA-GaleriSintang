<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, Link, router} from '@inertiajs/vue3';


defineProps({
    pembayaran: Array
})


</script>

<template>
    <Head title="Page Tipe" />
    <NavBar>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Tipe Pembayaran
                </h2>
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
                                    <th class="py-2 px-4 text-left border">Tipe pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in pembayaran" :key="item.id">
                                    <td class="py-2 px-4 border">{{ item.id }}</td>
                                    <td class="py-2 px-4 border">{{ item.tipePembayaran }}</td>        
                                </tr>
                                <tr v-if="pembayaran.length === 0">
                                    <td colspan="6" class="py-2 px-4 text-center border">Tidak ada data.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </NavBar>
</template>

