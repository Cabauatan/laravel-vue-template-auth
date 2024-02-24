<script setup>
import { onMounted, ref } from "vue";
import { useAuthStore } from "@/stores/authStore.js";
import router from "@/router";

const userStore = useAuthStore();
const loading = ref(false);
const snackbar = ref(false);
const text = ref(null);
const rules = ref({
  email: [(v) => !!v || "Enter your email or Employee ID"],
  password: [(v) => !!v || "Enter your email password"],
});

const form = ref({
  email: "",
  password: "",
});

onMounted(async () => {
  localStorage.removeItem("auth");
  localStorage.removeItem("route");
});

const login = async () => {
  if (form.value.email && form.value.password) {
    loading.value = true;
    await userStore
      .loginUser(form.value)
      .then((e) => {
        console.log(e);
        snackbar.value = true;
        text.value = "Successfully Login";
        setTimeout(() => router.push("/attendance/dashboard"), 500);
      })
      .catch((e) => {
        snackbar.value = true;
        text.value = e.response.data.data;
        loading.value = false;
      });
  }
};
</script>
<template>
  <v-sheet
    class="bg-deep-purple-100 pa-12 justify-space-between justify-center"
    rounded
    style="height: 100%"
  >
    <br /><br /><br /><br /><br /><br /><br /><br />
    <v-card class="mx-auto px-6 py-8 mb-10" max-width="344">
      <v-img
        class="mx-15 justify-space-between mb-10"
        :src="'/CentralOneLogo.png'"
        max-height="100"
        max-width="200"
        contain
      ></v-img>

      <v-form validate-on="submit lazy" @submit.prevent="login">
        <v-text-field
          v-model="form.email"
          class="mb-2"
          :rules="rules.email"
          :loading="loading"
          :disabled="loading"
          clearable
          density="compact"
          variant="underlined"
          label="Employee ID"
        ></v-text-field>

        <v-text-field
          v-model="form.password"
          type="password"
          :rules="rules.password"
          :loading="loading"
          :disabled="loading"
          clearable
          density="compact"
          variant="underlined"
          label="Password"
          placeholder="Enter your password"
        ></v-text-field>

        <br />

        <v-btn
          block
          color="success"
          size="large"
          type="submit"
          variant="elevated"
          :loading="loading"
          :disabled="loading"
        >
          Sign In
        </v-btn>
      </v-form>

      <br />
    </v-card>
    <br />
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
  </v-sheet>
  <v-snackbar v-model="snackbar" :timeout="2000">
    <div align="center">{{ text }}</div>
  </v-snackbar>
</template>
