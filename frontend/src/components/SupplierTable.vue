<script setup>
import { Edit, Trash2 } from "lucide-vue-next";
import { useToasts } from "./toast/useToasts";
import axios from "axios";
import api from "../services/api";

const { addToast } = useToasts();

defineProps({
  suppliers: {
    type: Array,
    default: () => [],
  },
  loading: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["supplier-deleted", "update-supplier"]);

const deleteSupplier = async (id) => {
  try {
    const response = await api.delete(`/suppliers/${id}`);

    if (response.status === 200) {
      addToast("Fornecedor excluído com sucesso.", "success");
      emit("supplier-deleted");
    }
  } catch (error) {
    console.error("Erro ao excluir fornecedor:", error);
    addToast(
      "Ocorreu um erro ao excluir o fornecedor, tente novamente.",
      "error"
    );
  }
};

const updateSupplier = (supplier) => {
  emit("update-supplier", supplier);
};
</script>

<template>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Nome/Razão Social
          </th>
          <th
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Documento
          </th>
          <th
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Contato
          </th>
          <th
            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Cidade/Estado
          </th>
          <th
            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            Ações
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-if="loading">
          <td colspan="5" class="px-6 py-4 text-center text-gray-500">
            Carregando fornecedores...
          </td>
        </tr>
        <tr v-else-if="!suppliers.length">
          <td colspan="5" class="px-6 py-4 text-center text-gray-500">
            Nenhum fornecedor encontrado.
          </td>
        </tr>
        <tr
          v-else
          v-for="supplier in suppliers"
          :key="supplier.id"
          class="hover:bg-gray-50"
        >
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">
              {{ supplier.name }}
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">
              {{ supplier.document_number }}
            </div>
            <span
              class="inline-flex px-2 py-1 text-xs font-medium rounded-md border border-gray-300 text-gray-700 bg-white"
            >
              {{ supplier.document_type }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-500">{{ supplier.phone }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ supplier.city }}/{{ supplier.uf }}
          </td>
          <td
            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
          >
            <div class="flex justify-end gap-2">
              <button
                type="button"
                title="Editar"
                class="cursor-pointer"
                @click="updateSupplier(supplier)"
              >
                <Edit class="h-4 w-4 text-blue-600" />
              </button>
              <button
                type="button"
                title="Excluir"
                class="cursor-pointer"
                @click="deleteSupplier(supplier.id)"
              >
                <Trash2 class="h-4 w-4 text-red-600" />
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped></style>
