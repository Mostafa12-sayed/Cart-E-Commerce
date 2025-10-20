import "./bootstrap";

import { createApp, onBeforeMount } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routers.js";
import App from "./components/App.vue";
import store from "./store.js";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "@mdi/font/css/materialdesignicons.css"; // ✅ icons
// إنشاء الـ Router بالطريقة الجديدة
const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    next();
});
const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: "mdi", // ✅ نستخدم Material Design Icons
    },
});
const app = createApp(App);
app.mixin({
    created() {
        if (this === this.$root) {
            this.$store
                .dispatch("getProducts")
                .then(() => {})
                .catch((error) => console.error(error));
            this.$store
                .dispatch("getCart")
                .then(() => {})
                .catch((error) => console.error(error));
        }
    },
});

app.use(router);
app.use(store);
app.use(vuetify);
app.mount("#app");
