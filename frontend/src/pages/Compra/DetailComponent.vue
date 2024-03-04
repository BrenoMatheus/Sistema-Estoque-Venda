<template>
  <DashboardComponent>
    <template v-slot:slot-pages>
      <div class="flex justify-center items-center text-gray-700 dark:text-white">
        <div class="w-full p-4 sm:p-6 md:p-8 dark:bg-gray-800">
          <h5
            class="text-xl font-medium text-gray-900 dark:text-white text-center border-b-2 mb-4 pb-4 border-gray-900"
          >
            Cadastro de Compra
          </h5>
          <div class="w-auto">
            <form ref="{formRef}" @submit.prevent="handleSave" class="p-2">
              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    for="data"
                  >
                    Data
                  </label>
                  <input
                    v-model="formData.data"
                    class="appearance-none block text-gray-700 w-full bg-gray-200  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="data"
                    type="date"
                  />
                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-2">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    for="grid-state"
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    >Fornecedor</label
                  >
                  <SelectPessoaComponent
                    v-model="formData.pessoa_id"
                    :initialPeople="formData.pessoa_id"
                    :grupo-id="2"
                  />
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    for="grid-state"
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    >Produto</label
                  >
                  <SelectProdutoComponent
                    v-model="formData.produto_id"
                    :initialProduct="formData.produto_id"
                  />
                </div>
              </div>
              <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    for="quantidade"
                  >
                    Quantidade
                  </label>
                  <input
                    class="appearance-none block w-full text-gray-700 bg-gray-200  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="quantidade"
                    type="number"
                    v-model="formData.quantidade"
                  />
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    for="preco"
                  >
                    Preço
                  </label>
                  <input
                    v-model="formData.preco"
                    class="appearance-none block w-full text-gray-700 bg-gray-200  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="preco"
                    type="number"
                  />
                </div>
              </div>

              <div class="pt-4">
                <button
                  type="submit"
                  class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                  Cadastrar
                </button>
              </div>
              <div class="mt-4">
                <span
                  class="text-center text-sm"
                  :class="{
                    'text-green-500': sucesso,
                    'text-red-500': !sucesso && feedbackMessage,
                  }"
                  >{{ feedbackMessage }}</span
                >
              </div>
            </form>
          </div>
        </div>
      </div>
    </template>
  </DashboardComponent>
</template>

<script>
import ComprasService from '@/shared/services/api/compras/ComprasService';
import DashboardComponent from '../Dashboard/DashboardComponent';
import SelectPessoaComponent from '@/components/SelectPessoaComponent';
import SelectProdutoComponent from '@/components/SelectProdutoComponent';
import { ref, reactive, watchEffect } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default {
  name: 'BuyDetailComponent',

  components: {
    DashboardComponent,
    SelectPessoaComponent,
    SelectProdutoComponent,
  },

  setup() {
    const route = useRoute();
    const router = useRouter();
    const formRef = ref(null);
    const id = route.params.id || 'nova';
    const formData = reactive({
      data: '',
      pessoa_id: '',
      produto_id: '',
      quantidade: '',
      preco: '',
    });
    const triedToSubmit = ref(false);

    watchEffect(() => {
      if (id !== 'nova') {
        ComprasService.getById(id).then(result => {
          if (result instanceof Error) {
            alert(result.message);
            router.push('/compra');
          } else {
            formData.data = result.data;
            formData.produto_id = result.produto_id;
            formData.pessoa_id = result.pessoa_id;
            formData.quantidade = result.quantidade;
            formData.preco = result.preco;
          }
        });
      } else {
        formRef.value?.setData({});
      }
    });

    const handleSave = () => {
      triedToSubmit.value = true;
      if (id === 'nova') {
        ComprasService.cadastrar(formData).then(result => {
          if (result instanceof Error) {
            alert(result.message);
          } else {
            router.push(`/compra`);
          }
        });
      } else {
        ComprasService.atualizar(id, {
          id: id,
          ...formData,
        }).then(result => {
          if (result instanceof Error) {
            alert(result.message);
          } else {
            router.push('/compra');
          }
        });
      }
    };

    return { formRef, formData, handleSave };
  },
};
</script>

<style scoped>
.invalid-input {
  border-color: red;
}
</style>
