import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';

import { createRouter, createWebHashHistory } from 'vue-router';
import LoginComponent from '../pages/Login/LoginComponent.vue';
import HomeComponent from '../pages/Home/HomeComponent.vue';
import PeopleDetailComponent from '../pages/Pessoa/DetailComponent.vue';
import PeopleListComponent from '../pages/Pessoa/ListComponent.vue';
import ProductDetailComponent from '../pages/Produto/DetailComponent.vue';
import ProductListComponent from '../pages/Produto/ListComponent.vue';
import SaleDetailComponent from '../pages/Venda/DetailComponent.vue';
import SaleListComponent from '../pages/Venda/ListComponent.vue';
import BuyDetailComponent from '../pages/Compra/DetailComponent.vue';
import BuyListComponent from '../pages/Compra/ListComponent.vue';
import AuthService from '@/shared/services/api/auth/AuthService';

const routes = [
  { path: '/', name: 'login', component: LoginComponent },
  { path: '/home', name: 'home', component: HomeComponent, meta: { requiresAuth: true } },
  { path: '/pessoa', name: 'pessoaLista', component: PeopleListComponent, meta: { requiresAuth: true }},
  { path: '/pessoa/detalhes/:id', name: 'pessoaDetalhe', component: PeopleDetailComponent, meta: { requiresAuth: true } },
  { path: '/produto', name: 'produtoLista', component: ProductListComponent, meta: { requiresAuth: true }},
  { path: '/produto/detalhes/:id', name: 'produtoDetalhe', component: ProductDetailComponent, meta: { requiresAuth: true } },
  { path: '/venda', name: 'vendaLista', component: SaleListComponent, meta: { requiresAuth: true } },
  { path: '/venda/detalhes/:id', name: 'vendaDetalhe', component: SaleDetailComponent, meta: { requiresAuth: true } },
  { path: '/compra', name: 'compraLista', component: BuyListComponent, meta: { requiresAuth: true } },
  { path: '/compra/detalhes/:id', name: 'compraDetalhe', component: BuyDetailComponent, meta: { requiresAuth: true } },
];


const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isLoggedIn = AuthService.isAuthenticated();
  if (to.matched.some(record => record.meta.requiresAuth) && !isLoggedIn) {
    next({ name: 'login' });
  } else {
    next();
  }
});


export default router;