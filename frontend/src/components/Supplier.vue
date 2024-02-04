<template>
  <div>
    <b-container fluid>
      <b-row>
        <b-row align-h="start">
          <b-col cols="2">
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
                ></b-form-input>

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
          <b-col cols="2">
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
      </b-row>
      <b-table
        :busy="isBusy"
        responsive
        :items="suppliers"
        :fields="fields"
        :per-page="0"
        :current-page="currentPage"
      >
        <template #table-busy>
          <div class="text-center text-danger my-2">
            <b-spinner class="align-middle"></b-spinner>
            <strong>Loading...</strong>
          </div>
        </template>

        <template #cell(actions)="row">
          {{ row.item.id}}
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
} from 'bootstrap-vue'
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
    }
  },
  computed: {
    sortOptions() {
      return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
          })
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
  },
}
</script>

<style scoped>

</style>
