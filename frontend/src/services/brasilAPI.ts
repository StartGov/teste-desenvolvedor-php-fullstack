import axios from 'axios'

const apiCNPJ = axios.create({
  baseURL: 'https://brasilapi.com.br/api/cnpj/v1/',
  headers: {
    Accept: 'application/json',
  },
})

export default apiCNPJ
