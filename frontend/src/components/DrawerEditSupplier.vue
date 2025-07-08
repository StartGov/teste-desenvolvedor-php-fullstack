<template>
  <div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    aria-labelledby="offcanvasRightLabel"
    id="drawerEdit"
  >
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Editar Fornecedor</h5>
      <button type="button" class="btn-close" @click="emit('close')"></button>
    </div>
    <div class="offcanvas-body">
      <form @submit.prevent="emit('save', localSupplier)">
        <div class="mb-3">
          <label class="form-label">Nome</label>
          <input type="text" class="form-control" v-model="localSupplier.name" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Código</label>
          <input type="text" class="form-control" v-model="localSupplier.code" required />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="emit('close')">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, defineProps, defineEmits } from 'vue'
import type { Supplier } from '../types/Supplier'

const props = defineProps<{
  supplier: Supplier
}>()

const emit = defineEmits<{
  (e: 'close'): void
  (e: 'save', updatedUser: Supplier): void
}>()

const localSupplier = ref<Supplier>({ ...props.supplier })

watch(
  () => props.supplier,
  (newSupplier) => {
    localSupplier.value = { ...newSupplier }
  },
  { immediate: true },
)
</script>
