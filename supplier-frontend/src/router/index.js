import { createRouter, createWebHistory } from 'vue-router'
import SupplierIndex from '../views/SupplierIndex.vue'
import SupplierCreate from '../views/SupplierCreate.vue'

const routes = [
  { path: '/', component: SupplierIndex },
  { path: '/create', component: SupplierCreate },
  { path: '/edit/:id', component: SupplierCreate, props: true }
]

export default createRouter({
  history: createWebHistory(),
  routes
})
