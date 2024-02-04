<template>
  <div>
    <b-container fluid>
      <b-row>
        <b-col md="4">
          <b-row>
            <b-col cols="6">
              <b-form-group
                  label="Filter"
                  label-for="filter-input"
                  label-cols-sm="3"
                  label-align-sm="right"
                  label-size="sm"
                  class="mb-0"
              >
                <b-input-group size="sm">
                  <b-form-input
                      id="filter-input"
                      v-model="filter"
                      type="search"
                      placeholder="Type to Search"
                  >
                  </b-form-input>

                  <b-input-group-append>
                    <b-button
                        class="pe-auto"
                        variant="danger"
                        :disabled="!filter"
                        @click="filter = ''">
                      Clear
                    </b-button>
                  </b-input-group-append>
                </b-input-group>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                  label="Initial sort"
                  label-for="initial-sort-select"
                  label-cols-sm="3"
                  label-align-sm="right"
                  label-size="sm"
                  class="mb-0"
              >
                <b-form-select
                    class="mt-2"
                    id="initial-sort-select"
                    v-model="sortDirection"
                    :options="['asc', 'desc', 'last']"
                    size="sm"
                ></b-form-select>
              </b-form-group>
            </b-col>
          </b-row>
          </b-col>
        <b-col md="4" offset-md="4">
          <b-button
              class="pe-auto"
              variant="primary"
              v-b-modal.supplier
          >
            <b-icon
                class="pe-auto"
                icon="plus"
                aria-hidden="true"
                variant="info"
            />
            Supplier
          </b-button>
        </b-col>
      </b-row>
      <b-table
        :busy="isBusy"
        responsive
        :items="suppliers"
        :fields="fields"
        :per-page="0"
        :current-page="currentPage"
        :filter="filter"
        :filter-included-fields="filterOn"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        :sort-direction="sortDirection"
        stacked="md"
        show-empty
        small
        @filtered="onFiltered"
      >
        <template #table-busy>
          <div class="text-center text-danger my-2">
            <b-spinner class="align-middle"></b-spinner>
            <strong>Loading...</strong>
          </div>
        </template>

        <template #cell(actions)="row">
          <b-button
              class="pe-auto"
              variant="outline-*"
              size="sm"
          >
            <b-icon
                class="pe-auto"
                icon="gear-fill"
                aria-hidden="true"
                variant="info"
            />
          </b-button>
          <b-button
              class="pe-auto"
              variant="outline-*"
              size="sm"
              @click="deleteSupplier(row.item.id)"
          >
            <b-icon
                icon="trash-fill"
                aria-hidden="true"
                variant="danger"
            />
          </b-button>
        </template>

      </b-table>
      <b-pagination
        v-model="currentPage"
        :total-rows="totalRows"
        :per-page="perPage"
        @input="pageChanged"
        align="center"
      />
    </b-container>
    <b-modal
        id="supplier"
        title="Supplier"
        size="lg"
        ok-variant="primary"
        cancel-variant="danger"
        cancel-title="Cancel"
        no-close-on-backdrop
    >
      <b-form
          @reset="onReset"
          v-if="showForm"
      >
        <b-form-group
            id="input-group-1"
            label="CPF/CNPJ:"
            label-for="input-1"
        >
          <b-form-input
              id="input-1"
              v-model="supplier.cpf_cnpj"
              placeholder="Enter cpf or cnpj"
              :state="validationCpfCnpj"
              required
          >
          </b-form-input>
          <b-form-invalid-feedback :state="validationCpfCnpj">
            Your CPF/CNPJ must be 11-14 characters long.
          </b-form-invalid-feedback>
        </b-form-group>

        <b-form-group
            id="input-group-2"
            label="Nome Fantasia:"
            label-for="input-2"
        >
          <b-form-input
              id="input-2"
              v-model="supplier.nome_fantasia"
              placeholder="Enter nome fantasia"
              required
          ></b-form-input>
        </b-form-group>

        <b-form-group
            id="input-group-2"
            label="Razão Social:"
            label-for="input-2"
        >
          <b-form-input
              id="input-2"
              v-model="supplier.razao_social"
              placeholder="Enter razao social"
              required
          ></b-form-input>
        </b-form-group>

        <b-form-group
            id="input-group-2"
            label="Contato:"
            label-for="input-2"
        >
          <b-form-input
              id="input-2"
              v-model="supplier.contato"
              placeholder="Enter Contato"
              required
          ></b-form-input>
        </b-form-group>

        <b-form-group
            id="input-group-2"
            label="Endereço:"
            label-for="input-2"
        >
          <b-form-input
              id="input-2"
              v-model="supplier.endereco"
              placeholder="Enter Endereço"
              required
          ></b-form-input>
        </b-form-group>

        <b-form-group
            id="input-group-2"
            label="Número:"
            label-for="input-2"
        >
          <b-form-input
              id="input-2"
              v-model="supplier.numero"
              placeholder="Enter Número"
              required
          ></b-form-input>
        </b-form-group>
        <b-button
            class="mt-2"
            type="reset"
            variant="warning"
        >
          Reset
        </b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>

import {
  BTable,
  BPagination,
  BSpinner,
  BCol,
  BRow,
  BFormGroup,
  BFormInput,
  BInputGroup,
  BInputGroupAppend,
  BButton,
  BIcon,
  BModal,
  BForm,
  BFormInvalidFeedback,
} from 'bootstrap-vue'
import Swal from 'sweetalert2'
import axios from '../axios'
export default {
  components: {
    BTable,
    BPagination,
    BSpinner,
    BCol,
    BRow,
    BFormGroup,
    BFormInput,
    BInputGroup,
    BInputGroupAppend,
    BButton,
    BIcon,
    BModal,
    BForm,
    BFormInvalidFeedback,
  },
  data() {
    return {
      suppliers: [],
      fields: [
        { key: 'id', label: 'ID' },
        { key: 'cpf_cnpj', label: 'CPF/CNPJ' },
        { key: 'actions', label: 'Actions' }
      ],
      perPage: 10,
      currentPage: 1,
      totalRows: 0,
      isBusy: true,
      sortBy: '',
      sortDesc: false,
      sortDirection: 'asc',
      filter: null,
      filterOn: [],
      supplier: {
        cpf_cnpj: '',
        nome_fantasia: '',
        razao_social: '',
        contato: '',
        endereco: '',
        numero: '',
      },
      showForm: true,
    }
  },
  computed: {
    sortOptions() {
      return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
          })
    },
    validationCpfCnpj() {
      if (this.supplier.cpf_cnpj.length === 0) {
        return null
      }
      const value = this.supplier.cpf_cnpj.replace(/[^\d]+/g, '')
      const isCpf = value.length === 11
      const isCnpj = value.length === 14

      return isCpf || isCnpj
    }
  },
  created() {
    this.getSuppliers()
  },
  methods: {
    async getSuppliers() {
      const response = await axios.get(`suppliers?page=${this.currentPage}`)
      this.suppliers = response.data.data
      this.totalRows = response.data.meta.total
      this.isBusy = false

    },
    pageChanged() {
      this.isBusy = true
      this.getSuppliers()
    },
    onFiltered(filteredItems) {
      this.totalRows = filteredItems.length
      this.currentPage = 1
    },
    deleteSupplier(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(async (result) => {
        if (result.isConfirmed) {
          axios
              .delete(`suppliers/${id}`)
              .then(()=> {
                this.isBusy = true
                this.getSuppliers()
                Swal.fire({
                  title: "Deleted!",
                  text: "Supplier deleted.",
                  icon: "success"
                })
              })
              .catch(error => {
                console.error(error)
              })

        }
      })
    },

    onReset(event) {
      event.preventDefault()
      this.supplier.cpf_cnpj = ''
      this.supplier.nome_fantasia = ''
      this.supplier.razao_social = ''
      this.supplier.contato = ''
      this.supplier.endereco = ''
      this.supplier.numero = ''
      this.showForm = false
      this.$nextTick(() => {
        this.showForm = true
      })
    }
  },
}
</script>

<style scoped>

</style>
