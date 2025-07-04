<template>
  <div class="flex justify-end p-4">
    <select v-model="lang" @change="changeLanguage" class="border px-2 py-1 rounded">
      <option value="pt-br">Português</option>
      <option value="en">English</option>
    </select>
  </div>
  <a
    href="http://localhost/api/documentation"
    target="_blank"
    rel="noopener noreferrer"
    class="ml-2 text-sm text-gray-600 hover:text-blue-600 underline"
  >
    Swagger Docs
  </a>
  <router-view />
</template>

<script setup>
import { ref } from 'vue'

import { useI18n } from 'vue-i18n'

const { locale } = useI18n()
const lang = ref(locale.value)

function changeLanguage() {
  locale.value = lang.value
  localStorage.setItem('lang', lang.value)
}
</script>
