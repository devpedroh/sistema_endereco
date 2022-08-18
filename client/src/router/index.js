import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView'
import CepView from '../views/CepView'

import AdminUserView from '../views/Admin/AdminUserView'
import AdminCepView from '../views/Admin/AdminCepView'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/ceps/find/:search',
    name: 'cep',
    component: CepView
  },

  {
    path: '/admin/users',
    name: 'adminUsers',
    component: AdminUserView
  },
  {
    path: '/admin/ceps',
    name: 'adminCeps',
    component: AdminCepView
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
