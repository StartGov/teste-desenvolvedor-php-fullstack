<template>
  <div class="bg-white p-6 rounded-lg shadow max-w-2xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">
      {{ props.id ? $t('supplier.edit_title') : $t('supplier.register_title') }}
    </h2>

    <form @submit.prevent="handleSubmit" class="space-y-5">
      <div>
        <label class="block font-medium">
          {{ $t('supplier.document') }} <span class="text-gray-400 text-sm">{{ $t('supplier.required') }}</span>
        </label>

        <input
          v-model="supplier.document_number"
          @input="handleCNPJInput"
          @blur="buscarDocumento"
          class="w-full border px-3 py-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
          :class="{ 'border-red-500': cnpjError }"
        />

        <div v-if="cnpjError" class="mt-2 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded text-sm flex items-start gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11V6a1 1 0 10-2 0v1a1 1 0 102 0zm0 2a1 1 0 00-2 0v5a1 1 0 102 0V9z" clip-rule="evenodd" />
          </svg>
          <span>{{ $t('supplier.invalid_document') }}</span>
        </div>
      </div>

      <div>
        <label class="block font-medium">
          {{ $t('supplier.company') }} <span class="text-gray-400 text-sm">{{ $t('supplier.required') }}</span>
        </label>
        <input
          v-model="supplier.company_name"
          class="w-full border px-3 py-2 rounded shadow-sm"
          :class="{ 'border-red-500': empresaError }"
        />
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block font-medium">{{ $t('supplier.email') }}</label>
          <input v-model="supplier.email" class="w-full border px-3 py-2 rounded shadow-sm" />
        </div>
        <div>
          <label class="block font-medium">{{ $t('supplier.phone') }}</label>
          <input
            v-model="supplier.phone"
            @input="handlePhoneInput"
            class="w-full border px-3 py-2 rounded shadow-sm"
          />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mt-4">
        <div>
          <label class="block font-medium">{{ $t('supplier.zipcode') }}</label>
          <input
            v-model="supplier.zipcode"
            @input="handleZipcodeInput"
            @blur="buscarEnderecoPorCep"
            class="w-full border px-3 py-2 rounded shadow-sm"
          />
        </div>
        <div>
          <label class="block font-medium">{{ $t('supplier.address') }}</label>
          <input v-model="supplier.address" class="w-full border px-3 py-2 rounded shadow-sm" />
        </div>
      </div>

      <div class="grid grid-cols-3 gap-4 mt-4">
        <div>
          <label class="block font-medium">{{ $t('supplier.address_number') }}</label>
          <input v-model="supplier.address_number" class="w-full border px-3 py-2 rounded shadow-sm" />
        </div>
        <div>
          <label class="block font-medium">{{ $t('supplier.complement') }}</label>
          <input v-model="supplier.address_complement" class="w-full border px-3 py-2 rounded shadow-sm" />
        </div>
        <div>
          <label class="block font-medium">{{ $t('supplier.neighbour') }}</label>
          <input v-model="supplier.neighborhood" class="w-full border px-3 py-2 rounded shadow-sm" />
        </div>
      </div>

      <div class="flex justify-end space-x-3 mt-6">
        <router-link to="/" class="px-4 py-2 rounded border text-gray-600 hover:bg-gray-100">
          {{ $t('common.cancel') }}
        </router-link>
        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
          {{ $t('common.save') }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import supplierApi from '../api/supplier'
import { useRouter } from 'vue-router'

const props = defineProps(['id'])
const router = useRouter()

const supplier = ref({
  document_number: '',
  company_name: '',
  email: '',
  phone: '',
  zipcode: '',
  address: '',
  address_number: '',
  address_complement: '',
  neighborhood: '',
  city: '',
  state: ''
})


const cnpjError = ref(false)
const empresaError = ref(false)

function formatDocumentNumber(value) {
  const cleaned = value.replace(/\D/g, '').slice(0, 14)

  if (cleaned.length <= 11) {
    return cleaned
      .replace(/^(\d{3})(\d)/, '$1.$2')
      .replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3')
      .replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d{1,2})/, '$1.$2.$3-$4')
  } else {
    return cleaned
      .replace(/^(\d{2})(\d)/, '$1.$2')
      .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
      .replace(/^(\d{2})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3/$4')
      .replace(/^(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})(\d{1,2})/, '$1.$2.$3/$4-$5')
  }
}

function formatPhone(value) {
  const cleaned = value.replace(/\D/g, '').slice(0, 11)
  if (cleaned.length <= 10) {
    return cleaned.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3')
  }
  return cleaned.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3')
}

function formatZipcode(value) {
  return value.replace(/\D/g, '').slice(0, 8).replace(/^(\d{5})(\d{0,3})/, '$1-$2')
}


function handleCNPJInput(e) {
  const val = e.target.value
  supplier.value.document_number = formatDocumentNumber(val)
  cnpjError.value = false
}

function handlePhoneInput(e) {
  supplier.value.phone = formatPhone(e.target.value)
}

function handleZipcodeInput(e) {
  supplier.value.zipcode = formatZipcode(e.target.value)
}

async function buscarEnderecoPorCep() {
  const cep = supplier.value.zipcode.replace(/\D/g, '')

  if (cep.length !== 8) return

  try {
    const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
    const data = await response.json()

    if (data.erro) {
      console.warn('CEP não encontrado.')
      return
    }

    supplier.value.address = data.logradouro || ''
    supplier.value.neighborhood = data.bairro || ''
    supplier.value.city = data.localidade || ''
    supplier.value.state = data.uf || ''
  } catch (error) {
    console.error('Erro ao buscar CEP:', error)
  }
}



function isValidCNPJ(cnpj) {
  const cleaned = cnpj.replace(/\D/g, '')
  if (cleaned.length !== 14 || /^(\d)\1+$/.test(cleaned)) return false
  let t = cleaned.length - 2
  let d = cleaned.substring(t)
  let d1 = parseInt(d.charAt(0))
  let d2 = parseInt(d.charAt(1))
  const calc = (x) => {
    let n = cleaned.substring(0, x)
    let y = x - 7
    let s = 0
    for (let i = x; i >= 1; i--) {
      s += n.charAt(x - i) * y--
      if (y < 2) y = 9
    }
    const r = 11 - (s % 11)
    return r > 9 ? 0 : r
  }
  return calc(t) === d1 && calc(t + 1) === d2
}

function isValidCPF(cpf) {
  cpf = cpf.replace(/\D/g, '')
  if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false
  let sum = 0, rest
  for (let i = 1; i <= 9; i++) sum += parseInt(cpf.substring(i - 1, i)) * (11 - i)
  rest = (sum * 10) % 11
  if (rest === 10 || rest === 11) rest = 0
  if (rest !== parseInt(cpf.substring(9, 10))) return false
  sum = 0
  for (let i = 1; i <= 10; i++) sum += parseInt(cpf.substring(i - 1, i)) * (12 - i)
  rest = (sum * 10) % 11
  if (rest === 10 || rest === 11) rest = 0
  return rest === parseInt(cpf.substring(10, 11))
}

async function buscarDocumento() {
  const cleaned = supplier.value.document_number.replace(/\D/g, '')

  if (cleaned.length === 11) {
    if (!isValidCPF(cleaned)) {
      cnpjError.value = true
      return
    }
    supplier.value.company_name = ''
    supplier.value.city = ''
    supplier.value.state = ''
    cnpjError.value = false
    return
  }

  if (cleaned.length === 14) {
    if (!isValidCNPJ(cleaned)) {
      cnpjError.value = true
      return
    }

    try {
      const { data } = await supplierApi.fetchCNPJ(cleaned)
      supplier.value.company_name = data.razao_social
      supplier.value.city = data.municipio
      supplier.value.state = data.uf
      cnpjError.value = false
    } catch {
      cnpjError.value = true
    }
  }
}

async function handleSubmit() {
  const cleaned = supplier.value.document_number.replace(/\D/g, '')
  const isCPF = cleaned.length === 11
  const isCNPJ = cleaned.length === 14

  // Reset errors
  cnpjError.value = false
  empresaError.value = false

  // Validações
  if (!cleaned) {
    cnpjError.value = true
    alert('O campo CNPJ/CPF é obrigatório.')
    return
  }

  if ((isCPF && !isValidCPF(cleaned)) || (isCNPJ && !isValidCNPJ(cleaned))) {
    cnpjError.value = true
    alert('O documento informado é inválido.')
    return
  }

  if (!supplier.value.company_name.trim()) {
    empresaError.value = true
    alert('O campo Empresa é obrigatório.')
    return
  }

  const payload = {
    ...supplier.value,
    document_number: cleaned
  }

  if (props.id) {
    await supplierApi.update(props.id, payload)
  } else {
    await supplierApi.create(payload)
  }
  router.push('/')
}

onMounted(async () => {
  if (props.id) {
    const { data } = await supplierApi.get(props.id)
    supplier.value = {
      ...data.data,
      document_number: formatDocumentNumber(data.data.document_number || '')
    }
  }
})


</script>
