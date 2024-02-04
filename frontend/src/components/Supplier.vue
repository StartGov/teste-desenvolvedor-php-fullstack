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
              @click="editSupplier(row.item)"
          >
            <b-icon
                v-b-tooltip.hover="'Edit Supplier'"
                class="pe-auto"
                icon="gear-fill"
                aria-hidden="true"
                variant="info"
            />
          </b-button>
          <b-button
              v-b-tooltip.hover="'Delete Supplier'"
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
        :ok-title=" edit ? 'Update' : 'Store' "
        @ok="edit ? updateSupplier() : storeSupplier()"
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
          <b-input-group size="sm" class="mb-2">
            <b-form-input
                id="input-1"
                v-model="supplier.cpf_cnpj"
                placeholder="Enter cpf or cnpj"
                :state="validationCpfCnpj"
                required
            >
            </b-form-input>
              <b-input-group-prepend is-text>
                  <b-icon
                      v-b-tooltip.hover="'Pesquisar CPF/CNPJ'"
                      icon="search"
                      style="cursor:pointer"
                      @click="searchSupplier()"
                  />
              </b-input-group-prepend>
            </b-input-group>
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
              :state="validationNomeFantansia"
              required
          >
          </b-form-input>
          <b-form-invalid-feedback :state="validationNomeFantansia">
            Your Nome Fantasia must be 1-254 characters long.
          </b-form-invalid-feedback>
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
              :state="validationRazaoSocial"
              required
          ></b-form-input>
          <b-form-invalid-feedback :state="validationRazaoSocial">
            Your Razão Social must be 1-254 characters long.
          </b-form-invalid-feedback>
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
              :state="validationContato"
              required
          ></b-form-input>
          <b-form-invalid-feedback :state="validationContato">
            Your Contato must be xxxxxxxxxxx.
          </b-form-invalid-feedback>
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
              :state="validationEndereco"
              required
          ></b-form-input>
          <b-form-invalid-feedback :state="validationEndereco">
            Your Endereço must be 1-254 characters long.
          </b-form-invalid-feedback>
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
              :state="validationNumero"
              required
          ></b-form-input>
          <b-form-invalid-feedback :state="validationNumero">
            Your Número must be 1-254 characters long.
          </b-form-invalid-feedback>
        </b-form-group>
        <b-button
            class="mt-2"
            type="reset"
            variant="warning"
            @click="reset"
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
  VBTooltip,
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
  directives:{
    'b-tooltip': VBTooltip
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
      edit: false,
      supplierID: null,
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
      const value = this.formatCpfCnpj(this.supplier.cpf_cnpj)
      const isCpf = value.length === 11
      const isCnpj = value.length === 14

      return isCpf || isCnpj
    },
    validationNomeFantansia() {
      return this.supplier.nome_fantasia.length > 0 && this.supplier.nome_fantasia.length <= 255
    },
    validationRazaoSocial() {
      return this.supplier.razao_social.length > 0 && this.supplier.razao_social.length <= 255
    },
    validationContato() {
      return this.supplier.contato.length > 0 && this.supplier.contato.length <= 255
    },
    validationEndereco() {
      return this.supplier.endereco.length > 0 && this.supplier.endereco.length <= 255
    },
    validationNumero() {
      return this.supplier.numero.length > 0 && this.supplier.numero.length <= 255
    },
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
      this.reset()
      this.showForm = false
      this.$nextTick(() => {
        this.showForm = true
      })
    },
    formatCpfCnpj(cpfCnpj) {
      return cpfCnpj.replace(/[^\d]+/g, '')
    },
    formatPhone(phone) {
      return phone.replace(/\D/g, "")
    },
    searchSupplier(){
      const formatedCpfCnpj = this.formatCpfCnpj(this.supplier.cpf_cnpj)
      axios
          .get(`/suppliers/services/${formatedCpfCnpj}`)
          .then(res => {
            const response = res.data[0]
            this.supplier.nome_fantasia = response.nome_fantasia
            this.supplier.razao_social = response.razao_social
            this.supplier.contato = response.ddd_telefone_1
            this.supplier.endereco = response.logradouro
            this.supplier.numero = response.numero
          })
          .catch(error => {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: `Algo deu errado: ${error.response.data[0].message} ou não encontrado`,
            })
          })
    },
    reset(){
      this.supplier.cpf_cnpj = ''
      this.supplier.nome_fantasia = ''
      this.supplier.razao_social = ''
      this.supplier.contato = ''
      this.supplier.endereco = ''
      this.supplier.numero = ''
    },
    storeSupplier() {
      const body = this.getSuppliers()
      axios
          .post('/suppliers',body)
          .then(() => {
            this.reset()
            this.isBusy = true
            this.getSuppliers()
            Swal.fire({
              icon: "success",
              title: "New supplier add.",
              showConfirmButton: false,
              timer: 1500
            });
          })
          .catch(error => {
            const errorMessage = this.FormatMessageError(error.response.data.errors)
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
          })
    },
    FormatMessageError(errors){
      let errorMessage = "Erro(s) encontrado(s):\n"
      for (const field in errors) {
        if (Object.prototype.hasOwnProperty.call(errors, field)) {
          errorMessage += `${errors[field][0]}\n`
        }
      }
      return errorMessage
    },
    editSupplier(item){
      this.edit = true
      this.supplierID = item.id
      this.supplier = item
      this.$bvModal.show('supplier')
    },
    updateSupplier(){
      const bodySupplier = this.getBodySupplier()
      axios
          .put(`/suppliers/${this.supplierID}`, bodySupplier)
          .then(() => {
            this.reset()
            this.isBusy = true
            this.edit = false
            this.supplierID = null
            this.getSuppliers()
            Swal.fire({
              icon: "success",
              title: "Supplier updated.",
              showConfirmButton: false,
              timer: 1500
            });
          })
          .catch(error => {
            const errorMessage = this.FormatMessageError(error.response.data.errors)
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
          })
    },
    getBodySupplier(){
      return {
        cpf_cnpj: this.formatCpfCnpj(this.supplier.cpf_cnpj),
        nome_fantasia: this.supplier.nome_fantasia,
        razao_social:this.supplier.razao_social,
        contato: this.formatPhone(this.supplier.contato),
        endereco: this.supplier.endereco,
        numero:this.supplier.numero,
      }
    },
  },
}
</script>

<style scoped>

</style>
