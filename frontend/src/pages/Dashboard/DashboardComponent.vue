<template>
  <div class="w-full flex h-screen dark:bg-gray-950 bg-gray-100">
    <NavBarComponent/>

    <div class="dark:bg-gray-950 bg-gray-100 w-full h-screen flex">
      <div class="lg:w-[220px]">
        <SideBarComponent/>
      </div>
      
      <div style="xl:width:calc(100% - 200px);" class="w-full lg:ml-4 md:h-auto h-screen mt-14 md:mt-14 dark:bg-gray-950 bg-gray-100 ">
        <slot name="slot-pages">
        </slot>
      </div>
    </div>
  </div>
</template>

<script>
import SideBarComponent from './components/SideBarComponent';
import NavBarComponent from './components/NavBarComponent';

export default {
  name: 'DashboardComponent',

  components: {
    SideBarComponent,
    NavBarComponent,
  }
};
</script>
