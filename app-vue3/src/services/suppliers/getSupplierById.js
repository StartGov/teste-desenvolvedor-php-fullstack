import store from "@/store";
import axios from 'axios'

export default async function getSupplierById(id) {
  return await axios
    .get(`${import.meta.env.VITE_API_ENDPOINT_SUPPLIERS}/${id}`, {
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json'
      },
      withCredentials: false
    })
    .then((response) => {
      return response.data
    })
    .catch((error) => {
      return store.dispatch("setMessage", error.response.data.message);
    })
}
