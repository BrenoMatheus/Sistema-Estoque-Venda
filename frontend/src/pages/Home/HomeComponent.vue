<template>
  <DashboardComponent>
    <template v-slot:slot-pages>
      <div class="w-full dark:bg-gray-950 bg-gray-100">
        <div class="w-full flex justify-center items-center md:text-xl text-lg font-bold">
          <div class="w-full">
            <button @click="mostrarDiv('compra')" :class="{ 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-white': divAtual === 'compra', 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-400': divAtual !== 'compra' }" class="w-full p-2 md:p-4">
              Compra
            </button>
          </div>
          <div class="w-full">
            <button @click="mostrarDiv('venda')" :class="{ 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-white': divAtual === 'venda', 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-400': divAtual !== 'venda' }" class="w-full p-2 md:p-4">
              Venda
            </button>
          </div>
        </div>

        <div class="flex w-full p-4 sm:p-6 md:p-6 dark:bg-gray-800">
          <div v-if="divAtual === 'compra'" class="w-full">
            <DashboardBuyComponent/>
          </div>
          <div v-if="divAtual === 'venda'" class="w-full">
            <DashboardSaleComponent/>
          </div>
        </div>
      </div>
    </template>
  </DashboardComponent>
</template>

<script>
import DashboardComponent from '../Dashboard/DashboardComponent.vue';
import DashboardBuyComponent from './components/Compra/DashboardBuyComponent.vue';
import DashboardSaleComponent from './components/Venda/DashboardSaleComponent.vue';

export default {
  name:'HomeComponent',
  components: {
    DashboardComponent,
    DashboardBuyComponent,
    DashboardSaleComponent,
  },
  data() {
    return {
      divAtual: 'venda',
    };
  },
  methods: {
    mostrarDiv(divNome) {
      this.divAtual = divNome;
    },
  },
};
</script>
