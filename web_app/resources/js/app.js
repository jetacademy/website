import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'; // Correct path to App.vue
import router from './router'; // Correct path to router/index.js
import i18n from './i18n';

const app = createApp(App);

app.use(router);
app.use(i18n);

app.mount('#app');
