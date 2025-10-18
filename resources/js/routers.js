export const routes = [
    {
        name: "products.index",
        path: "/",
        component: () => import("./components/products/Index.vue"),
    },
    {
        name: "products.show",
        path: "/product/:slug",
        component: () => import("./components/products/Show.vue"),
    },

    {
        name: "order.checkout",
        path: "/checkout",
        component: () => import("./components/order/Checkout.vue"),
    },
    {
        name: "order.summary",
        path: "/checkout/summary",
        component: () => import("./components/order/Summary.vue"),
    },
];
