<template>
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold">{{ $t('supplier.title') }}</h2>

      <router-link to="/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        {{ $t('supplier.add_new') }}
      </router-link>
    </div>

    <input
      v-model="search"
      :placeholder="$t('supplier.search_placeholder')"
      class="w-full border px-3 py-2 rounded mb-4 shadow-sm"
    />

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm border rounded-lg">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="p-3">{{ $t('supplier.company') }}</th>
            <th class="p-3">{{ $t('supplier.cnpj') }}</th>
            <th class="p-3">{{ $t('supplier.city') }}</th>
            <th class="p-3">{{ $t('supplier.state') }}</th>
            <th class="p-3">{{ $t('supplier.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="s in suppliers"
            :key="s.id"
            class="border-t hover:bg-gray-50 transition"
          >
            <td class="p-3">{{ s.company_name }}</td>
            <td class="p-3">{{ s.document_number }}</td>
            <td class="p-3">{{ s.city }}</td>
            <td class="p-3">{{ s.state }}</td>
            <td class="p-3 space-x-2">
              <router-link :to="`/edit/${s.id}`" class="text-blue-600 hover:underline">
                {{ $t('supplier.edit') }}
              </router-link>
              <button @click="removeSupplier(s.id)" class="text-red-600 hover:underline">
                {{ $t('supplier.delete') }}
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Paginação -->
      <div v-if="lastPage > 1" class="flex justify-center mt-4 space-x-2">
        <button
          class="px-3 py-1 border rounded"
          :disabled="currentPage === 1"
          @click="goToPage(currentPage - 1)"
        >
          ‹ {{ $t('pagination.previous') || 'Anterior' }}
        </button>

        <button
          v-for="page in lastPage"
          :key="page"
          class="px-3 py-1 border rounded"
          :class="{ 'bg-blue-600 text-white': page === currentPage }"
          @click="goToPage(page)"
        >
          {{ page }}
        </button>

        <button
          class="px-3 py-1 border rounded"
          :disabled="currentPage === lastPage"
          @click="goToPage(currentPage + 1)"
        >
          {{ $t('pagination.next') || 'Próxima' }} ›
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import supplierApi from '../api/supplier'

const suppliers = ref([])
const search = ref('')
const currentPage = ref(1)
const lastPage = ref(1)
const debounceTimer = ref(null)

async function loadSuppliers() {
  try {
    const { data } = await supplierApi.getAll({
      search: search.value,
      page: currentPage.value
    })

    suppliers.value = data.data
    lastPage.value = data.meta?.last_page || 1
  } catch (e) {
    console.error('Erro ao carregar fornecedores:', e)
  }
}

function goToPage(page) {
  if (page >= 1 && page <= lastPage.value) {
    currentPage.value = page
    loadSuppliers()
  }
}

watch(search, (val) => {
  if (val.length >= 3 || val.length === 0) {
    clearTimeout(debounceTimer.value)
    debounceTimer.value = setTimeout(() => {
      currentPage.value = 1
      loadSuppliers()
    }, 500)
  }
})

async function removeSupplier(id) {
  if (!confirm('Tem certeza que deseja excluir este fornecedor?')) return

  try {
    await supplierApi.remove(id)
    suppliers.value = suppliers.value.filter(s => s.id !== id)
  } catch (error) {
    console.error('Erro ao excluir fornecedor:', error)
    alert('Erro ao excluir fornecedor.')
  }
}

onMounted(loadSuppliers)
</script>
