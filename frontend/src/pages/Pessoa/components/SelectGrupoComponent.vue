<template>
    <div class="w-full">
      <select
        v-model="selectedGroup"
        class="w-full md:py-2 md:px-3 py-1 px-1 rounded mr-4 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40 border-2"
        @change="handleFilterChange"
      >
        <option value="" selected>Todos os grupos</option>
        <option
          v-for="group in groups"
          :key="group.id"
          :value="group.id"
        >
          {{ group.nome }}
        </option>
      </select>
    </div>
  </template>
  
  <script>
  import grupoPessoaService from '@/shared/services/api/grupoPessoa/grupoPessoaService';
  
  export default {
    data() {
      return {
        selectedGroup: '',
        groups: [],
        loading: false
      };
    },
    methods: {
      async getAll() {
        try {
          this.loading = true;
          const response = await grupoPessoaService.getAll();
          this.groups = response; 
        } catch (error) {
          console.error('Erro ao obter grupos:', error);
        } finally {
          this.loading = false;
        }
      },
      handleFilterChange() {
    this.$emit('group-selected', this.selectedGroup);
  }
    
    },
    mounted() {
      this.getAll();
    }
  };
  </script>
  shared/api/grupoPessoa/grupoPessoaServiceshared/services/api/grupoPessoa/grupoPessoaService