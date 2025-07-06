<script setup>
import { X } from "lucide-vue-next";
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import api from "../services/api";
import { z } from "zod";
import { useToasts } from "./toast/useToasts";
import { vMaska } from "maska/vue";

const props = defineProps({
  supplierData: {
    type: Object,
    default: null,
  },
});

const emit = defineEmits(["close-form", "supplier-updated"]);
const { addToast } = useToasts();

const isEditing = computed(() => !!props.supplierData);

const supplier = ref({
  document_type: "",
  document_number: "",
  name: "",
  phone: "",
  address: {
    street: "",
    house_number: "",
    neighborhood: "",
    city: "",
    state: "",
  },
});

const errors = ref({});

onMounted(() => {
  if (isEditing.value) {
    supplier.value = { ...props.supplierData };
  }
});

const supplierSchema = z.object({
  document_type: z.enum(["CPF", "CNPJ"], {
    errorMap: () => ({ message: "Selecione um tipo de documento." }),
  }),
  document_number: z
    .string()
    .min(1, "O número do documento é obrigatório.")
    .transform((val) => val.replace(/\D/g, "")),
  name: z.string().min(3, "O nome deve ter pelo menos 3 caracteres."),
  phone: z
    .string()
    .min(10, "O telefone parece curto demais.")
    .transform((val) => val.replace(/\D/g, "")),
  address: z.object({
    street: z.string().min(1, "A rua é obrigatória."),
    house_number: z.string().min(1, "O número é obrigatório."),
    neighborhood: z.string().min(1, "O bairro é obrigatório."),
    city: z.string().min(1, "A cidade é obrigatória."),
    state: z
      .string()
      .min(2, "O estado (UF) deve ter 2 caracteres.")
      .max(2, "O estado (UF) deve ter no máximo 2 caracteres."),
  }),
});

const handleSubmit = async (event) => {
  event.preventDefault();
  errors.value = {};

  const result = supplierSchema.safeParse(supplier.value);

  if (!result.success) {
    const fieldErrors = {};
    for (const issue of result.error.issues) {
      fieldErrors[issue.path.join(".")] = issue.message;
    }
    errors.value = fieldErrors;
    addToast("Por favor, corrija os erros no formulário.", "error");
    return;
  }

  try {
    if (isEditing.value) {
      await api.patch(`suppliers/${props.supplierData.id}`, result.data);
      addToast("Fornecedor atualizado com sucesso!", "success");
    } else {
      await api.post("suppliers", result.data);
      addToast("Fornecedor cadastrado com sucesso!", "success");
    }
    emit("supplier-updated");
    emit("close-form");
  } catch (error) {
    if (error.response && error.response.status === 422) {
      const backendErrors = error.response.data.errors;
      if (backendErrors) {
        for (const field in backendErrors) {
          errors.value[field] = backendErrors[field][0];
        }
      }
      addToast(
        error.response.data.message ||
          "Verifique os dados informados e tente novamente.",
        "error"
      );
    } else {
      console.error("Erro ao cadastrar fornecedor:", error);
      addToast("Erro ao cadastrar fornecedor. Tente novamente.", "error");
    }
  }
};
</script>

<template>
  <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
      <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">
          {{ isEditing ? "Editar Fornecedor" : "Novo Fornecedor" }}
        </h2>
        <button
          type="button"
          @click="emit('close-form')"
          class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-md transition-colors cursor-pointer"
        >
          <X class="h-4 w-4" />
        </button>
      </div>
    </div>

    <div class="p-6">
      <form class="space-y-6" @submit="handleSubmit">
        <div>
          <label class="block text-base font-medium text-gray-700 mb-2"
            >Tipo de Documento</label
          >
          <div class="flex gap-4">
            <label
              class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-md cursor-pointer"
            >
              <input
                type="radio"
                name="document_type"
                value="CNPJ"
                class="form-radio h-4 w-4 text-blue-600"
                v-model="supplier.document_type"
                required
              />
              <span>Pessoa Jurídica (CNPJ)</span>
            </label>
            <label
              class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-md cursor-pointer"
            >
              <input
                type="radio"
                name="document_type"
                value="CPF"
                class="form-radio h-4 w-4 text-blue-600"
                v-model="supplier.document_type"
                required
              />
              <span>Pessoa Física (CPF)</span>
            </label>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Numero do Documento</label
            >
            <input
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md"
              v-model="supplier.document_number"
              v-maska
              data-maska="['##.###.###/####-##', '###.###.###-##']"
              placeholder="00.000.000/0000-00 ou 000.000.000-00"
              required
            />
            <p v-if="errors.document_number" class="text-red-500 text-xs mt-1">
              {{ errors.document_number }}
            </p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Nome</label
            >
            <input
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md"
              v-model="supplier.name"
              required
            />
            <p v-if="errors.name" class="text-red-500 text-xs mt-1">
              {{ errors.name }}
            </p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"
              >Telefone</label
            >
            <input
              type="tel"
              class="w-full px-3 py-2 border border-gray-300 rounded-md"
              v-model="supplier.phone"
              v-maska
              data-maska="['(##) ####-####', '(##) #####-####']"
              placeholder="(99) 99999-9999"
              required
            />
            <p v-if="errors.phone" class="text-red-500 text-xs mt-1">
              {{ errors.phone }}
            </p>
          </div>
        </div>

        <div class="pt-6 border-t border-gray-200">
          <h3 class="text-base font-medium text-gray-900 mb-4">Endereço</h3>
          <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
            <div class="md:col-span-4">
              <label class="block text-sm font-medium text-gray-700 mb-1"
                >Rua</label
              >
              <input
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                v-model="supplier.address.street"
                required
              />
              <p
                v-if="errors['address.street']"
                class="text-red-500 text-xs mt-1"
              >
                {{ errors["address.street"] }}
              </p>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1"
                >Número</label
              >
              <input
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                v-model="supplier.address.house_number"
                required
              />
              <p
                v-if="errors['address.house_number']"
                class="text-red-500 text-xs mt-1"
              >
                {{ errors["address.house_number"] }}
              </p>
            </div>
            <div class="md:col-span-3">
              <label class="block text-sm font-medium text-gray-700 mb-1"
                >Bairro</label
              >
              <input
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                v-model="supplier.address.neighborhood"
                required
              />
              <p
                v-if="errors['address.neighborhood']"
                class="text-red-500 text-xs mt-1"
              >
                {{ errors["address.neighborhood"] }}
              </p>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1"
                >Cidade</label
              >
              <input
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                v-model="supplier.address.city"
                required
              />
              <p
                v-if="errors['address.city']"
                class="text-red-500 text-xs mt-1"
              >
                {{ errors["address.city"] }}
              </p>
            </div>
            <div class="md:col-span-1">
              <label class="block text-sm font-medium text-gray-700 mb-1"
                >UF</label
              >
              <input
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
                v-model="supplier.address.state"
                required
              />
              <p
                v-if="errors['address.state']"
                class="text-red-500 text-xs mt-1"
              >
                {{ errors["address.state"] }}
              </p>
            </div>
          </div>
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
          <button
            type="button"
            @click="emit('close-form')"
            class="px-4 py-2 border border-gray-300 rounded-md bg-transparent hover:bg-gray-50 text-gray-700 cursor-pointer"
          >
            Cancelar
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-zinc-800 hover:bg-zinc-900 text-white rounded-md cursor-pointer"
          >
            {{ isEditing ? "Salvar Alterações" : "Cadastrar" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped></style>
