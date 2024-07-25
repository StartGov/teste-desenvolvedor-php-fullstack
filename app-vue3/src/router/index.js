import { createRouter, createWebHistory } from 'vue-router'
import IndexView from '../views/IndexView.vue'
import RegisterSupplier from '../views/RegisterSupplier.vue'
import EditSupplier from '../views/EditSupplier.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'index',
      component: IndexView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterSupplier
    },
    {
      path: '/edit/:id',
      name: 'edit',
      component: EditSupplier
    }
  ]
})

export default router
