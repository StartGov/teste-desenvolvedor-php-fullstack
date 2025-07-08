<template>
  <div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    aria-labelledby="offcanvasRightLabel"
    id="drawerNew"
  >
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Adicionar novo fornecedor</h5>
      <button type="button" class="btn-close" @click="emit('cancel')"></button>
    </div>
    <div class="offcanvas-body">
      <form @submit.prevent="handleSubmit">
        <div class="mb-3">
          <label class="form-label">Tipo de Documento</label>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              id="cpf"
              value="CPF"
              v-model="form.codeType"
            />
            <label class="form-check-label" for="cpf">CPF</label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              id="cnpj"
              value="CNPJ"
              v-model="form.codeType"
            />
            <label class="form-check-label" for="cnpj">CNPJ</label>
          </div>
        </div>

        <div class="mb-3" v-if="form.codeType">
          <label class="form-label">{{ form.codeType }}</label>
          <input
            v-model="form.code"
            :placeholder="
              form.codeType === 'CPF'
                ? 'Digite o CPF (somente números)'
                : 'Digite o CNPJ (somente números)'
            "
            class="form-control"
            :class="{ 'is-invalid': showCodeError }"
            @input="form.code = form.code.replace(/\D/g, '')"
            @blur="handleBlur()"
            required
          />
          <div v-if="showCodeError" class="invalid-feedback">
            {{ form.codeType }} inválido. Insira
            {{ form.codeType === 'CPF' ? '11' : '14' }} números.
          </div>
        </div>

        <div class="mb-3" v-if="form.codeType === 'CPF' || form.name">
          <label class="form-label">Nome</label>
          <input v-model="form.name" type="text" class="form-control" required />
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-secondary" @click="emit('cancel')">Cancelar</button>
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, ref, computed } from 'vue'
import apiCNPJ from '@/services/brasilAPI'

const props = defineProps<{}>()

type FormData = {
  name: string
  codeType: 'CPF' | 'CNPJ'
  code: string
}

const emit = defineEmits<{
  (e: 'submit', data: { name: string; code: string }): void
  (e: 'cancel'): void
}>()

const form = ref({
  name: '',
  code: '',
  codeType: 'CPF',
})

const showCodeError = computed(() => {
  if (!form.value.code) return false
  if (form.value.codeType === 'CPF') return !validCpf(form.value.code)
  return !validCnpj(form.value.code)
})

function validCpf(cpf: string): boolean {
  return /^\d{11}$/.test(cpf)
}

function validCnpj(cnpj: string): boolean {
  return /^\d{14}$/.test(cnpj)
}

function handleBlur() {
  if (form.value.codeType === 'CNPJ' && validCnpj(form.value.code)) {
    findSupplierByCNPJ()
  }
}

function handleSubmit() {
  if (
    (form.value.codeType == 'CPF' && validCpf(form.value.code)) ||
    (form.value.codeType == 'CNPJ' && validCnpj(form.value.code))
  ) {
    emit('submit', { ...form.value })
    form.value = { name: '', code: '', codeType: 'CPF' }
  } else {
    alert('Documento inválido, verifique as informações e tente novamente.')
  }
}

async function findSupplierByCNPJ() {
  console.log(form.value.code)
  if (!form.value.code) return

  try {
    const { data } = await apiCNPJ.get(`${form.value.code.replace(/\D/g, '')}`)
    form.value.name = data.nome_fantasia
  } catch (error) {
    alert('Fornecedor não encontrado para este CNPJ.')
  }
}
</script>
