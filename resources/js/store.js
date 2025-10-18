import axios from "axios";
import { createStore } from "vuex";

const store = createStore({
    state: {
        products: [],
        categories: [],
        cart: [],
        order: {},
        numberItems: 0,
        cartTotal: 0,
        cartTotalQuantity: 0,
    },

    getters: {
        getItemsNumber(state) {
            return state.cart?.length || 0;
        },
    },

    mutations: {
        setProducts(state, products) {
            state.products = products;
        },
        setCart(state, cart) {
            const items = Array.isArray(cart) ? cart : [];
            state.cart = items;
            state.cartTotalQuantity = items.reduce(
                (acc, item) => acc + (item.quantity || 0),
                0
            );
        },
        setOrder(state, order) {
            state.order = order;
        },
        removeFromCart(state, product) {
            state.cart = state.cart.filter((item) => item.id !== product.id);
        },
        setNumberItems(state, value) {
            state.numberItems = value;
        },
        setCartTotal(state, value) {
            state.cartTotal = value;
        },
        clearCart(state) {
            state.cart = [];
            state.cartTotalQuantity = 0;
            state.cartTotal = 0;
            state.numberItems = 0;
        },
    },

    actions: {
        async getProducts({ commit }) {
            try {
                const res = await axios.get("/api/products");
                commit("setProducts", res.data);
            } catch (err) {
                console.error(err);
            }
        },

        async getCart({ commit, getters, state }) {
            try {
                const res = await axios.get("/api/cart");
                commit("setCart", res.data.cart || []);
                commit("setNumberItems", res.data.length); // ✅ بدون ()
                commit("setCartTotal", res.data.total || 0); // ✅ بدون ()
            } catch (err) {
                console.error(err);
            }
        },

        async addToCart({ commit }, product) {
            try {
                const response = await fetch(`/api/add-to-cart/${product.id}`, {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        quantity: 1,
                        image: product.image,
                    }),
                });

                if (!response.ok) throw new Error("Failed to add item to cart");

                const data = await response.json();
                commit("setCart", data.cart || []);
                commit("setNumberItems", data.length); // ✅ بدون ()
                commit("setCartTotal", data.total || 0); // ✅ بدون ()
            } catch (err) {
                console.error(err);
            }
        },

        clearCart({ commit }) {
            commit("clearCart");
        },
        async removeFromCart({ commit }, id) {
            try {
                const res = await axios.delete(`/api/remove-from-cart/${id}`, {
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                });

                // axios بيرجع البيانات داخل res.data
                commit("setCart", res.data.cart || []);
                commit("setCartTotal", res.data.total || 0);
                commit("setNumberItems", res.data.cart?.length || 0);
            } catch (err) {
                console.error("Error removing from cart:", err);
            }
        },
        async increment({ commit }, id) {
            const response = await axios.post("/api/cart/increment", { id:id }, {
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            });
            commit("setCart", response.data.cart || []);
            commit("setCartTotal", response.data.total || 0);
            commit("setNumberItems", response.data.cart?.length || 0);
        },
        async decrement({ commit }, id) {

            const response = await axios.post("/api/cart/decrement", { id:id },{
                 headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            });
            commit("setCart", response.data.cart || []);
            commit("setCartTotal", response.data.total || 0);
            commit("setNumberItems", response.data.cart?.length || 0);
        },
    },
});

export default store;
