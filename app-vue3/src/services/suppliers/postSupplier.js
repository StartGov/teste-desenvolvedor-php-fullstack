import router from '@/router'
import store from "@/store";
import axios from 'axios'

export default async function postSupplier(formData) {
  return await axios
    .post(import.meta.env.VITE_API_ENDPOINT_SUPPLIERS, formData)
    .then((response) => {
      router.push('/')
      
      store.dispatch("setMessage", "Fornecedor criado com sucesso!");
      return response.data
    })
    .catch((error) => {
      router.push('/register')
      return store.dispatch("setMessage", error.response.data.message);
    })
}
