<template>
  <DashboardComponent>
    <template v-slot:slot-pages>
      <div class="flex justify-center items-center text-gray-700 dark:text-white">
        <div class="w-full p-4 sm:p-6 md:p-8 dark:bg-gray-800">
          <h5
            class="text-xl font-medium text-gray-900 dark:text-white text-center border-b-2 mb-4 pb-4 border-gray-900"
          >
            Cadastro de Produto
          </h5>
          <div class="w-auto">
            <form ref="{formRef}" @submit.prevent="handleSave" class="p-2">
              <div class="flex flex-wrap -mx-3">
                <div class="w-full px-3 mb-6 md:mb-0">
                  <label
                    for="nome"
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    >Nome</label
                  >
                  <input
                    v-model="formData.nome"
                    :class="{ 'invalid-input': triedToSubmit && !nomeFilled }"
                    class="appearance-none block w-full bg-gray-200 dark:bg-gray-500  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="nome"
                    type="text"
                    placeholder="Nome do produto"
                  />
                </div>
                <div class="w-full px-3 mb-6 md:mb-0">
                  <label
                    for="descricao"
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    >Descrição</label
                  >
                  <input
                    v-model="formData.descricao"
                    :class="{ 'invalid-input': triedToSubmit && !nomeFilled }"
                    class="appearance-none block w-full bg-gray-200 dark:bg-gray-500  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="descricao"
                    type="text"
                    placeholder="Descreva o produto"
                  />
                </div>
              </div>

              <div class="flex flex-wrap -mx-3 mb-2">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    for="marca"
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    >Marca</label
                  >
                  <SelectBrandComponent v-model="formData.marca_id" />
                </div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                  <label
                    for="grid-state"
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    >Grupo</label
                  >
                  <SelectGrupoComponent
                    v-model="formData.grupo_produto_id"
                    :initialGroup="formData.grupo_produto_id"
                  />
                </div>
              </div>

              <div class="flex flex-wrap -mx-2 mb-2">
                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                  <label
                    for="quantidade"
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    >quantidade</label
                  >
                  <input
                    v-model="formData.quantidade"
                    :class="{ 'invalid-input': triedToSubmit && !idadeFilled }"
                    class="appearance-none block w-full bg-gray-200 dark:bg-gray-500  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="quantidade"
                    type="number"
                    placeholder="Quantidade de produtos"
                  />
                </div>

                <div class="w-full md:w-2/4 px-3 mb-6 md:mb-0">
                  <label
                    for="preco"
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    >preco</label
                  >
                  <input
                    v-model="formData.preco"
                    :class="{ 'invalid-input': triedToSubmit && !idadeFilled }"
                    class="appearance-none block w-full bg-gray-200 dark:bg-gray-500  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="preco"
                    type="number"
                    placeholder="Preço do produto"
                  />
                </div>

                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                  <label
                    for="status"
                    class="block uppercase tracking-wide  text-xs font-bold mb-2"
                    >Status</label
                  >
                  <select
                    v-model="formData.status"
                    :class="{ 'invalid-input': triedToSubmit && !generoFilled }"
                    class="block appearance-none w-full bg-gray-200 dark:bg-gray-500 border border-gray-200  py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="status"
                  >
                    <option value="1" selected>Ativo</option>
                    <option value="0">Inativo</option>
                  </select>
                </div>
              </div>

              <div class="pt-4">
                <button
                  type="submit"
                  class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                  <template v-if="id === 'nova'"> ok </template>
                  <template v-else> Cadastrar </template>
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
import ProdutosService from '@/shared/services/api/produtos/ProdutosService';
import DashboardComponent from '../Dashboard/DashboardComponent';
import SelectGrupoComponent from './components/SelectGrupoComponent';
import SelectBrandComponent from './components/SelectBrandComponent';
import { ref, reactive, watchEffect } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default {
  name: 'ProductDetailComponent',

  components: {
    DashboardComponent,
    SelectGrupoComponent,
    SelectBrandComponent,
  },

  setup() {
    const route = useRoute();
    const router = useRouter();
    const formRef = ref(null);
    const id = route.params.id || 'nova';
    const formData = reactive({
      nome: '',
      descricao: '',
      status: '',
      marca_id: '',
      grupo_produto_id: '',
      quantidade: '',
      preco: '',
    });
    const triedToSubmit = ref(false);

    watchEffect(() => {
      if (id !== 'nova') {
        ProdutosService.getById(id).then(result => {
          if (result instanceof Error) {
            alert(result.message);
            router.push('/produto');
          } else {
            const { produto } = result;
            formData.nome = produto.nome;
            formData.descricao = produto.descricao;
            formData.status = produto.status;
            formData.grupo_produto_id = produto.grupo_produto_id;
            formData.marca_id = produto.marca_id;
            formData.quantidade = produto.quantidade;
            formData.preco = produto.preco;
          }
        });
      } else {
        formRef.value?.setData({});
      }
    });

    const handleSave = () => {
      triedToSubmit.value = true;
      if (id === 'nova') {
        ProdutosService.cadastrar(formData).then(result => {
          if (result instanceof Error) {
            alert(result.message);
          } else {
            router.push(`/produto`);
          }
        });
      } else {
        ProdutosService.atualizar(id, {
          id: id,
          ...formData,
        }).then(result => {
          if (result instanceof Error) {
            alert(result.message);
          } else {
            router.push('/produto');
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
../../../shared/api/produtos/ProdutosService../../../shared/services/api/produtos/ProdutosService