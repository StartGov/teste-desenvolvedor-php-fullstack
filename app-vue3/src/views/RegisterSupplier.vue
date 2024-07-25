<template>
  <div class="container">
    <SupplierForm buttonText="Cadastrar" />
  </div>
</template>

<script>
import SupplierForm from '@/components/SupplierForm.vue'

export default {
  components: {
    SupplierForm
  }
}
</script>

<style>
.container {
  margin-top: 50px;
}
</style>
