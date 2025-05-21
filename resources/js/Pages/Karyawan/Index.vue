<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
  karyawan: Array,
})

function hapus(id) {
  if (confirm('Yakin ingin menghapus karyawan ini?')) {
    router.delete(route('karyawan.destroy', id), {
      onSuccess: () => {
        alert('Karyawan berhasil dihapus')
      },
    })
  }
}
</script>

<template>
  <Head title="List Karyawan" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          List Karyawan
        </h2>
        <Link
          v-if="$page.props.auth.user.role === 'owner'"
          :href="route('register')"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Add Karyawan
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
                  <th class="py-2 px-4 text-left border">Email</th>
                  <th class="py-2 px-4 text-left border">Role</th>
                  <th class="py-2 px-4 text-left border">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in karyawan" :key="item.id">
                  <td class="py-2 px-4 border">{{ item.id }}</td>
                  <td class="py-2 px-4 border">{{ item.name }}</td>
                  <td class="py-2 px-4 border">{{ item.email }}</td>
                  <td class="py-2 px-4 border">{{ item.role }}</td>
                  <td class="py-2 px-4 border text-center">
                    <button
                
                      @click="hapus(item.id)"
                      class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded"
                    >
                        <font-awesome-icon icon="trash" class="cursor-pointer" />
                    </button>
                  </td>
                </tr>
                <tr v-if="karyawan.length === 0">
                  <td colspan="5" class="py-2 px-4 text-center border">
                    Tidak ada data.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
