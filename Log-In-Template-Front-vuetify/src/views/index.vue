<script setup>
import { onMounted, ref } from "vue";

import router from "@/router";

onMounted(async () => {
  router.push("/login");
});
</script>
<template></template>
