import { createApp } from 'vue';
import { createPinia } from 'pinia';  // Importe o Pinia
import router from './router';
import App from './App.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import '../../public/css/app.css';

const app = createApp(App);

const pinia = createPinia();
app.use(pinia);
app.use(router);

app.mount('#app');

console.log('Vue app mounted!');
