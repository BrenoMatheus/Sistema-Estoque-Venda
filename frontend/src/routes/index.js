import { createRouter, createWebHashHistory } from 'vue-router';
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';


import LoginComponent from '../pages/Login/LoginComponent.vue';
import HomeComponent from '../pages/Home/HomeComponent.vue';
import PeopleoDetailComponent from '../pages/Pessoa/DetailComponent';
import PeopleListComponent from '../pages/Pessoa/ListComponent';
import ProductDetailComponent from '../pages/Produto/DetailComponent';
import ProductListComponent from '../pages/Produto/ListComponent';
import SaleDetailComponent from '../pages/Venda/DetailComponent';
import SaleListComponent from '../pages/Venda/ListComponent';
import BuyDetailComponent from '../pages/Compra/DetailComponent';
import BuyListComponent from '../pages/Compra/ListComponent';


const routes = [
  { path: '/', name:'login', component: LoginComponent },
  { path: '/home', name:'home', component: HomeComponent },
  { path: '/pessoa', name:'pessoaLista', component: PeopleListComponent },
  { path: '/pessoa/detalhes/:id', name:'pessoaDetalhe', component: PeopleoDetailComponent },
  { path: '/produto', name:'produtoLista', component: ProductListComponent },
  { path: '/produto/detalhes/:id', name:'produtoDetalhe', component: ProductDetailComponent },
  { path: '/venda', name:'vendaLista', component: SaleListComponent },
  { path: '/venda/detalhes/:id', name:'vendaDetalhe', component: SaleDetailComponent },
  { path: '/compra', name:'compraLista', component: BuyListComponent },
  { path: '/compra/detalhes/:id', name:'compraDetalhe', component: BuyDetailComponent },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
