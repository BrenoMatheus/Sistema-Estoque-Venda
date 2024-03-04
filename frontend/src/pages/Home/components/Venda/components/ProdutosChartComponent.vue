<template>
  <div class="pt-6 w-full">
    <div v-if="dataLoaded" class="grid grid-rows-3 grid-cols-6 gap-4">

      <div class="row-span-3 col-span-6 md:col-span-4">
        <h5 class="md:text-xl text-sm font-bold pb-2">Produtos vendidos</h5>
        <Bar
          id="my-chart-id"
          :key="componentKey"
          :options="chartOptions"
          :data="chartData"
        />
      </div>

      <div class="row-span-3 col-span-6 md:col-span-2 pt-4">
        <h5 class="md:text-xl text-sm font-bold pb-5">Produtos sem venda</h5>
        <div class="overflow-x-auto">
          <div class="relative shadow-md sm:rounded-lg">
            <table
              class="w-full h-full text-sm text-left rtl:text-right text-gray-500 dark:text-white"
            >
              <thead
                class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-white"
              >
                <tr>
                  <th scope="col" class="px-6 py-3">Produto</th>
                  <th scope="col" class="px-6 py-3">Qtd</th>
                  <th scope="col" class="px-6 py-3">Preço</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="!produtos.length">
                  <tr>
                    <td colspan="5" class="text-center">
                      Nenhum resultado encontrado.
                    </td>
                  </tr>
                </template>
                <template v-else>
                  <tr
                    v-for="row in produtos"
                    :key="row.id"
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                  >
                    <th
                      scope="row"
                      class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                      {{ row.nome ? row.nome : '-' }}
                    </th>
                    <td class="px-6 py-4">
                      {{
                        row.quantidade ? row.quantidade : row.total_quantidade
                      }}
                    </td>
                    <td class="px-6 py-4">
                      {{
                        formatCurrency(row.preco ? row.preco : row.total_preco)
                      }}
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    
    </div>
    <div v-else>
      <p>Carregando dados...</p>
    </div>
  </div>
</template>
<script>
import VendasService from '@/shared/services/api/vendas/VendasService';
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js';
import ProdutosService from '@/shared/services/api/produtos/ProdutosService';

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

export default {
  props: ['filter'],
  emits: ['update:modelValue'],

  name: 'BarChart',
  components: { Bar },
  data() {
    return {
      produtos: [],
      componentKey: 0,
      loading: false,
      dataLoaded: false,
      chartData: {
        labels: [],
        datasets: [
          {
            label: 'Total de vendas por produto',
            backgroundColor: [],
            data: [],
          },
        ],
      },
      chartOptions: {
        responsive: true,
        indexAxis: 'y',
      },
    };
  },
  watch: {
    filter: {
      immediate: true,
      handler(newValue) {
        this.getAll();
      },
    },
  },
  methods: {
    formatCurrency(value) {
      const intValue = parseInt(value, 10);
      return intValue.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL',
      });
    },
    getRandomColor() {
      const randomColor = Math.floor(Math.random() * 16777215).toString(16);
      return '#' + randomColor.padStart(6, '0');
    },
    async getAll() {
      try {
        let params = { all: '0', agrupar_produto: '1' };

        if (this.filter !== null && Object.keys(this.filter).length > 0) {
          switch (true) {
            case this.filter.ord_data !== undefined:
              delete this.filter.ord_data;

            case this.filter.ord_valor !== undefined:
              this.filter.ord_mes_valor = this.filter.ord_valor;
              delete this.filter.ord_valor;

            default:
              params = { all: '0', agrupar_produto: '1', ...this.filter };
              break;
          }
        }

        this.loading = true;
        const response = await VendasService.getAll(params);

        this.chartData.labels = [];
        this.chartData.datasets[0].data = [];

        const ProdutoID = new Set();
        for (let item of response) {
          this.chartData.labels.push(item.produto.nome);
          this.chartData.datasets[0].data.push(
            parseFloat(item.total_preco.replace(',', '.'))
          );
          this.chartData.datasets[0].backgroundColor.push(
            this.getRandomColor()
          );
          this.componentKey++;

          ProdutoID.add(item.produto_id);
        }
        const Produtos = await ProdutosService.getAll({ all: '0' });

        this.produtos = Produtos.filter(product => !ProdutoID.has(product.id));

        this.dataLoaded = true;
      } catch (error) {
        this.chartData.labels = [];
        this.chartData.datasets[0].data = [''];
        this.componentKey++;
        console.error('Erro ao obter vendas:', error);
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>