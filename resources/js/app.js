import "./bootstrap";
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routers.js";
import App from "./components/App.vue";
import store from "./store.js";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "@mdi/font/css/materialdesignicons.css";


import Toast,  { POSITION }from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";
const router = createRouter({
    history: createWebHistory(),
    routes,
});
const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: "mdi",
    },
});
const app = createApp(App);
const options = {
    position: POSITION.TOP_CENTER,
    timeout: 5000,
};
app.mixin({
    created() {
        if (this === this.$root) {
            const actions = ["getProducts", "getCart"];
            actions.forEach(action => {
                this.$store.dispatch(action).catch(console.error);
            });
        }
    },
});
router.beforeEach(async (to, from, next) => {
    store.commit("loader/showLoader");

    if (!store.getters["authenticated"]) {
        try {
            await store.dispatch("attempt");
        } catch (e) {}
    }
    if (['login', 'register'].includes(to.name) && from.fullPath) {
        localStorage.setItem('previous_url', from.fullPath);
    }
    const isAuthenticated = store.getters["authenticated"];
    if (to.meta.requiresAuth && !isAuthenticated) {
        return next({ name: "login" });
    }

    if (to.meta.guest && isAuthenticated) {
        return next({ name: "products.index" });
    }

    next();
});
router.afterEach(() => {
    // إيقاف الـ loader بعد انتهاء التنقل
    store.commit("loader/hideLoader");
});

app.use(Toast , options)
app.use(router);
app.use(store);
app.use(vuetify);
app.mount('#app')


