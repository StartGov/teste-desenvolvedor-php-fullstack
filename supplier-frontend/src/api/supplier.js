import axios from 'axios'


const api = axios.create({
  baseURL: 'http://localhost/api/suppliers'
})

export default {
  getAll(params) {
    return api.get('/', { params })
  },
  get(id) {
    return api.get(`/${id}`)
  },
  create(data) {
    return api.post('/', data)
  },
  update(id, data) {
    return api.put(`/${id}`, data)
  },
  remove(id) {
    return api.delete(`/${id}`)
  },
  fetchCNPJ(cnpj) {
    return api.get(`/fetch-cnpj/${cnpj}`)
  }
}
