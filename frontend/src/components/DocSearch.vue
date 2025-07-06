<script setup>
import { Search, X } from "lucide-vue-next";
import { ref } from "vue";
import api from "../services/api";
import { useToasts } from "./toast/useToasts";

const emit = defineEmits(["close-doc-search"]);
const { addToast } = useToasts();

const cnpj = ref("");

const data = ref({
  razSocial: "",
  nomeFantasia: "",
  cnpj: "",
  telefone: "",
  logradouro: "",
  bairro: "",
  municipio: "",
  uf: "",
});

const handleSearch = () => {
  if (!cnpj.value) {
    addToast("Por favor, insira um CNPJ para buscar.", "error");
    return;
  }

  api
    .get(`/suppliers/fetch-cnpj/${cnpj.value}`)
    .then((response) => {
      if (response.data) {
        data.value = {
          razSocial: response.data.razao_social || "",
          nomeFantasia: response.data.nome_fantasia || "",
          cnpj: response.data.cnpj || "",
          telefone:
            response.data.ddd_telefone_1 || response.data.ddd_telefone_2 || "",
          logradouro: response.data.logradouro || "",
          bairro: response.data.bairro || "",
          municipio: response.data.municipio || "",
          uf: response.data.uf || "",
        };
      } else {
        addToast("Fornecedor não encontrado.", "error");
      }
    })
    .catch((error) => {
      console.error("Erro ao buscar fornecedor:", error);
      addToast(
        "Erro ao buscar fornecedor. Tente novamente mais tarde.",
        "error"
      );
    });
};
</script>

<template>
  <div
    class="bg-white rounded-lg shadow-lg w-full max-w-2xl flex flex-col max-h-[90vh]"
  >
    <div
      class="p-4 border-b border-gray-200 flex justify-between items-center flex-shrink-0"
    >
      <h2 class="text-lg font-semibold">Buscar e Visualizar Documento</h2>
      <button
        @click="emit('close-doc-search')"
        class="p-2 rounded-md hover:bg-gray-100 cursor-pointer"
      >
        <X class="h-4 w-4" />
      </button>
    </div>
    <div class="p-6 space-y-6 overflow-y-auto">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          CNPJ
        </label>
        <div class="flex gap-2">
          <input
            type="text"
            placeholder="Digite o CNPJ para buscar..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500"
            v-model="cnpj"
          />
          <button
            @click="handleSearch"
            type="button"
            class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-100 border border-gray-200 text-zing-800 rounded-md cursor-pointer"
          >
            <Search class="h-4 w-4" />
            <span>Buscar</span>
          </button>
        </div>
      </div>

      <div class="border-t border-gray-200"></div>

      <div class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Razão Social</label
            >
            <input
              v-model="data.razSocial"
              type="text"
              class="w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md"
              readonly
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Nome Fantasia</label
            >
            <input
              v-model="data.nomeFantasia"
              type="text"
              class="w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md"
              readonly
            />
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >CNPJ</label
            >
            <input
              v-model="data.cnpj"
              type="text"
              class="w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md"
              readonly
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Telefone</label
            >
            <input
              v-model="data.telefone"
              type="text"
              class="w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md"
              readonly
            />
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"
            >Logradouro</label
          >
          <input
            v-model="data.logradouro"
            type="text"
            class="w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md"
            readonly
          />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Bairro</label
            >
            <input
              v-model="data.bairro"
              type="text"
              class="w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md"
              readonly
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Município</label
            >
            <input
              v-model="data.municipio"
              type="text"
              class="w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md"
              readonly
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >UF</label
            >
            <input
              v-model="data.uf"
              type="text"
              class="w-full bg-gray-50 px-3 py-2 border border-gray-300 rounded-md"
              readonly
            />
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
        <button
          @click="emit('close-doc-search')"
          class="px-4 py-2 border border-gray-300 rounded-md bg-transparent hover:bg-gray-50 text-gray-700 cursor-pointer"
        >
          Fechar
        </button>
      </div>
    </div>
  </div>
</template>
