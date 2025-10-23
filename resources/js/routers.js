export const routes = [
    {
        name: "products.index",
        path: "/",
        component: () => import("./components/products/Index.vue"),
        meta: {
            title: 'Products',
        }
    },
    {
        name: "products.show",
        path: "/product/:slug",
        component: () => import("./components/products/Show.vue"),
        meta: {
            title: 'Product Show',
        }
    },
    {
        name: "order.checkout",
        path: "/checkout",
        component: () => import("./components/order/Checkout.vue"),
        meta: {
            title: 'Checkout',
            requiresAuth: false // ✅ لو محتاج تسجيل دخول قبل الشراء
        }
    },
    {
        name: "order.summary",
        path: "/checkout/summary",
        component: () => import("./components/order/Summary.vue"),
        meta: {
            title: 'Summary Order',
            requiresAuth: true // ✅ برضو جزء من عملية الشراء
        }
    },
    {
        name: "login",
        path: "/login",
        component: () => import("./components/auth/Login.vue"),
        meta: {
            title: 'Login',
            guest: true // ✅ الصفحة دي فقط للضيوف
        }
    },
    {
        name: "register",
        path: "/register",
        component: () => import("./components/auth/Register.vue"),
        meta: {
            title: 'Register',
            guest: true // ✅ برضو للضيوف فقط
        }
    },
    {
        name: "recover-password",
        path: "/recover-password",
        component: () => import("./components/auth/RecoverPassword.vue"),
        meta: {
            title: 'Recover Password',
            guest: true // ✅ برضو للضيوف فقط
        }
    },
    {
        name: "reset-password",
        path: "/reset-password",
        component: () => import("./components/auth/RestPassword.vue"),
        meta: {
            title: 'Reset Password',
            guest: true // ✅ برضو للضيوف فقط
        }
    },
    {
        name: "my-orders",
        path: "/my-orders",
        component: () => import("./components/order/MyOrder.vue"),
        meta: {
            title: 'My Order',
            requiresAuth: true // ✅ برضو جزء من عملية الشراء
        }
    },
    {
        name: "order.show",
        path: "/order/:id",
        component: () => import("./components/order/OrderDatils.vue"),
        meta: {
            title: 'My Order',
            requiresAuth: true // ✅ برضو جزء من عملية الشراء
        }
    },
];
