import { createApp } from 'vue';
import router from './routes';
import App from './App.vue';
import './style.css';

/* eslint-disable no-new */
createApp(App).use(router).mount('#app');
