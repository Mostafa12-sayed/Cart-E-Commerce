<template>
    <div >
        <Loader :show="loading" />

        <Navbar />
        <router-view> </router-view>
    </div>
</template>

<script>
import Navbar from "./Navbar.vue";
import Loader from "./Loader.vue";
import { mapState } from "vuex";
export default {
    name: "App",
    components: {
        Navbar,
        Loader,
    },
    computed: {
        ...mapState("loader", ["loading"]),
    },
};
</script>
<style>
.btn {
    background-color: #0471d6 !important;
    border-color: #bcd0c7 !important;
    color: rgb(255, 238, 238);
}
.content{
    margin-top: 100px !important;
}

/* Table responsiveness */
.table-responsive {
    overflow-x: auto;
}

.table th,
.table td {
    vertical-align: middle !important;
    white-space: nowrap;
}

/* Mobile adjustments */
@media (max-width: 768px) {
    h2 {
        font-size: 1.4rem;
    }

    .table th,
    .table td {
        font-size: 0.85rem;
        padding: 0.6rem;
    }

    .v-btn {
        transform: scale(0.9);
    }

    .form-control {
        font-size: 0.9rem;
    }
}

/* Extra small screens */
@media (max-width: 576px) {
    .checkout {
        padding: 0 1rem;
    }

    .v-btn {
        min-width: 35px !important;
    }
}
nav {

    a {
        font-weight: bold;
        color: #1867c0;
        text-decoration: none;
        &.router-link-exact-active {
            color: #42b983;
        }
    }
}
a {
    font-weight: bold;
    color: #1867c0;

    &.router-link-exact-active {
        color: #42b983;
    }
}
</style>
