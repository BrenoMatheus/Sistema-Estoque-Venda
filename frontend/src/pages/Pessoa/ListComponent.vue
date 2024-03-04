<template>
  <DashboardComponent>
    <template v-slot:slot-pages>
      <div class="flex justify-center items-center text-gray-700 dark:text-white">
        <div class="w-full p-4 sm:p-6 md:p-8 dark:bg-gray-800">
          <h5
            class="md:text-2xl text-xl font-medium text-gray-900 dark:text-white text-center border-b-2 mb-4 pb-2 border-gray-900"
          >
            Pessoas
          </h5>
          <div class="flex justify-center">
            <button
              type="submit"
              class="w-30 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center "
              @click="cadastrar()"
            >
              Cadastrar
            </button>
          </div>

          <div class="mb-4 flex pt-4 items-center pl-2">
            <div
              class="w-[290px] md:w-[400px] flex rounded border border-gray-300 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40"
            >
              <div class="">
                <input
                  type="text"
                  v-model="searchQuery"
                  class="md:py-3 md:px-3 py-1 px-1 w-[260px] md:w-[360px] dark:bg-gray-600"
                  placeholder="Pesquisar..."
                  @input="handleFilterChange"
                />
              </div>
              <div class="w-[40px]">
                <span class="float-end md:py-3 md:px-3 py-1 px-1 bg-slate-300 dark:bg-gray-700">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </span>
              </div>
            </div>
          </div>

          <div class="flex flex-wrap items-center justify-between mb-4">
            <div class="mb-4 w-full md:w-1/4">
              <label
                class="block uppercase tracking-wide  text-xs font-bold mb-2"
              >
                Grupo
              </label>
              <SelectGrupoComponent @group-selected="updateSelectedGroup" />
            </div>

            <div class="mb-4 w-full md:w-1/4">
              <label
                class="block uppercase tracking-wide  text-xs font-bold mb-2"
              >
                Genero
              </label>
              <select
                v-model="selectedGender"
                class="w-full md:py-2 md:px-3 py-1 px-1 rounded border mr-4 border-gray-300 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40"
                @change="handleFilterChange"
              >
                <option value="" selected>Todos os gêneros</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="other">Outro</option>
              </select>
            </div>

            <div class="mb-4 w-full md:w-1/4">
              <label
                class="block uppercase tracking-wide  text-xs font-bold mb-2"
              >
                Idade
              </label>
              <input
                type="number"
                v-model="selectedAge"
                class="w-full md:py-2 md:px-3 py-1 px-1 rounded border mr-4 border-gray-300 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40"
                placeholder="Idade"
                @input="handleFilterChange"
              />
            </div>
          </div>

          <div class="overflow-x-auto">
            <div class="relative shadow-md sm:rounded-lg max-h-screen">
              <table
                class="w-full h-full text-sm text-left overflow-y-auto rtl:text-right text-gray-500 dark:text-white"
              >
                <thead
                  class="text-xs  uppercase bg-gray-50 dark:bg-gray-700 dark:text-white"
                >
                  <tr>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Nome</th>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Gênero</th>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Idade</th>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Grupo</th>
                    <th scope="col" class="md:px-6 md:py-3 px-4 py-1">Ação</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="!people.length">
                    <tr>
                      <td colspan="5" class="text-center">
                        Nenhum resultado encontrado.
                      </td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr
                      v-for="row in people"
                      :key="row.id"
                      class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                    >
                      <th
                        scope="row"
                        class="md:px-6 md:py-3 px-4 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ row.nome }}
                      </th>
                      <td class="md:px-6 md:py-3 px-4 py-1">{{ row.genero }}</td>
                      <td class="md:px-6 md:py-3 px-4 py-1">{{ row.idade }}</td>
                      <td class="md:px-6 md:py-3 px-4 py-1">{{ row.grupo_pessoa.nome }}</td>
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

<script setup()>
import PessoasService from '@/shared/services/api/pessoas/PessoasService';
import DashboardComponent from '../Dashboard/DashboardComponent';
import SelectGrupoComponent from './components/SelectGrupoComponent';

export default {
  name: 'PeopleListComponent',
  components: {
    DashboardComponent,
    SelectGrupoComponent,
  },
  data() {
    return {
      searchQuery: '',
      selectedGroup: '',
      selectedGender: '',
      handlePages: '',
      selectedAge: '',
      people: [],
      arrayPage: [],
      paginate: {},
      minSearchLength: 3,
      currentPage: 1,
      itemsPerPage: 10,
    };
  },
  computed: {},
  methods: {
    editar(id) {
      this.$router.push(`/pessoa/detalhes/${id}`);
    },
    cadastrar() {
      this.$router.push(`/pessoa/detalhes/nova`);
    },
    async remover(id) {
      try {
        await PessoasService.remover(id);
        console.log('Pessoa removida com sucesso!');
        this.getAll();
      } catch (error) {
        console.error('Erro ao remover pessoa:', error);
      }
    },
    async getAll() {
      try {
        const params = this.buildParams();
        const response = await PessoasService.getAll(params);
        this.$router.push({ path: `/pessoa`, query: params });
        this.people = response.data;
        this.paginate = response.last_page;
        if (this.paginate > 1) {
          this.arrayPage = this.arrayPages(this.paginate);
        }
      } catch (error) {
        console.error('Erro ao obter pessoas', error);
        this.people = [];
        this.paginate = [];
      }
    },

    shouldApplyFilter() {
      return (
        this.searchQuery.length >= this.minSearchLength ||
        this.selectedGroup ||
        this.selectedGender ||
        this.selectedGender ||
        this.selectedAge
      );
    },

    buildParams() {
      const params = {};
      if (this.selectedGroup) {
        params.grupo_id = this.selectedGroup;
      }
      if (this.selectedGender) {
        params.genero = this.selectedGender;
      }
      if (this.searchQuery.length >= this.minSearchLength) {
        params.nome = this.searchQuery;
      }
      if (this.selectedAge) {
        params.idade = this.selectedAge;
      }
      if (this.handlePages) {
        params.page = this.handlePages;
      }
      return params;
    },

    updateSelectedGroup(groupId) {
      this.selectedGroup = groupId;
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
    searchQuery() {
      if (this.shouldApplyFilter()) {
        this.getAll();
      }
    },
    selectedGroup() {
      if (this.shouldApplyFilter()) {
        this.getAll();
      }
    },
    selectedGender() {
      if (this.shouldApplyFilter()) {
        this.getAll();
      }
    },
    selectedAge() {
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