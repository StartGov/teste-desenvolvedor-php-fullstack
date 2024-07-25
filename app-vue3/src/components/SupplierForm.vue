<template>
  <div class="container-form">
    <form class="row g-3 needs-validation" @submit.prevent="submitForm" novalidate>
      <div class="col-md-4">
        <label for="name_or_company" class="form-label">Nome / Empresa</label>
        <input
          type="text"
          class="form-control"
          id="name_or_company"
          name="name_or_company"
          placeholder="Ex: StartGov"
          v-model="formData.name_or_company"
          required
        />
        <div class="invalid-feedback">Por favor, informe um nome ou empresa.</div>
      </div>

      <div class="col-md-4">
        <label for="document_number" class="form-label">CPF/CNPJ</label>
        <input
          type="text"
          class="form-control"
          id="document_number"
          name="document_number"
          placeholder="00.000.000/0001-00"
          v-model="formData.document_number"
          required
        />
        <div class="invalid-feedback">Por favor, informe um CPF ou CNPJ válido.</div>
      </div>

      <div class="col-md-4">
        <label for="contact" class="form-label">Contato</label>
        <input
          type="tel"
          class="form-control"
          id="contact"
          name="contact"
          placeholder="(99) 9 9999-9999"
          v-model="formData.contact"
          required
        />
        <div class="invalid-feedback">Por favor, informe um contato válido.</div>
      </div>

      <div class="col-md-12">
        <label for="address" class="form-label">Endereço Completo</label>
        <input
          type="text"
          class="form-control"
          id="address"
          name="address"
          placeholder="Rua, Número, Cidade, Estado, CEP"
          v-model="formData.address"
          required
        />
        <div class="invalid-feedback">Por favor, informe um endereço válido.</div>
      </div>

      <div class="col-12">
        <button class="btn btn-primary" type="submit">{{ buttonText }}</button>
      </div>
    </form>
  </div>
</template>

<script>
import postSupplier from '../services/suppliers/postSupplier.js'

export default {
  data() {
    return {
      formData: {
        name_or_company: '',
        document_number: '',
        address: '',
        contact: ''
      }
    }
  },
  props: {
    buttonText: {
      type: String,
      default: 'Cadastrar'
    }
  },
  methods: {
    async submitForm() {
      await postSupplier(this.formData)
    }
  }
}
</script>

<style>
.container-form {
  padding: 60px;
  max-width: 90%;
  border-radius: 8px;
  background-color: #f8f9fa;
  margin: 0 auto;
}

.form-label {
  color: #495057;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #004085;
}

input:focus,
select:focus {
  border-color: #007bff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.invalid-feedback {
  display: none;
}

input:invalid + .invalid-feedback,
select:invalid + .invalid-feedback {
  display: block;
}

input:valid + .valid-feedback,
select:valid + .valid-feedback {
  display: block;
}

input.is-invalid,
select.is-invalid {
  border-color: #dc3545;
}

input.is-valid,
select.is-valid {
  border-color: #28a745;
}
</style>
