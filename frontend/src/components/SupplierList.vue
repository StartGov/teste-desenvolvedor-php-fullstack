<script setup>
import SupplierTable from "./SupplierTable.vue";
import Pagination from "./Pagination.vue";
import axios from "axios";
import api from "../services/api";

import { onMounted, ref, watch } from "vue";

const props = defineProps({
  filters: {
    type: Object,
    default: () => ({}),
  },
});

const suppliers = ref([]);
const pagination = ref({});
const loading = ref(true);

const emit = defineEmits(["update-supplier"]);

const fetchSuppliers = async (url = "/suppliers") => {
  loading.value = true;
  try {
    const filterParams = {};
    if (props.filters.search) {
      filterParams.name = props.filters.search;
    }
    if (props.filters.document_type && props.filters.document_type !== "all") {
      filterParams.document_type = props.filters.document_type;
    }
    if (props.filters.sort_by) {
      filterParams.sort_by = props.filters.sort_by;
    }

    const response = await api.get(url, { params: filterParams });

    suppliers.value = response.data.data;

    delete response.data.data;
    pagination.value = response.data;
  } catch (error) {
    console.error("Erro ao buscar fornecedores:", error);
  } finally {
    loading.value = false;
  }
};

defineExpose({
  fetchSuppliers,
});

watch(
  () => props.filters,
  () => {
    fetchSuppliers();
  },
  { deep: true }
);

onMounted(() => {
  fetchSuppliers();
});
</script>

<template>
  <div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">
          Fornecedores Cadastrados
        </h2>
        <span
          v-if="pagination.total"
          class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800"
        >
          {{ pagination.total }} fornecedores
        </span>
      </div>
    </div>

    <div class="p-6">
      <SupplierTable
        :suppliers="suppliers"
        :loading="loading"
        @supplier-deleted="fetchSuppliers"
        @update-supplier="(supplier) => emit('update-supplier', supplier)"
      />

      <Pagination :pagination="pagination" @change-page="fetchSuppliers" />
    </div>
  </div>
</template>

<style scoped></style>
