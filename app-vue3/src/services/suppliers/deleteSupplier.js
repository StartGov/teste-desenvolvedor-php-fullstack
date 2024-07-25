import router from '@/router'
import store from "@/store";
import axios from 'axios'

export default async function deleteSupplier(id) {
  return await axios
    .delete(`${import.meta.env.VITE_API_ENDPOINT_SUPPLIERS}/${id}`)
    .then((response) => {
      router.push('/')
      store.dispatch("setMessage", "Fornecedor excluido com sucesso!");
      return response
    })
    .catch((error) => {
      router.push('/')
      return store.dispatch("setMessage", error.response.data.message);
    })
}
