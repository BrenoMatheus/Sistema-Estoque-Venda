
  <template>
    <select
      v-model="selectedPeople"
      @change="emitPeople"
      class="md:py-2 md:px-3 py-1 px-1 w-full rounded mr-4 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40 border-2 border-gray-300"
    >
      <option value="" selected>Todos os pessoas</option>
      <option v-for="people in peoples" :key="people.id" :value="people.id">
        {{ people.nome }}
      </option>
    </select>
  </template>
  
  <script>
  import PessoasService from '@/shared/services/api/pessoas/PessoasService';
  export default {
    props: ['modelValue', 'initialPeople','grupoId'],
    emits: ['update:modelValue'],
  
    data() {
      return {
        selectedPeople: this.modelValue,
        peoples: [],
        loading: false,
      };
    },
  
    watch: {
      modelValue(newValue) {
        this.selectedPeople = newValue;
      },
      selectedPeople(newValue) {
        this.$emit('update:modelValue', newValue);
      },
    },
    methods: {
      async getAll() {
        try {
          const params = {all:'0', grupo_id:this.grupoId};
          this.loading = true;
          const response = await PessoasService.getAll(params);
          this.peoples = response;
        } catch (error) {
          console.error('Erro ao obter pessoas:', error);
        } finally {
          this.loading = false;
        }
      },
      emitPeople() {
        this.$emit('update:modelValue', this.selectedPeople);
        this.$emit('people-selected', this.selectedPeople);
      }
    
    },
    mounted() {
      if (!this.initialPeople) {
        this.getAll();
      }
    },
  };
  </script>