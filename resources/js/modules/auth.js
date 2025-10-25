import api from "@/axios";

export default {


    state: () => ({
        authenticated: false,
        user: {},
    }),

    getters: {
        authenticated: (state) => state.authenticated,
        user: (state) => state.user,
    },

    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value;
        },
        SET_USER(state, user) {
            state.user = user;
        },
    },

    actions: {
        async login({ dispatch }, credentials) {
            try {
                // 1️⃣ خذ CSRF token الأول
                await api.get('/sanctum/csrf-cookie');

                // 2️⃣ نفذ تسجيل الدخول
                const loginResponse = await api.post("/api/login", credentials);

                // 3️⃣ ✅ بعد تسجيل الدخول Laravel بيغير الكوكي .. نستنى ثم نجيب كوكي جديدة
                await new Promise(resolve => setTimeout(resolve, 150)); // تأخير بسيط 150ms
                await api.get('/sanctum/csrf-cookie');
                window.location.reload();
                // 4️⃣ نجيب بيانات المستخدم
                return await dispatch("attempt");
            } catch (e) {
                console.error("Login error:", e.response?.data || e.message);
                throw e;
            }
        },


        async attempt({ commit }) {
            try {
                const response = await api.get("/api/user");
                commit("SET_AUTHENTICATED", true);
                commit("SET_USER", response.data.user || response.data);
                // commit("setCart", response.data.cart || []);
                // this.$store.dispatch('getCart')
                return response;
            } catch (e) {
                commit("SET_AUTHENTICATED", false);
                commit("SET_USER", {});
            }
        },

        async logout({ commit }) {
            try {
                await api.post("/api/logout");
            } catch (_) {}

            commit("SET_AUTHENTICATED", false);
            commit("SET_USER", {});
            commit("clearCart");
        },
    },
};
