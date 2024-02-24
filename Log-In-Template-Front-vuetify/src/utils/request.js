import axios from "axios";
import router from "@/router";
import { useAuthStore } from "@/stores/authStore.js";

const service = axios.create({
  baseURL: "http://127.0.0.1:8000/api/",
  // baseURL: "http://192.168.8.10:8000/api",
  timeout: 100000, // Request timeout
  headers: {
    "Content-type": "application/json",
    Accept: "application/json",
  },
});

service.interceptors.request.use(
  (config) => {
    const authStore = useAuthStore();
    let token = authStore.get_authorization;
    if (token) {
      config.headers["Authorization"] = "Bearer " + token; // Set JWT token
    }
    // console.log(config); // for debug

    return config;
  },
  (error) => {
    // Do something with request error
    // console.log(error); // for debug
    Promise.reject(error);
  }
);
service.interceptors.response.use(
  (response) => {
    // console.log(response.data);
    return response.data;
  },
  (error) => {
    // const $toast = useToast();
    console.log(error); // for debug

    switch (error.response.status) {
      case 200:
        console.log("OK");
        break;
      case 401:
        const authStore = useAuthStore();
        authStore.clear();
        router.push("/login");
        break;
      case 404:
        console.log("Not found");
        break;
      case 419:
        console.log("Session expired");
        break;
      case 500:
        console.log("Internal Server Error");
        break;
      case 503:
        console.log("Down for maintenance");
        break;
      default:
        return Promise.reject(error);
    }

    return Promise.reject(error);
  }
);

export default service;
