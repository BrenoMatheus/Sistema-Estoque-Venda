<template>
  <div class="pt-6">
    <h5 class="md:text-xl text-sm font-bold pb-2">Compras por Fornecedor</h5>
    <Bar
      v-if="dataLoaded"
      id="my-chart-id"
      :key="componentKey"
      :options="chartOptions"
      :data="chartData"
    />
    <div v-else>
      <p>Carregando dados...</p>
    </div>
  </div>
</template>
<script>
import ComprasService from '@/shared/services/api/compras/ComprasService';
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

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

export default {
  props: [ 'filter'],
  emits: ['update:modelValue'],

  name: 'BarChart',
  components: { Bar },
  data() {
    return {
      componentKey: 0,
      loading: false,
      dataLoaded: false,
      chartData: {
        labels: [],
        datasets: [
          {
            label: 'Total de compras por Fornecedor',
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
    getRandomColor() {
      const randomColor = Math.floor(Math.random() * 16777215).toString(16);
      return '#' + randomColor.padStart(6, '0');
    },
    async getAll() {
      try {
        let params = { all: '0', agrupar_fornecedor: '1' };
        
        if (this.filter !== null && Object.keys(this.filter).length > 0) {

          switch (true) {
            case this.filter.ord_data !== undefined:
              delete this.filter.ord_data;
             
            case this.filter.ord_valor !== undefined:
            this.filter.ord_mes_valor = this.filter.ord_valor;
              delete this.filter.ord_valor;
              
              default:
                params = { all: '0', agrupar_fornecedor: '1', ...this.filter };
                break;
          }
        }

        this.loading = true;
        const response = await ComprasService.getAll(params);
        console.log(response)
        this.chartData.labels = [];
        this.chartData.datasets[0].data = [];

        for (let item of response) {
          this.chartData.labels.push(item.pessoa.nome);
          this.chartData.datasets[0].data.push(
            parseFloat(item.total_preco.replace(',', '.'))
          );
          this.chartData.datasets[0].backgroundColor.push(this.getRandomColor());

          this.componentKey++;
        }

        this.dataLoaded = true;
      } catch (error) {
        this.chartData.labels = [];
        this.chartData.datasets[0].data = [''];
        this.componentKey++;
        console.error('Erro ao obter compras:', error);
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>