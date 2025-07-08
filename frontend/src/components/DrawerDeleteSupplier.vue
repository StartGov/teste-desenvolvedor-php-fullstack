<template>
  <div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    aria-labelledby="offcanvasRightLabel"
    id="drawerDelete"
  >
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Apagar Fornecedor</h5>
      <button type="button" class="btn-close" @click="emit('close')"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-3">
          Você tem certeza que quer apagar o fornecedor {{ localSupplier.name }} ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="emit('close')">Cancelar</button>
          <button type="submit" class="btn btn-primary" @click="emit('delete', localSupplier)">Apagar</button>
        </div>
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
  (e: 'delete', deletedUser: Supplier): void
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
