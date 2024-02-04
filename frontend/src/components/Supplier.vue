<template>
  <div>
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
    </b-table>
    <b-pagination
      v-model="currentPage"
      :total-rows="totalRows"
      :per-page="perPage"
      @input="pageChanged"
      align="center"
    />
  </div>
</template>

<script>

import {
  BTable,
  BPagination,
} from 'bootstrap-vue'
import axios from '../axios'
export default {
  components: {
    BTable,
    BPagination,
  },
  data() {
    return {
      suppliers: [],
      fields: [
        { key: 'id', label: 'ID' },
        { key: 'cpf_cnpj', label: 'CPF/CNPJ' },
      ],
      perPage: 10,
      currentPage: 1,
      totalRows: 0,
      isBusy: true,
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
