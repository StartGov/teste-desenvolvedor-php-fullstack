<template>
  <div v-if="message" :class="['alert', alertType]" role="alert">
    {{ message }}
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true
    },
    type: {
      type: String,
      default: 'success' // Pode ser 'success' ou 'error'
    }
  },
  computed: {
    alertType() {
      return this.type === 'success' ? 'alert-success' : 'alert-danger'
    }
  }
}
</script>

<style scoped>
.alert {
  padding: 15px;
}
.alert-success {
  background-color: #d4edda;
  color: #155724;
}
.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
}
</style>
