<template>
  <select
    v-model="selectedProduct"
    @change="emitProduct"
    class="md:py-2 md:px-3 py-1 px-1 w-full rounded mr-4 shadow-lg bg-gray-200 shadow-indigo-500/40 dark:bg-gray-600 dark:shadow-gray-600/40 border-2 border-gray-300"
  >
    <option value="" selected>Todos as produtos</option>
    <option v-for="produto in produtos" :key="produto.id" :value="produto.id">
      {{ produto.nome }}
    </option>
  </select>
</template>

<script>
import ProdutosService from '@/shared/services/api/produtos/ProdutosService';

export default {
  props: ['modelValue', 'initialGroup'],
  emits: ['update:modelValue'],

  data() {
    return {
      selectedProduct: this.modelValue,
      produtos: [],
      loading: false,
    };
  },
  watch: {
    modelValue(newValue) {
      this.selectedProduct = newValue;
    },
    selectedProduct(newValue) {
      this.$emit('update:modelValue', newValue);
    },
  },
  methods: {
    async getAll() {
      try {
        const params = {all:'0', status:'1'};
        this.loading = true;
        const response = await ProdutosService.getAll(params);
        this.produtos = response;
      } catch (error) {
        console.error('Erro ao obter produtos:', error);
      } finally {
        this.loading = false;
      }
    },
    emitProduct() {
      this.$emit('update:modelValue', this.selectedProduct);
      this.$emit('product-selected', this.selectedProduct);
    }
  },
  mounted() {
    if (!this.initialProduct) {
      this.getAll();
    }
  },
};
</script>