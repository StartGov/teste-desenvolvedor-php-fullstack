<script setup>
import { Search } from "lucide-vue-next";
import { ref, watch } from "vue";

const emit = defineEmits(["update-filters"]);

const filters = ref({
  search: "",
  document_type: "all",
  sort_by: "name",
});

watch(
  filters,
  (newFilters) => {
    emit("update-filters", newFilters);
  },
  { deep: true }
);

const clearFilters = () => {
  filters.value = {
    search: "",
    document_type: "all",
    sort_by: "name",
  };
};
</script>

<template>
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
    <div class="p-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label
            for="search"
            class="block text-sm font-medium text-gray-700 mb-1"
          >
            Buscar por nome/documento
          </label>
          <div class="relative">
            <Search
              class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4"
            />
            <input
              id="search"
              type="text"
              placeholder="Digite para buscar..."
              class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500"
              v-model="filters.search"
            />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"
            >Tipo</label
          >
          <select
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500"
            v-model="filters.document_type"
          >
            <option value="all">Todos</option>
            <option value="cnpj">Pessoa Jurídica</option>
            <option value="cpf">Pessoa Física</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"
            >Ordenar por</label
          >
          <select
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500"
            v-model="filters.sort_by"
          >
            <option value="name">Nome</option>
            <option value="document">Documento</option>
            <option value="createdAt">Data de Cadastro</option>
          </select>
        </div>

        <div class="flex items-end">
          <button
            type="button"
            @click="clearFilters"
            class="w-full px-4 py-2 border border-gray-300 rounded-md bg-transparent hover:bg-gray-50 text-gray-700 font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 cursor-pointer"
          >
            Limpar Filtros
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
