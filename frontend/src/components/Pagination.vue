<script setup>
defineProps({
  pagination: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(["change-page"]);

const changePage = (url) => {
  if (url) {
    emit("change-page", url);
  }
};
</script>

<template>
  <div
    v-if="pagination && pagination.total > 0"
    class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-4"
  >
    <!-- Mobile view -->
    <div class="flex-1 flex justify-between sm:hidden">
      <button
        type="button"
        @click="changePage(pagination.prev_page_url)"
        :disabled="!pagination.prev_page_url"
        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
      >
        Anterior
      </button>
      <button
        type="button"
        @click="changePage(pagination.next_page_url)"
        :disabled="!pagination.next_page_url"
        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
      >
        Próximo
      </button>
    </div>

    <!-- Desktop view -->
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Mostrando <span class="font-medium">{{ pagination.from }}</span> a
          <span class="font-medium">{{ pagination.to }}</span> de
          <span class="font-medium">{{ pagination.total }}</span> resultados
        </p>
      </div>
      <div>
        <nav
          class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
          aria-label="Pagination"
        >
          <button
            type="button"
            v-for="(link, index) in pagination.links"
            :key="index"
            @click="changePage(link.url)"
            :disabled="!link.url"
            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
            :class="{
              'z-10 bg-blue-50 border-blue-500 text-blue-600': link.active,
              'bg-white border-gray-300 text-gray-500 hover:bg-gray-50':
                !link.active,
              'rounded-l-md': index === 0,
              'rounded-r-md': index === pagination.links.length - 1,
            }"
            v-html="link.label"
          ></button>
        </nav>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
