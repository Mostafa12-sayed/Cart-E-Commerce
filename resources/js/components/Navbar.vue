<template>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
<!--                <svg-->
<!--                    xmlns="http://www.w3.org/2000/svg"-->
<!--                    fill="none"-->
<!--                    stroke="currentColor"-->
<!--                    stroke-linecap="round"-->
<!--                    stroke-linejoin="round"-->
<!--                    stroke-width="2"-->
<!--                    class="text-white p-2"-->
<!--                    viewBox="0 0 24 24"-->
<!--                >-->
<!--                    <path-->
<!--                        d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"-->
<!--                    ></path>-->
<!--                </svg>-->
                <img src="../public/images/logo.PNG" alt="">
                | Online Shop</a
            >
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center text-md-start">
                    <li class="nav-item">
                        <router-link
                            class="nav-item"
                            :to="{ name: 'products.index' }"
                            active-class="active"
                        >
                            Products
                        </router-link>
                    </li>
                </ul>

                <nav
                    class="d-flex flex-md-row flex-column align-items-center justify-content-md-end justify-content-center gap-3 py-3"
                >
                    <!-- Cart button -->
                    <router-link
                        class="btn btn-secondary d-flex align-items-center justify-content-center"
                        :to="{ name: 'order.checkout' }"
                    >
                        <v-icon icon="mdi-cart" class="me-2"></v-icon>
                        <span>({{ $store.state.numberItems }} item)</span>
                    </router-link>

                    <!-- Login & Register -->
                    <router-link
                        v-if="!authenticated"
                        class="nav-item"
                        :to="{ name: 'login' }"
                    >
                        Login
                    </router-link>

                    <router-link
                        v-if="!authenticated"
                        class="nav-item"
                        :to="{ name: 'register' }"
                    >
                        Register
                    </router-link>

                    <!-- Logout -->
                    <a
                        v-if="authenticated"
                        class="nav-item"
                        @click="logout"
                    >
                        Logout
                    </a>
                </nav>
            </div>
        </div>
    </nav>
</template>
<script>

export default {
    data() {
        return {
            numberItems: 0,


        };
    },
    computed:{
        authenticated() {
            return this.$store.getters["authenticated"];
        },
    },
    methods: {
        async logout() {
            await this.$store.dispatch("logout").then(() => {
                this.$store.dispatch("clearCart");
                this.$router.push({ name: "login" });

            });
        },
    },

};
</script>
<style scoped>
svg {
    width: 40px;
    height: 40px;
    background-color: #1867c0;
    border-radius: 50%;
    margin-right: 5px;
    color: white;
}

.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background-color: #ededed;
    color: white;
    box-shadow: 0px 2px 15px #888888;
    z-index: 1000;
}
.navbar-brand img{
    width: 100px;
    height: 50px;
}
.btn {
    background-color: #1867c0 !important;
    border-color: #bcd0c7 !important ;
    color: rgb(255, 254, 254);
}
</style>
