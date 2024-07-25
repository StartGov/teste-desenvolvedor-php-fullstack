<template>
  <div>
    <Navbar />
    <Messages
      :v-if="$store.state"
      :message="$store.state.response_messages != null ? $store.state.response_messages : ''"
    />
  </div>
  <RouterView />
</template>

<script setup>
import Navbar from './components/Navbar.vue'
import Messages from './components/Messages.vue'
</script>

<style scoped></style>
