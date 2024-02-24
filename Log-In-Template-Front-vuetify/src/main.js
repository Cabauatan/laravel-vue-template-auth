import { createApp } from "vue";
import { createPinia } from "pinia";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import VueApexCharts from "vue3-apexcharts";
import "@mdi/font/css/materialdesignicons.css";

import App from "./layout/App.vue";
import router from "./router";
import "vue3-toastify/dist/index.css";

import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
const vuetify = createVuetify({
  theme: {
    themes: {
      light: {
        dark: false,
        colors: {
          primary: "#3f51b5",
          secondary: "#2196f3",
          accent: "#ffeb3b",
          error: "#f44336",
          warning: "#ff9800",
          info: "#00bcd4",
          success: "#4caf50",
        },
      },
    },
  },
  components,
  directives,
  icons: {
    defaultSet: "mdi", // This is already the default value - only for display purposes
  },
});
const app = createApp(App);
app.use(VueApexCharts);
app.use(createPinia());
app.use(router);
app.use(vuetify);
app.mount("#app");
