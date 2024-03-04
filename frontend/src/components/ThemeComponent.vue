<template>
    <div class="flex duration-100 rounded-lg">
      <button
        @click="setTheme('dark')"
        :class="{ 'invisible': theme === 'dark' }"
        class="w-8 h-8 leading-9 text-xl rounded-full m-1"
      >
        <span>
          <i class="fa-solid fa-moon"></i>
        </span>
      </button>
      <button
        @click="setTheme('light')"
        :class="{ 'invisible': theme === 'light' }"
        class="w-8 h-8 leading-9 text-xl rounded-full m-1"
      >
        <span>
          <i class="fa-regular fa-sun"></i>
        </span>
      </button>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        theme: 'dark',
      };
    },
    mounted() {
      this.applyTheme();
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', this.onWindowMatch);
    },
    beforeDestroy() {
      window.matchMedia('(prefers-color-scheme: dark)').removeEventListener('change', this.onWindowMatch);
    },
    methods: {
      onWindowMatch(event) {
        const newTheme = event.matches ? 'dark' : 'light';
        this.setTheme(newTheme);
      },
      applyTheme() {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
          document.documentElement.classList.add('dark');
          this.theme = 'dark';
        } else {
          document.documentElement.classList.remove('dark');
          this.theme = 'light';
        }
      },
      setTheme(theme) {
        this.theme = theme;
        switch (theme) {
          case 'dark':
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            break;
          case 'light':
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            break;
          default:
            localStorage.removeItem('theme');
            break;
        }
      },
    },
  };
  </script>