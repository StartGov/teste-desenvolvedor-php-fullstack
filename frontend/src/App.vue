<script setup>
import Header from "./components/Header.vue";
import SupplierFilters from "./components/SupplierFilters.vue";
import SupplierList from "./components/SupplierList.vue";
import SupplierForm from "./components/SupplierForm.vue";
import DocSearch from "./components/DocSearch.vue";
import Toast from "./components/toast/Toast.vue";

import { ref } from "vue";

const showForm = ref(false);
const showDocSearch = ref(false);
const activeFilters = ref({});
const supplierToEdit = ref(null);
const supplierListRef = ref(null);

const openForm = (supplier = null) => {
  if (supplier) {
    supplierToEdit.value = {
      ...supplier,
      address: {
        street: supplier.address,
        house_number: supplier.house_number,
        neighborhood: supplier.neighborhood,
        city: supplier.city,
        state: supplier.uf,
      },
    };
  } else {
    supplierToEdit.value = null;
  }
  showForm.value = true;
};

const closeForm = () => {
  showForm.value = false;
  supplierToEdit.value = null;
};

const openDocSearch = () => {
  showDocSearch.value = true;
};

const closeDocSearch = () => {
  showDocSearch.value = false;
};

const handleUpdateFilters = (filters) => {
  activeFilters.value = filters;
};

const handleSupplierUpdate = () => {
  if (supplierListRef.value) {
    supplierListRef.value.fetchSuppliers();
  }
};
</script>

<template>
  <main class="min-h-screen bg-gray-50">
    <Header @open-form="openForm" @open-doc-search="openDocSearch" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <SupplierFilters @update-filters="handleUpdateFilters" />
      <SupplierList
        :filters="activeFilters"
        @update-supplier="openForm"
        ref="supplierListRef"
      />
    </div>

    <div
      v-if="showForm"
      class="fixed inset-0 bg-black bg-black/50 z-40 flex justify-center items-center"
      @click.self="closeForm"
    >
      <div class="w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <SupplierForm
          @close-form="closeForm"
          :supplier-data="supplierToEdit"
          @supplier-updated="handleSupplierUpdate"
        />
      </div>
    </div>

    <div
      v-if="showDocSearch"
      class="fixed inset-0 bg-black/50 z-40 flex justify-center items-center p-4"
      @click.self="closeDocSearch"
    >
      <DocSearch @close-doc-search="closeDocSearch" />
    </div>

    <Toast />
  </main>
</template>

<style scoped></style>
