import router from '@/router'
import store from "@/store";
import axios from 'axios'

export default async function updateSupplier(id, formData) {
  return await axios
    .put(`${import.meta.env.VITE_API_ENDPOINT_SUPPLIERS}/${id}`, formData)
    .then((response) => {
      router.push('/')
      store.dispatch("setMessage", "Fornecedor atualizado com sucesso!");
      return response.data
    })
    .catch((error) => {
      router.push(`/edit/${id}`)
      return store.dispatch("setMessage", error.response.data.message);
    })
}
