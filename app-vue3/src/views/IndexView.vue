<template>
  <div class="container mt-5">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      <div class="col" v-for="supplier in suppliers.data" :key="supplier.id">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h3 class="card-title">{{ supplier.name_or_company }}</h3>
            <div class="supplier-info">
              <div class="supplier-info-item">
                <span class="info-label">CPF/CNPJ</span> {{ supplier.document_number }}
              </div>
              <div class="supplier-info-item">
                <span class="info-label">Contato</span> {{ supplier.contact }}
              </div>
              <div class="supplier-info-item">
                <span class="info-label">Endereço</span> {{ supplier.address }}
              </div>
            </div>
          </div>
          <div>
            <a
              id="btn-edit"
              class="btn btn-outline-primary btn-sm me-2"
              @click="goToEdit(supplier.id)"
            >
              Editar
            </a>
            <button
              id="btn-delete"
              class="btn btn-outline-danger btn-sm"
              @click="destroySupplier(supplier.id)"
            >
              Excluir
            </button>
          </div>
        </div>
      </div>
    </div>

    <nav aria-label="Page navigation" class="mt-4">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: !suppliers.prev_page_url }">
          <a class="page-link" href="#" @click.prevent="fetchSuppliers(suppliers.current_page - 1)"
            >Anterior</a
          >
        </li>
        <li
          class="page-item"
          v-for="page in totalPages"
          :key="page"
          :class="{ active: suppliers.current_page === page }"
        >
          <a class="page-link" href="#" @click.prevent="fetchSuppliers(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: !suppliers.next_page_url }">
          <a class="page-link" href="#" @click.prevent="fetchSuppliers(suppliers.current_page + 1)"
            >Próxima</a
          >
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import getSuppliers from '../services/suppliers/getSuppliers.js'
import deleteSupplier from '@/services/suppliers/deleteSupplier.js'

export default {
  data() {
    return {
      suppliers: {
        data: [],
        current_page: 1,
        last_page: 1,
        prev_page_url: null,
        next_page_url: null
      }
    }
  },

  computed: {
    totalPages() {
      return Array.from({ length: this.suppliers.last_page }, (v, k) => k + 1)
    }
  },

  methods: {
    async fetchSuppliers(page = 1) {
      const suppliers = await getSuppliers(page)

      if (suppliers) {
        this.suppliers = suppliers
      }
    },

    async destroySupplier(id) {
      await deleteSupplier(id)

      this.suppliers.data = this.suppliers.data.filter((supplier) => supplier.id !== id)
    },

    goToEdit(id) {
      this.$router.push({ name: 'edit', params: { id } })
    }
  },

  async mounted() {
    await this.fetchSuppliers()
  }
}
</script>

<style>
.container {
  margin-top: 50px;
}

.card {
  border: 1px solid #e3e6f0;
  border-radius: 0.75rem;
  transition:
    transform 0.2s,
    box-shadow 0.2s;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.card-title {
  border-bottom: 1px solid #10b981;
  text-transform: uppercase;
  color: #10b981;
  font-weight: 500;
}

.supplier-info {
  margin-top: 20px;
}

.supplier-info-item {
  display: flex;
  flex-direction: column;
  margin-top: 10px;
}

.info-label {
  font-weight: 500;
  color: #065f46;
}

#btn-edit {
  margin: 10px;
}

#btn-delete {
  margin: 10px;
}

.pagination .page-item.disabled .page-link {
  pointer-events: none;
  color: #6c757d;
  background-color: #fff;
  border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
  z-index: 1;
  color: #fff;
  background-color: #065f46;
  border-color: #065f46;
}
</style>
