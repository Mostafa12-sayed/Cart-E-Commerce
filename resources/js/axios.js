import axios from "axios";
import store from "@/store";

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || "https://cart-project.test",
  withCredentials: true,
});

api.interceptors.request.use(
  async(config  ) => {
      const needsCsrf = ["post", "put", "patch", "delete"].includes(config.method);
      if (needsCsrf) {
          if (!document.cookie.includes("XSRF-TOKEN")) {
              await axios.get("/sanctum/csrf-cookie", { withCredentials: true });
          }
      }
    // store.commit("loader/showLoader");
    return config;
  },
  (error) => {
    // store.commit("loader/hideLoader");
    return Promise.reject(error);
  }
);

api.interceptors.response.use(
  (response) => {
    // store.commit("loader/hideLoader");
    return response;
  },
  (error) => {
    // store.commit("loader/hideLoader");
    return Promise.reject(error);
  }
);

export default api;
