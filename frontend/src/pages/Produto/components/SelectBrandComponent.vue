<template>
  <select
    v-model="selectedBrand"
    @change="emitBrand"
    class="md:py-2 md:px-3 py-1 px-1 w-full rounded mr-4 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40 border-2 border-gray-300"
  >
    <option value="" selected>Todos as marcas</option>
    <option v-for="marca in marcas" :key="marca.id" :value="marca.id">
      {{ marca.nome }}
    </option>
  </select>
</template>

<script>
import marcaService from '@/shared/services/api/marca/marcaService';

export default {
  props: ['modelValue', 'initialGroup'],
  emits: ['update:modelValue'],

  data() {
    return {
      selectedBrand: this.modelValue,
      marcas: [],
      loading: false,
    };
  },
  watch: {
    modelValue(newValue) {
      this.selectedBrand = newValue;
    },
    selectedBrand(newValue) {
      this.$emit('update:modelValue', newValue);
    },
  },
  methods: {
    async getAll() {
      try {
        this.loading = true;
        const response = await marcaService.getAll();
        this.marcas = response;
      } catch (error) {
        console.error('Erro ao obter marcas:', error);
      } finally {
        this.loading = false;
      }
    },
    emitBrand() {
      this.$emit('update:modelValue', this.selectedBrand);
      this.$emit('brand-selected', this.selectedBrand);
    }
  },
  mounted() {
    if (!this.initialGroup) {
      this.getAll();
    }
  },
};
</script>