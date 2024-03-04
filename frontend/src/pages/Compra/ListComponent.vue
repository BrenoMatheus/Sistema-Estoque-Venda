<template>
  <DashboardComponent>
    <template v-slot:slot-pages>
      <div class="flex justify-center items-center text-gray-700 dark:text-white">
        <div class="w-full p-4 sm:p-6 md:p-8 dark:bg-gray-800 bg-gray-100">
          <h5
            class="md:text-2xl text-xl font-medium text-gray-900 dark:text-white text-center border-b-2 mb-4 pb-2 border-gray-900"
          >
            Compras
          </h5>
          <div class="w-auto">
            <div class="flex justify-center mb-4 md:mb-2">
              <button
                type="submit"
                class="w-30 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center "
                @click="cadastrar()"
              >
                Cadastrar
              </button>
            </div>

            <div class="flex flex-wrap items-center justify-start mb-4">
              <div class="md:px-3">
                <label
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
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

              <div class="md:px-3">
                <label
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
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
                <label
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                >
                  Fornecedor
                </label>
                <SelectPessoaComponent
                  @people-selected="updateSelectedPeople"
                  :grupo-id="2"
                />
              </div>

              <div class="mb-4 w-full md:w-1/5">
                <label
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                >
                  Produtos
                </label>
                <SelectProdutoComponent
                  @product-selected="updateSelectedProduct"
                />
              </div>

              <div class="mb-4">
                <label
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                >
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
                <label
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                >
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

              <div class="mb-4">
                <label
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                >
                  Agrupar Fornecedor
                </label>
                <input
                  v-model="selectedAgrupar"
                  type="checkbox"
                  class="md:py-2 md:px-3 py-1 px-1 rounded border-2 border-gray-300 mr-4 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40"
                  @change="handleFilterChange"
                />
              </div>
            </div>
          </div>
          <div class="overflow-x-auto">
            <div class="relative shadow-md sm:rounded-lg">
              <table
                class="w-full h-full text-sm text-left rtl:text-right text-gray-500 dark:text-white"
              >
                <thead
                  class="text-xs  uppercase bg-gray-50 dark:bg-gray-700 dark:text-white"
                >
                  <tr>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Data</th>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Produto</th>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Fornecedor</th>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Qtd</th>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Preço</th>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Ação</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="!buy.length">
                    <tr>
                      <td colspan="5" class="text-center">
                        Nenhum resultado encontrado.
                      </td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr
                      v-for="row in buy"
                      :key="row.id"
                      class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                    >
                      <td class="md:px-6 md:py-3 px-4 py-1">{{ row.data ? formatDate(row.data) : '-'  }} </td>
                      <th
                        scope="row"
                        class="md:px-6 md:py-3 px-4 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ row.produto ? row.produto.nome : '-'}}
                      </th>
                      <td class="md:px-6 md:py-3 px-4 py-1">{{ row.pessoa.nome }}</td>
                      <td class="md:px-6 md:py-3 px-4 py-1">{{ row.quantidade ? row.quantidade : row.total_quantidade }}</td>
                      <td class="md:px-6 md:py-3 px-4 py-1">{{ formatCurrency( row.preco ? row.preco : row.total_preco) }}</td>
                      <td class="md:px-6 md:py-3 px-4 py-1">
                        <a
                          @click="editar(row.id)"
                          class="text-blue-600 pr-4 hover:text-white dark:text-white hover:underline hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center "
                        >
                          <i class="text-xl fa-solid fa-eye"></i>
                        </a>
                        <a
                          @click="remover(row.id)"
                          class="text-blue-600 hover:text-white dark:text-white hover:underline hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center "
                        >
                          <i class="text-xl fa-solid fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
              <div class="flex justify-center mt-4">
                <template v-if="!arrayPage.length"> </template>
                <template v-else>
                  <a
                    v-for="link in arrayPage"
                    :key="link"
                    :v-html="link"
                    @click="handlePage(link)"
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 p-4"
                    >{{ link }}</a
                  >
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </DashboardComponent>
</template>

<script>
import ComprasService from '@/shared/services/api/compras/ComprasService';
import DashboardComponent from '../Dashboard/DashboardComponent';
import SelectPessoaComponent from '@/components/SelectPessoaComponent';
import SelectProdutoComponent from '@/components/SelectProdutoComponent';

export default {
  name: 'BuyListComponent',
  components: {
    DashboardComponent,
    SelectPessoaComponent,
    SelectProdutoComponent,
  },
  data() {
    return {
      selectedPeople: '',
      selectedProduct: '',
      selectedData: '',
      selectedDateEnd: '',
      selectedOrdData: '',
      selectedOrdValor: '',
      selectedAgrupar: '',
      handlePages: '',
      buy: [],
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

    editar(id) {
      this.$router.push(`/compra/detalhes/${id}`);
    },
    cadastrar() {
      this.$router.push(`/compra/detalhes/nova`);
    },
    async remover(id) {
      try {
        await ComprasService.remover(id);
        console.log('Compra removida com sucesso!');
        this.getAll();
      } catch (error) {
        console.error('Erro ao remover compra:', error);
      }
    },
    async getAll() {
      try {
        const params = this.buildParams();
        const response = await ComprasService.getAll(params);
        this.$router.push({ path: `/compra`, query: params });
        this.buy = response.data;
        this.paginate = response.last_page;
        if (this.paginate > 1) {
          this.arrayPage = this.arrayPages(this.paginate);
        }
      } catch (error) {
        console.error('Erro ao obter compras', error);
        this.buy = [];
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
        this.selectedOrdValor ||
        this.selectedAgrupar
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
      if (this.selectedAgrupar) {
        params.agrupar_fornecedor = this.selectedAgrupar;
      }
      if (this.handlePages) {
        params.page = this.handlePages;
      }
      return params;
    },

    updateSelectedPeople(peopleId) {
      this.selectedPeople = peopleId;
      this.handleFilterChange();
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
    arrayPages(lastPage) {
      let pages = [];
      for (let i = 1; i <= lastPage; i++) {
        pages.push(i);
      }

      return pages;
    },

    handlePage(url) {
      if (url) {
        this.handlePages = url;
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
    selectedAgrupar() {
      if (this.shouldApplyFilter()) {
        this.getAll();
      }
    },

    currentPage() {
      this.getAll();
    },
  },
  mounted() {
    this.getAll();
  },
};
</script>
