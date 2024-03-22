import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";
import VueApexCharts from "vue3-apexcharts";
import "@mdi/font/css/materialdesignicons.css";

import App from "./layout/App.vue";
import router from "./router";
import "vue3-toastify/dist/index.css";

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(VueApexCharts);

app.mount("#app");
