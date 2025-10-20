<template>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    class="text-white p-2"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
                    ></path>
                </svg>
                | Shopping Cart</a
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <router-link
                        tag="li"
                        class="nav-item"
                        :to="{ name: 'products.index' }"
                    >
                        Products
                    </router-link>
                </ul>

                <nav class=" d-flex align-items-center gap-3 justify-content-end">


                    <router-link
                        class="btn btn-secondary"
                        :to="{ name: 'order.checkout' }"
                        color="primary"
                    >
                        <v-icon icon="mdi-cart"></v-icon>
                        <span class="inline-block ms-1"
                            >({{ this.$store.state.numberItems }} item)</span
                        >
                    </router-link>
                    <router-link class="nav-item" :to="{name: 'login'}" color="primary">Login</router-link>
                    <router-link class="nav-item" :to="{name: 'register'}" color="primary">Register</router-link>
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
.btn {
    background-color: #1867c0 !important;
    border-color: #bcd0c7 !important ;
    color: rgb(255, 254, 254);
}
</style>
