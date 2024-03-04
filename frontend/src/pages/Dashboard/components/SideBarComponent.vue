<template>
  <div>
    <div class="lg:hidden">
      <!-- Botão para abrir o modal -->
      <button @click="showModal = !showModal" class="fixed sm:top-3 top-2 sm:left-4 left-2 z-50 bg-gray-900 text-white p-2 rounded-full">
        <i class="fa fa-bars text-xl"></i>
      </button>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="lg:visible fixed inset-0 lg:w-[220px] z-50 bg-gray-900 bg-opacity-75 flex justify-center items-center">
      <div class="bg-gray-900 w-[220px] h-screen text-white absolute left-0 top-0 ">
        <!-- Conteúdo do modal -->
        <div class="w-full flex justify-center p-4 items-center">
          <div class="mr-2">
            <span class="w-14 h-14 rounded-full flex bg-gray-300 justify-center items-center"><i class="fa fa-user text-4xl"></i></span>
          </div>
          <div>
            <p class="m-0">Joao Gomes</p>
            <span class="text-xs">online</span>
          </div>
        </div>
        <div class="flex-col text-center pt-4">
          <ul>
            <li class="p-2 hover:bg-slate-700 hover:text-lg"><router-link :to="{name: 'home'}"><i class="fa fa-house text-md pr-1"></i> Inicio</router-link></li>
            <li class="p-2 hover:bg-slate-700 hover:text-lg"><router-link :to="{name: 'pessoaLista'}"><i class="fa fa-user pr-1"></i> Pessoa</router-link></li>
            <li class="p-2 hover:bg-slate-700 hover:text-lg"><router-link :to="{name: 'produtoLista'}"><i class="fa fa-box pr-1"></i> Produto</router-link></li>
            <li class="p-2 hover:bg-slate-700 hover:text-lg"><router-link :to="{name: 'vendaLista'}"><i class="fa fa-shop pr-1"></i> Venda</router-link></li>
            <li class="p-2 hover:bg-slate-700 hover:text-lg"><router-link :to="{name: 'compraLista'}"><i class="fa fa-bag-shopping pr-1"></i> Compra</router-link></li>
          </ul>
        </div>
        <!-- Botão para fechar o modal -->
      </div>
      <div class="w-full h-full">

        <button @click="showModal = false" class="w-full h-full lg:h-0 lg:w-0"></button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  nome: 'SideBarComponent',
  data() {
    return {
      showModal: true
    };
  },

};
</script>

<style>
/* Estilos para esconder o modal em telas maiores que md */

</style>
