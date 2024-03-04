<template>
  <DashboardComponent>
    <template v-slot:slot-pages>
  
      <!-- Formulário de Cadastro de Pessoa -->
      <div class="flex justify-center items-center  text-gray-700 dark:text-white ">
        <div class="w-full p-4 sm:p-6 md:p-8 dark:bg-gray-800">
          <h5
            class="text-xl font-medium text-gray-900 dark:text-white text-center border-b-2 mb-4 pb-4 border-gray-900"
          >
            Cadastro de Pessoa
          </h5>

          <form ref="{formRef}" @submit.prevent="handleSave" class="p-2">
            <!-- Nome -->
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label
                  for="nome"
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                  >Nome</label
                >
                <input
                  v-model="formData.nome"
                  :class="{ 'invalid-input': triedToSubmit && !nomeFilled }"
                  class="appearance-none block w-full bg-gray-200 dark:bg-gray-500 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="nome"
                  type="text"
                  placeholder="Seu nome Completo"
                />
              </div>
              <!-- Idade -->
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label
                  for="idade"
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                  >Idade</label
                >
                <input
                  v-model="formData.idade"
                  :class="{ 'invalid-input': triedToSubmit && !idadeFilled }"
                  class="appearance-none block w-full bg-gray-200 dark:bg-gray-500  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="idade"
                  type="number"
                  placeholder="Sua idade"
                />
              </div>
            </div>
            <!-- Email -->
              <div class="w-full mb-6 md:mb-0">
                <label
                  for="email"
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                  >Email</label
                >
                <input
                  v-model="formData.email"
                  :class="{ 'invalid-input': triedToSubmit && !emailFilled }"
                  class="appearance-none block w-full bg-gray-200 dark:bg-gray-500  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  type="email"
                  name="email"
                  id="email"
                  placeholder="Email"
                />
              </div> 
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full md:w-1/2 px-3">
                <label
                  for="senha"
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                  >Senha</label
                >
                <input
                  v-model="formData.password"
                  :class="{ 'invalid-input': triedToSubmit && !senhaFilled }"
                  class="appearance-none block w-full bg-gray-200 dark:bg-gray-500  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="password"
                  type="password"
                  placeholder="******************"
                />
              </div>
              <!-- Senha -->
              <div class="w-full md:w-1/2 px-3">
                <label
                  for="password_confirmation"
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                  >Confirmar senha</label
                >
                <input
                  v-model="formData.password_confirmation"
                  :class="{ 'invalid-input': triedToSubmit && !senhaFilled }"
                  class="appearance-none block w-full bg-gray-200 dark:bg-gray-500  border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="password_confirmation"
                  type="password"
                  placeholder="******************"
                />
              </div>
            </div>

            <!-- Gênero e Grupo -->
            <div class="flex flex-wrap -mx-3 mb-2">
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <!-- Gênero -->
                <label
                  for="grid-state"
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                  >Genero</label
                >
                <select
                  v-model="formData.genero"
                  :class="{ 'invalid-input': triedToSubmit && !generoFilled }"
                  class="block appearance-none w-full bg-gray-200 dark:bg-gray-500 border border-gray-200  py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-state"
                >
                  <option></option>
                  <option>Masculino</option>
                  <option>Feminino</option>
                  <option>Outro...</option>
                </select>
              </div>
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <!-- Grupo -->
                <label
                  for="grid-state"
                  class="block uppercase tracking-wide  text-xs font-bold mb-2"
                  >Grupo</label
                >
                <select
                  v-model="formData.grupo_pessoa_id"
                  :class="{
                    'invalid-input': triedToSubmit && !grupoPessoaIdFilled,
                  }"
                  class="block appearance-none w-full bg-gray-200 dark:bg-gray-500 border border-gray-200  py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-state"
                >
                  <option></option>
                  <option value="1">Fornecedor</option>
                  <option value="2">Cliente</option>
                  <option value="3">Funcionario</option>
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
    </template>
  </DashboardComponent>
</template>

<script>
import AuthService from '@/shared/services/api/auth/AuthService';
import PessoasService from '@/shared/services/api/pessoas/PessoasService';
import DashboardComponent from '../Dashboard/DashboardComponent';
import { ref, reactive, watchEffect } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default {
  name: 'PeopleDetailComponent',

  components: { DashboardComponent },

  setup() {
    const route = useRoute();
    const router = useRouter();
    const formRef = ref(null);
    const id = route.params.id || 'nova';
    const formData = reactive({
      nome: '',
      idade: '',
      email: '',
      senha: '',
      grupo_pessoa_id: '',
      genero: '',
      user_id: '',
    });
    const triedToSubmit = ref(false);

    watchEffect(() => {
      if (id !== 'nova') {
        PessoasService.getById(id).then(result => {
          if (result instanceof Error) {
            alert(result.message);
            router.push('/pessoas');
          } else {
            const { pessoa } = result;
            formData.nome = pessoa.nome;
            formData.idade = pessoa.idade;
            formData.email = pessoa.email;
            formData.senha = pessoa.senha;
            formData.grupo_pessoa_id = pessoa.grupo_pessoa_id;
            formData.genero = pessoa.genero;
          }
        });
      } else {
        formRef.value?.setData({});
      }
    });

    const handleSave = () => {
      triedToSubmit.value = true;
      if (id === 'nova') {
        AuthService.register(formData.email,formData.password, formData.password_confirmation,formData.nome).then(result => {
          if (result instanceof Error) {
            alert(result.message);
          } else {
            formData.user_id = result.id
            PessoasService.cadastrar(formData).then(result => {
              if (result instanceof Error) {
                alert(result.message);
              } else {
                router.push(`/pessoa`);
              }
            });
          }
        });
      } else {
        PessoasService.atualizar(id, {
          id: id,
          ...formData,
        }).then(result => {
          if (result instanceof Error) {
            alert(result.message);
          } else {
            router.push('/pessoa');
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