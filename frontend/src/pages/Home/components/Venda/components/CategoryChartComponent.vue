<template>
  <div class="pt-6 w-full">
    <div class="flex-col md:flex-row flex">
      <div class="p-4 w-full md:w-1/2" v-if="dataLoaded">
        <h5 class="md:text-xl text-sm font-bold pb-2">Vendas por Marca</h5>
        <Bar
          id="vendaMarca"
          :key="componentKey"
          :options="chartOptions"
          :data="ChartMarca"
        />
      </div>
      <div v-else>
        <p>Carregando dados...</p>
      </div>
      <div class="p-4 w-full md:w-1/2" v-if="dataLoaded">
        <h5 class="md:text-xl text-sm font-bold pb-2">Vendas por Grupo</h5>
        <Bar
          :key="componentKey"
          id="vendaGrupo"
          :options="chartOptions"
          :data="ChartGrupo"
        />
      </div>
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

export default {
  props: ['filter'],

  name: 'BarChart',
  components: { Bar },
  data() {
    return {
      marcas: [],
      grupos: [],
      componentKey: 0,
      loading: false,
      dataLoaded: false,

      ChartMarca: {
        labels: [],
        datasets: [
          {
            label: 'Total de vendas por marca',
            backgroundColor: '#228B22',
            data: [],
          },
        ],
      },

      ChartGrupo: {
        labels: [],
        datasets: [
          {
            label: 'Total de vendas por grupo',
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
        const vendas = await VendasService.getAll(params);

        const vendasPorMarca = {};
        const vendasPorGrupo = {};

        for (const venda of vendas) {
          const marcaNome = venda.produto.marca.nome;
          const marcaVenda = parseFloat(venda.total_preco);
          const grupoNome = venda.produto.grupo_produto.nome;
          const grupoVenda = parseFloat(venda.total_preco);

          vendasPorMarca[marcaNome] =
            (vendasPorMarca[marcaNome] || 0) + marcaVenda;
          vendasPorGrupo[grupoNome] =
            (vendasPorGrupo[grupoNome] || 0) + grupoVenda;
        }

        this.ChartMarca.labels = Object.keys(vendasPorMarca);
        this.ChartMarca.datasets[0].data = Object.values(vendasPorMarca);

        this.ChartGrupo.labels = Object.keys(vendasPorGrupo);
        this.ChartGrupo.datasets[0].data = Object.values(vendasPorGrupo);
        this.componentKey++;

        this.dataLoaded = true;
      } catch (error) {
        this.ChartGrupo.labels = [];
        this.ChartGrupo.datasets[0].data = [''];
        this.ChartMarca.labels = [];
        this.ChartMarca.datasets[0].data = [];
        this.componentKey++;
        console.error('Erro ao obter vendas:', error);
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
