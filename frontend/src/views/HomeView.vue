<template>
  <FullScreenSpinner v-if="loading" />
  <div class="card">
    <div class="card-header">
      <h1>Fornecedores</h1>
    </div>
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Código</th>
            <th scope="col">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="supplier in suppliers" :key="supplier.id">
            <th scope="row">{{ supplier.id }}</th>
            <td>{{ supplier.name }}</td>
            <td>{{ supplier.code }}</td>
            <td>
              <button class="btn btn-sm btn-primary" @click="openDrawer(supplier)">Editar</button>
              <button class="btn btn-sm btn-danger" @click="openDeleteDrawer(supplier)">
                Apagar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <button class="btn btn-sm btn-primary" @click="newSupplier()">Novo Fornecedor</button>
    </div>
  </div>

  <DrawerEditSupplier :supplier="selectedSupplier" @save="saveEditing" @close="closeDrawer" />

  <DrawerNewSupplier @submit="createSupplier" @cancel="closeDrawer" />

  <DrawerDeleteSupplier
    :supplier="selectedSupplier"
    @delete="deleteSupplier"
    @close="closeDrawer"
  />
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import api from '@/services/api'
import type { Supplier } from '../types/Supplier.ts'
import DrawerEditSupplier from '@/components/DrawerEditSupplier.vue'
import { useOffcanvas } from '@/composables/useOffCanvas'
import DrawerNewSupplier from '@/components/DrawerNewSupplier.vue'
import DrawerDeleteSupplier from '@/components/DrawerDeleteSupplier.vue'
import FullScreenSpinner from '@/components/FullScreenSpinner.vue'

const suppliers = ref<Supplier[]>([])
const drawerOpen = ref(false)
const selectedSupplier = ref<Supplier>(suppliers.value[0])
const drawerEdit = useOffcanvas('drawerEdit')
const drawerNew = useOffcanvas('drawerNew')
const drawerDelete = useOffcanvas('drawerDelete')
const loading = ref(false)

function openDrawer(supplier: Supplier) {
  selectedSupplier.value = supplier
  drawerEdit.open()
}

function openDeleteDrawer(supplier: Supplier) {
  selectedSupplier.value = supplier
  drawerDelete.open()
}

function newSupplier() {
  drawerNew.open()
}

function closeDrawer() {
  drawerEdit.close()
  drawerNew.close()
  drawerDelete.close()
}

async function saveEditing(updatedSupplier: Supplier) {
  loading.value = true
  try {
    await api.put(`/suppliers/${updatedSupplier.id}`, updatedSupplier)
    alert('Fornecedor editado com sucesso!')
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
    drawerEdit.close()
    await fetchSuppliers()
  }
  drawerOpen.value = false
}

async function deleteSupplier(updatedSupplier: Supplier) {
  loading.value = true
  try {
    await api.delete(`/suppliers/${updatedSupplier.id}`)
    alert('Fornecedor removido com sucesso!')
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
    drawerDelete.close()
    await fetchSuppliers()
  }
  drawerOpen.value = false
}

async function createSupplier(data: { name: string; code: string }) {
  loading.value = true
  try {
    await api.post('/suppliers', data)
    alert('Fornecedor criado com sucesso!')
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
    drawerNew.close()
    await fetchSuppliers()
  }
}

async function fetchSuppliers() {
  loading.value = true
  try {
    const response = await api.get<Supplier[]>('/suppliers')
    suppliers.value = response.data
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

onMounted(fetchSuppliers)
</script>
