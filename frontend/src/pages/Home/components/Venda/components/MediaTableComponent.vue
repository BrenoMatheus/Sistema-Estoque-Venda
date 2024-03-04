<template>
  <div class="pt-6">
    <div v-if="dataLoaded" class="row-span-3 col-span-6 md:col-span-2 pt-4">
      <h5 class="md:text-xl text-sm font-bold pb-5">Média de tempo de venda</h5>
      <div class="overflow-x-auto">
        <div class="relative shadow-md sm:rounded-lg">
          <table
            class="w-full h-full text-sm text-left rtl:text-right text-gray-500 dark:text-white"
          >
            <thead
              class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-white"
            >
              <tr>
                <th scope="col" class="md:px-3 md:py-4 px-1 py-2">Produto</th>
                <th scope="col" class="md:px-3 md:py-4 px-1 py-2">Média em dias</th>
              </tr>
            </thead>
            <tbody>
              <template v-if="!vendaMedia.length">
                <tr>
                  <td colspan="5" class="text-center">
                    Nenhum resultado encontrado.
                  </td>
                </tr>
              </template>
              <template v-else>
                <tr
                  v-for="row in vendaMedia"
                  :key="row.produto_nome"
                  class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                >
                  <th
                    scope="row"
                    class="md:px-3 md:py-4 px-1 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                  >
                    {{ row.produto_nome ? row.produto_nome : '-' }}
                  </th>
                  <td class="md:px-3 md:py-4 px-1 py-2">
                    {{
                      row.media_tempo_venda
                        ? row.media_tempo_venda
                        : ''
                    }}
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
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

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

export default {
  name: 'MediaTableComponent',
  components: { Bar },
  data() {
    return {
      vendaMedia: [],
      loading: false,
      dataLoaded: false,
    };
  },

  methods: {
    async getAll() {
      try {
        let params = { all: '0', media_tempo: '1' };

        this.loading = true;
        const response = await VendasService.getAll(params);
        response.forEach(obj => {
          const floatMedia = parseFloat(obj.media_tempo_venda)
          obj.media_tempo_venda = floatMedia.toFixed(2);
        });
        this.vendaMedia = response;

        this.dataLoaded = true;
      } catch (error) {
        console.error('Erro ao obter vendas:', error);
      } finally {
        this.loading = false;
      }
    },
  },
  mounted() {
    this.getAll();
  },
};
</script>