<template>
  <div class="pt-6">
    <div v-if="dataLoaded" class="flex-col sm:flex md:flex-col">
      <div class="p-4">
        <h5 class="md:text-xl text-sm font-bold pb-2">Vendas por Mês</h5>
        <Bar
          id="QtdMes"
          :key="componentKey"
          :options="chartOptions"
          :data="ChartQtd"
        />
      </div>
      <div class="p-4">
        <h5 class="md:text-xl text-sm font-bold pb-2">Valor total vendido por mês</h5>
        <Bar
          id="ValorMes"
          :options="chartOptions"
          :data="ChartValor"
          :key="componentKey"
        />
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

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

const meses = [
  'Janeiro',
  'Fevereiro',
  'Março',
  'Abril',
  'Maio',
  'Junho',
  'Julho',
  'Agosto',
  'Setembro',
  'Outubro',
  'Novembro',
  'Dezembro',
];

export default {
  props: ['filter'],

  name: 'BarChart',
  components: { Bar },
  data() {
    return {
      componentKey: 0,
      loading: false,
      dataLoaded: false,

      ChartValor: {
        labels: [],
        datasets: [
          {
            label: 'Valor total por mês',
            backgroundColor: '#228B22',
            data: [],
          },
        ],
      },

      ChartQtd: {
        labels: [],
        datasets: [
          {
            label: 'Total de vendas por mês',
            backgroundColor: '#DAA520',
            data: [],
          },
        ],
      },

      chartOptions: {
        responsive: true,
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
    
    getNomeMes(numeroMes) {
      return meses[numeroMes - 1];
    },
    async getAll() {
      try {
        let params = { all: '0', agrupar_mes: '1' };

        if (this.filter !== null && Object.keys(this.filter).length > 0) {
          switch (true) {
            case this.filter.ord_data !== undefined:
              this.filter.ord_mes = this.filter.ord_data;
              delete this.filter.ord_data;

            case this.filter.ord_valor !== undefined:
              this.filter.ord_mes_valor = this.filter.ord_valor;
              delete this.filter.ord_valor;

            default:
              params = { all: '0', agrupar_mes: '1', ...this.filter };
              break;
          }
        }

        this.loading = true;
        const response = await VendasService.getAll(params);
        const currentMonth = new Date().getMonth();
        this.ChartValor.labels = [];
        this.ChartValor.datasets[0].data = [];
        this.ChartQtd.labels = [];
        this.ChartQtd.datasets[0].data = [];
        
        for (let item of response) {
          if (item.mes == currentMonth) {
            this.currentMonth = item;
            const calcTicket = item.total_preco / item.total_quantidade;
            item.ticket = calcTicket;
            this.emitVenda(item);
          }
          this.ChartValor.labels.push(this.getNomeMes(item.mes));
          this.ChartQtd.labels.push(this.getNomeMes(item.mes));
          this.ChartValor.datasets[0].data.push(
            parseFloat(item.total_preco.replace(',', '.'))
          );
          this.ChartQtd.datasets[0].data.push(item.total_quantidade);

          this.componentKey++;
        }

        this.dataLoaded = true;
      } catch (error) {
        this.emitVenda({
          total_preco: 0,
          total_quantidade: 'Não há registros',
        });
        this.ChartValor.labels = [];
        this.ChartValor.datasets[0].data = [''];
        this.ChartQtd.labels = [];
        this.ChartQtd.datasets[0].data = [];
        this.componentKey++;
        console.error('Erro ao obter vendas:', error);
      } finally {
        this.loading = false;
      }
    },
    emitVenda(currentMonth) {
      this.$emit('currentMonth', currentMonth);
    },
  },
};
</script>