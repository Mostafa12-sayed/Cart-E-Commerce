export const routes = [
    {
        name: "products.index",
        path: "/",
        component: () => import("./components/products/Index.vue"),
        meta:{
            title : 'Products'
        }
    },
    {
        name: "products.show",
        path: "/product/:slug",
        component: () => import("./components/products/Show.vue"),
        meta:{
            title : 'Product Show '
        }
    },

    {
        name: "order.checkout",
        path: "/checkout",
        component: () => import("./components/order/Checkout.vue"),
        meta:{
            title : 'Checkout'
        }
    },
    {
        name: "order.summary",
        path: "/checkout/summary",
        component: () => import("./components/order/Summary.vue"),
        meta:{
            title : 'Summary Order'
        }
    },
    {
        name: "login",
        path: "/login",
        component: () => import("./components/auth/Login.vue"),
        meta:{
            title : 'Login'
        }
    },
    {
        name: "register",
        path: "/register",
        component: () => import("./components/auth/Register.vue"),
        meta:{
            title : 'Register'
        }
    },
];
