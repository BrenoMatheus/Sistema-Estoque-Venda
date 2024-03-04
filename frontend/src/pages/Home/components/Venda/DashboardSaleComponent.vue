<template>
  <div class="flex justify-center items-center text-gray-700 dark:text-white ">
    <div class="w-full sm:p-6 md:p-8 dark:bg-gray-800 bg-gray-100">
      <div class="w-auto">
        <div class="flex flex-wrap items-center justify-start mb-4">
          <div class="md:px-3 md:mb-0">
            <label
              class="block uppercase tracking-wide text-xs font-bold mb-2"
              for="data"
            >
              Data Inicio
            </label>
            <input
              v-model="selectedData"
              @input="handleFilterChange"
              class="md:py-2 md:px-3 py-1 px-1 rounded border mr-4 border-gray-300 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40"
              type="date"
              id="data"
            />
          </div>

          <div class="md:px-3 md:mb-0">
            <label
              class="block uppercase tracking-wide text-xs font-bold mb-2"
              for="data_fim"
            >
              Data Fim
            </label>
            <input
              v-model="selectedDateEnd"
              @input="handleFilterChange"
              class="md:py-2 md:px-3 py-1 px-1 rounded border mr-4 border-gray-300 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40"
              id="data_fim"
              type="date"
            />
          </div>
        </div>

        <div class="flex flex-wrap items-center justify-between mb-4 md:pl-4">
          <div class="mb-4 w-full md:w-1/5">
            <label class="block uppercase tracking-wide text-xs font-bold mb-2">
              Cliente
            </label>
            <SelectPessoaComponent @people-selected="updateSelectedPeople" :grupo-id="1" />
          </div>

          <div class="mb-4 w-full md:w-1/5">
            <label class="block uppercase tracking-wide text-xs font-bold mb-2">
              Produtos
            </label>
            <SelectProdutoComponent @product-selected="updateSelectedProduct" />
          </div>

          <div class="mb-4">
            <label class="block uppercase tracking-wide text-xs font-bold mb-2">
              Ordenar Data
            </label>
            <select
              v-model="selectedOrdData"
              class="md:py-2 md:px-3 py-1 px-1 rounded border-2 border-gray-300 mr-4 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40"
              @change="handleFilterChange"
            >
              <option value="" selected>Ordenar Data</option>
              <option value="1">Crescente</option>
              <option value="0">Decrescente</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="block uppercase tracking-wide text-xs font-bold mb-2">
              Ordenar Preço
            </label>
            <select
              v-model="selectedOrdValor"
              class="md:py-2 md:px-3 py-1 px-1 rounded border-2 border-gray-300 mr-4 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40"
              @change="handleFilterChange"
            >
              <option value="" selected>Ordenar Preço</option>
              <option value="1">Crescente</option>
              <option value="0">Decrescente</option>
            </select>
          </div>
        </div>
      </div>

      <div class="flex gap-2">
        <div
          class="relative w-3/5 md:h-20 flex border-x-2 border-b-2 border-gray-500 rounded-md items-center"
        >
          <span class="absolute -left-0 -top-4 font-bold text-sm"
            >Vendas mês</span
          >
          <span class="absolute -right-0 -top-4 font-bold text-sm"
            >Valores mês</span
          >
          <div
            class="w-full h-full pr-2 bg-green-400 dark:bg-green-800 dark:text-white justify-center items-center flex"
          >
            <h3 class="md:text-2xl text-lg font-bold pl-2">
              {{ currentMonthSale ? currentMonthSale.total_quantidade : '-' }}
            </h3>
          </div>
          <div
            class="w-full h-full pl-2 bg-green-500 dark:bg-green-900 dark:text-white justify-center items-center flex"
          >
            <h3 class="md:text-2xl text-lg font-bold pr-2">
              {{
                currentMonthSale
                  ? formatCurrency(currentMonthSale.total_preco)
                  : '-'
              }}
            </h3>
          </div>
        </div>

        <div
          class="relative w-2/5 h-20 flex border-x-2 border-b-2 border-gray-500 rounded-md items-center"
        >
          <span class="absolute -left-0 -top-4 font-bold text-sm"
            >Ticket médio mês</span
          >

          <div
            class="w-full h-full bg-yellow-400 dark:bg-yellow-600 dark:text-white justify-center items-center flex float-end"
          >
            <h3 class="md:text-2xl text-lg font-bold md:pl-2">{{
                currentMonthSale
                  ? formatCurrency(currentMonthSale.ticket)
                  : '-'
              }}</h3>
          </div>
        </div>
      </div>

      <div>
        <div class=" flex-row md:flex w-full">
          <div class="w-full">
            <ClientesChartComponent :filter="filter" />
          </div>
          <div class="md:w-1/2 w-full">
            <div class="">
              <VendasChartComponent
                @currentMonth="updatecurrentMonthSale"
                :filter="filter"
              />
            </div>
          </div>
        </div>
      </div>

        <div class="flex w-full">
            <ProdutosChartComponent :filter="filter" />
        </div>

        <div class="flex w-full">
          <CategoryChartComponent :filter="filter" />
      </div>
      <div class="flex-row md:flex w-full gap-4">
        <div class="w-full md:w-1/3">
          <MediaTableComponent  />
        </div>
        <div class="w-full md:w-2/3">
          <VendasDiaChartComponent :filter="filter" />
        </div>
    </div>

  

     
    </div>
  </div>
</template>

<script>
import SelectPessoaComponent from '@/components/SelectPessoaComponent';
import SelectProdutoComponent from '@/components/SelectProdutoComponent';
import VendasChartComponent from './components/VendasChartComponent';
import ClientesChartComponent from './components/ClientesChartComponent';
import ProdutosChartComponent from './components/ProdutosChartComponent';
import CategoryChartComponent from './components/CategoryChartComponent';
import MediaTableComponent from './components/MediaTableComponent';
import VendasDiaChartComponent from './components/VendasDiaChartComponent';

export default {
  name: 'DashboardSaleComponent',
  components: {
    SelectPessoaComponent,
    SelectProdutoComponent,
    VendasChartComponent,
    ClientesChartComponent,
    ProdutosChartComponent,
    CategoryChartComponent,
    MediaTableComponent,
    VendasDiaChartComponent
  },
  data() {
    return {
      selectedPeople: '',
      filter: {},
      selectedProduct: '',
      selectedData: '',
      selectedDateEnd: '',
      selectedOrdData: '',
      selectedOrdValor: '',
      handlePages: '',
      currentMonthSale: [],
      sale: [],
      arrayPage: [],
      paginate: {},
      minSearchLength: 3,
      currentPage: 1,
      itemsPerPage: 10,
    };
  },
  computed: {},
  methods: {
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString('pt-BR');
    },
    formatCurrency(value) {
      const intValue = parseInt(value, 10);
      return intValue.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL',
      });
    },

    async getAll() {
      try {
        const params = this.buildParams();
      } catch (error) {
        console.error('Erro ao obter vendas', error);
        this.sale = [];
        this.paginate = [];
      }
    },

    shouldApplyFilter() {
      return (
        this.selectedPeople ||
        this.selectedProduct ||
        this.selectedData ||
        this.selectedDateEnd ||
        this.selectedOrdData ||
        this.selectedOrdValor 
      );
    },

    buildParams() {
      const params = {};
      if (this.selectedPeople) {
        params.pessoa_id = this.selectedPeople;
      }
      if (this.selectedProduct) {
        params.produto_id = this.selectedProduct;
      }

      if (this.selectedData) {
        params.data = this.selectedData;
      }
      if (this.selectedDateEnd) {
        params.data_fim = this.selectedDateEnd;
      }
      if (this.selectedOrdData) {
        params.ord_data = this.selectedOrdData;
      }
      if (this.selectedOrdValor) {
        params.ord_valor = this.selectedOrdValor;
      }
      
      if (this.handlePages) {
        params.page = this.handlePages;
      }
      this.filter = params;

      return params;
    },

    updateSelectedPeople(peopleId) {
      this.selectedPeople = peopleId;
    },

    updatecurrentMonthSale(props) {
      this.currentMonthSale = props;
    },

    updateSelectedProduct(productId) {
      this.selectedProduct = productId;
      this.handleFilterChange();
    },
    handleFilterChange() {
      if (this.shouldApplyFilter()) {
        this.currentPage = 1;
      } else {
        this.getAll();
      }
    },

  },
  watch: {
    selectedPeople() {
      if (this.shouldApplyFilter()) {
        this.getAll();
      }
    },
    selectedProduct() {
      if (this.shouldApplyFilter()) {
        this.getAll();
      }
    },
    selectedData() {
      if (this.shouldApplyFilter()) {
        this.getAll();
      }
    },
    selectedDateEnd() {
      if (this.shouldApplyFilter()) {
        this.getAll();
      }
    },
    selectedOrdData() {
      if (this.shouldApplyFilter()) {
        this.getAll();
      }
    },
    selectedOrdValor() {
      if (this.shouldApplyFilter()) {
        this.getAll();
      }
    },
    currentMonthSale() {
    },

  },
  
};
</script>
