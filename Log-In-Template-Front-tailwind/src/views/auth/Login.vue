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
  <div></div>
</template>
