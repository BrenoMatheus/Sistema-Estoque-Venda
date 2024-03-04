<template>
  <div class="bg-gray-900 w-full h-14 md:h-16 p-2 pb-4 text-white fixed top-0 left-0 z-40">
  <div class="md:w-2/3 w-full pl-10 float-end ">
   <div class="flex justify-between items-center md:p-2">
    <h3 class="md:text-lg text-sm"><i class="fa fa-star"></i> Logo Marca</h3>
    <ThemeComponent/>
    <a class=" md:text-lg text-sm" href="">Sair <i class="fa fa-sign-out-alt"></i></a>
   </div>
  </div>
</div>
</template> 


<script>
import ThemeComponent from '@/components/ThemeComponent';

export default {
    nome: 'NavBarComponent',
    components: {
      ThemeComponent,
  },
    methods: {
      logout(){
        this.$router.push({name:'login'})
      }
    }
};
</script>
