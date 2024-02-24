import { defineStore } from "pinia";
import router from "@/router";

import { login, register } from "@/api/authApi.js";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    authorization: [],
    user: [],
    // roles: null,
    // permission: [],
  }),
  getters: {
    get_authorization: (state) => state.authorization,
    get_user: (state) => state.user,
    // get_roles: (state) => state.roles,
    // get_permission: (state) => state.permission,
  },
  actions: {
    async loginUser(res) {
      await login(res).then(({ data }) => {
        this.$state.authorization = data.token;
        this.$state.user = data.user;
        // this.$state.roles = data.roles[0];
        // this.$state.permission = data.permission;
      });
    },

    async register(res) {
      await register(res).then(({ data }) => {
        this.$state.user = data.user;
        // this.$state.roles = data.roles[0];
        // this.$state.permission = data.permission;
      });
    },

    check(res) {
      return this.$state.permission.includes(res);
    },

    async clear() {
      this.$state.authorization = null;
      this.$state.user = null;
      // this.$state.roles = null;
      // this.$state.permission = null;
      router.push("/login");
    },
  },

  persist: true,
});
