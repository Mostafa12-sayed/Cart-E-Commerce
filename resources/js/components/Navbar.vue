<template>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" @click="this.$router.push({name:'home'})">
                <img src="../public/images/logo-mobile.png" alt="">


            </a>
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center text-md-start d-flex gap-3">

                    <li class="nav-item">
                        <router-link
                            class="nav-item"
                            :to="{ name: 'home' }"
                            active-class="active"
                        >
                            Home
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-item"
                            :to="{ name: 'products.index' }"
                            active-class="active"
                        >
                            Shop
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-item"
                            :to="{ name: 'my-orders' }"
                            active-class="active"
                        >
                            My Orders
                        </router-link>
                    </li>

                </ul>

                <nav
                    class="d-flex flex-md-row flex-column align-items-center justify-content-md-end justify-content-center gap-3 py-3"
                >
                    <!-- Cart button -->


                    <!-- Login & Register -->
                    <router-link
                        v-if="!authenticated"
                        class="nav-item"
                        :to="{ name: 'login' }"

                    >
                        <v-icon >mdi-account</v-icon> Login
                    </router-link>

                    <router-link
                        v-if="!authenticated"
                        class="nav-item register-btn  "
                        :to="{ name: 'register' }"
                        variant="outlined"


                    >
                        Register
                    </router-link>

                    <!-- Logout -->
                    <a
                        v-if="authenticated"
                        class="nav-item"
                        @click="logout"
                    >
                        Log out
                    </a>
                    <router-link
                        class="mx-3"
                        :to="{ name: 'order.checkout' }"
                    >
<!--                        <v-icon icon="mdi-cart" class="me-2"></v-icon>-->
<!--                        <span>( item)</span>-->
                        <v-badge location="top right" color="warning" :content="$store.state.numberItems ">

                            <v-icon icon="mdi-cart" size="30" ></v-icon>
                        </v-badge>
                    </router-link>
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
    position: sticky;
    top: 0;
    left: 0;
    right: 0;
    background-color: #ffffff;
    color: white;
    box-shadow: 0px 2px 15px #888888;
    z-index: 1000;
}
.navbar-brand img{

    height: 50px;
}
.btn {
    background-color: #1867c0 !important;
    border-color: #bcd0c7 !important ;
    color: rgb(255, 254, 254);
}
.register-btn{
    border-radius: 8px;
    border: 2px solid #099ae3;
    padding: 8px 20px;
}
.register-btn:hover{
    background: #73d0ff;
}
</style>
