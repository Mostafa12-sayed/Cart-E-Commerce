<template>
    <div class="content container">

        <div class="row mt-3" v-if="products.length">
            <div class="col-md-4" v-for="product in products" :key="product.id">
                <div class="card mb-3">
                    <router-link
                        :to="{
                            name: 'products.show',
                            params: { slug: product.slug },
                        }"
                    >
                        <img
                            class="card-img"
                            :src="product.image || 'https://dummyimage.com/420x260/fff/aaa'"
                            alt="Vans"
                        />
                    </router-link>

                    <div class="card-body">
                        <h4 class="card-title">{{ product.name }}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <span
                                v-for="category in product.categories"
                                :key="category.id"
                                v-text="category.name"
                                class="me-2"
                            ></span>
                        </h6>
                        <div
                            class="buy d-flex justify-content-between align-items-center"
                        >
                            <div class="price text-success">
                                <h5
                                    class="mt-4"
                                    v-text="formatCurrency(product.price)"
                                ></h5>
                            </div>
                            <v-btn
                                color="primary"
                                @click="addTocart(product)"
                                :loading="loadingCartId === product.id"
                                icon="mdi-cart-plus"
                            >

                            </v-btn>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row mt-3" v-else>Loading...</div> -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            loadingCartId: null,
        };
    },


    methods: {
        formatCurrency(amount) {
            amount = amount / 100;
            return amount.toLocaleString("en-US", {
                style: "currency",
                currency: "USD",
            });
        },
        testingfun(amount) {
            return amount / 100;
            console.log(amount);
        },
        async addTocart(product) {
            this.loadingCartId = product.id;
            try {
                await this.$store.dispatch("addToCart", product);
            } catch (err) {
                console.error("Error add To cart:", err);
            } finally {
                this.loadingCartId = null;
            }
        },
    },
    computed: {
        products() {
            return this.$store.state.products;
        },
    },
};
</script>
<style scoped>
.content{
    margin-top: 100px;
}

</style>
