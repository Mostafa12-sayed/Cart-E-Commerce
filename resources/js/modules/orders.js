import api from "@/axios";

export default {
    namespaced: true,
    state: {
        orders: [],
        order: {},
    },
    getters: {
        orders(state) {
            return state.orders;
        },
        order(state) {
            return state.order;
        },
    },
    mutations: {
        setOrders(state, orders) {
            state.orders = orders;
        },
        setOrder(state, order) {
            state.order = order;
        },
    },
    actions: {
        async getOrders({ commit }) {
            try {
                const res = await api.get("/api/my-orders");
                commit("setOrders", res.data);
            } catch (err) {
                console.error(err);
            }
        },
        async getOrder({ commit }, id) {
            try {
                const res = await api.get(`/api/my-order/${id}`);
                commit("setOrder", res.data);
            } catch (err) {
                console.error(err);
            }
        },
    },
}
