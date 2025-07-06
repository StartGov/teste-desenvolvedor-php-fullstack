<script setup>
import { Users, Plus, Search } from "lucide-vue-next";

const emit = defineEmits(["open-form", "open-doc-search"]);
</script>

<template>
  <header class="bg-white shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div
        class="flex flex-wrap justify-between items-center py-4 gap-y-4 gap-x-6"
      >
        <div class="flex items-center gap-3">
          <Users class="h-8 w-8 text-blue-600" />
          <h1 class="text-2xl font-bold text-gray-900">
            Gestão de Fornecedores
          </h1>
        </div>
        <div class="flex items-center gap-4 w-full sm:w-auto justify-end">
          <button
            @click="emit('open-doc-search')"
            class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-white hover:bg-gray-100 border border-gray-200 text-zinc-800 px-4 py-2 rounded-md transition-colors cursor-pointer"
          >
            <Search class="h-4 w-4" />
            Buscar CNPJ
          </button>
          <button
            @click="emit('open-form')"
            class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-zinc-800 hover:bg-zinc-900 text-white px-4 py-2 rounded-md transition-colors cursor-pointer"
          >
            <Plus class="h-4 w-4" />
            Novo Fornecedor
          </button>
        </div>
      </div>
    </div>
  </header>
</template>

<style scoped></style>
