<!--<template>-->
<!--    <div class="content container">-->

<!--        <div class="row mt-3" v-if="products.length">-->
<!--            <div class="col-md-4" v-for="product in products" :key="product.id">-->
<!--                <div class="card mb-3">-->
<!--                    <div class="card-body-image">-->
<!--                    <router-link-->
<!--                        :to="{-->
<!--                            name: 'products.show',-->
<!--                            params: { slug: product.slug },-->
<!--                        }"-->
<!--                    >-->
<!--                        <img-->
<!--                            class="card-img"-->
<!--                            :src="product.image || 'https://dummyimage.com/420x260/fff/aaa'"-->
<!--                            alt="Vans"-->
<!--                        />-->
<!--                    </router-link>-->
<!--                    </div>-->
<!--                    <div class="card-body">-->
<!--                        <h4 class="card-title">{{ product.name }}</h4>-->
<!--                        <h6 class="card-subtitle mb-2 text-muted">-->
<!--                            <span-->
<!--                                v-for="category in product.categories"-->
<!--                                :key="category.id"-->
<!--                                v-text="category.name"-->
<!--                                class="me-2"-->
<!--                            ></span>-->
<!--                        </h6>-->
<!--                        <div-->
<!--                            class="buy d-flex justify-content-between align-items-center"-->
<!--                        >-->
<!--                            <div class="price text-success">-->
<!--                                <h5-->
<!--                                    class="mt-4"-->
<!--                                    v-text="formatCurrency(product.price)"-->
<!--                                ></h5>-->
<!--                            </div>-->
<!--                            <v-btn-->
<!--                                color="primary"-->
<!--                                @click="addTocart(product)"-->
<!--                                :loading="loadingCartId === product.id"-->
<!--                                icon="mdi-cart-plus"-->
<!--                            >-->
<!--                            </v-btn>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        &lt;!&ndash; <div class="row mt-3" v-else>Loading...</div> &ndash;&gt;-->
<!--    </div>-->
<!--</template>-->
<template>
    <div class="content container py-4">
        <div v-if="products.length" class="product-grid">
            <div v-for="product in products" :key="product.id" class="product-card">
                <div class="image-wrapper">
                    <router-link
                        :to="{
              name: 'products.show',
              params: { slug: product.slug },
            }"
                    >
                        <img
                            class="product-image"
                            :src="product.image || 'https://dummyimage.com/420x260/fff/aaa'"
                            :alt="product.name"
                        />
                    </router-link>
                </div>

                <div class="product-info">
                    <h4 class="title">{{ product.name }}</h4>
                    <h6 class="categories text-muted mb-2">
            <span
                v-for="category in product.categories"
                :key="category.id"
                class="me-2"
            >
              {{ category.name }}
            </span>
                    </h6>

                    <div class="actions d-flex justify-content-between align-items-center">
                        <h5 class="text-success mb-0">
                            {{ formatCurrency(product.price) }}
                        </h5>

                        <v-btn
                            color="primary"
                            @click="addTocart(product)"
                            :loading="loadingCartId === product.id"
                            icon="mdi-cart-plus"
                        ></v-btn>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="text-center py-5">
            <p>Loading products...</p>
        </div>
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
.card .card-body-image{
    width: 100%;
    height: 250px;
    padding: 30px;
    text-align: center;

}
.card .card-body-image img{
    width: 80%;
    height:  100%;

}
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
}

.product-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
}

.image-wrapper {
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background-color: #f9f9f9;
    display: flex;
    justify-content: center;
    align-items: center;
}
.image-wrapper a{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}
.product-image {
    width: 85%; /* 👈 الصورة أصغر من المربع */
    height: 85%;
    object-fit: contain; /* تحافظ على الأبعاد */
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-info {
    padding: 1rem 1.25rem 1.5rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.categories {
    font-size: 0.9rem;
    color: #888;
}

.actions {
    margin-top: auto;
}
</style>
