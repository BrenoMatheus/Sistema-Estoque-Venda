
  <template>
    <select
      v-model="selectedGroup"
      @change="emitGroup"
      class="md:py-2 md:px-3 py-1 px-1 w-full rounded mr-4 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40 border-2 border-gray-300"
    >
      <option value="" selected>Todos os grupos</option>
      <option v-for="group in groups" :key="group.id" :value="group.id">
        {{ group.nome }}
      </option>
    </select>
  </template>
  
  <script>
  import grupoPessoaService from '@/shared/services/api/grupoProduto/grupoProdutoService';
  export default {
    props: ['modelValue', 'initialGroup'],
    emits: ['update:modelValue'],
  
    data() {
      return {
        selectedGroup: this.modelValue,
        groups: [],
        loading: false,
      };
    },
  
    watch: {
      modelValue(newValue) {
        this.selectedGroup = newValue;
      },
      selectedGroup(newValue) {
        this.$emit('update:modelValue', newValue);
      },
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
      emitGroup() {
        this.$emit('update:modelValue', this.selectedGroup);
        this.$emit('group-selected', this.selectedGroup);
      }
    
    },
    mounted() {
      if (!this.initialGroup) {
        this.getAll();
      }
    },
  };
  </script>