<template>
    <div class=" container py-10 my-10 ">
        <div class="row g-4 align-items-center">
            <!-- Product Image -->

            <div class="col-12 col-md-6 shadow-sm text-center p-4">
                <img
                    class="img-fluid rounded  product-image"
                    :src="getImageUrl(product.image) || 'https://dummyimage.com/640x640/bbb/555'"
                    alt="Product image"
                />
            </div>

            <!-- Product Details -->
            <div class="col-12 col-md-6" v-if="product">
                <div class="product-info p-3">
                    <h6 class="text-muted mb-2">
                        <span
                            v-for="category in product.categories"
                            :key="category.id"
                            class="badge bg-light text-dark me-2"
                        >
                            {{ category.name }}
                        </span>
                    </h6>

                    <h3 class="fw-bold text-dark mb-3">{{ product.name }}</h3>

                    <p class="text-secondary lh-base mb-4 text-justify">
                        {{ product.description }}
                    </p>

                    <hr />

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4">
                        <h4 class="text-success mb-3 mb-sm-0">
                            {{ formatCurrency(product.price) }}
                        </h4>
                        <v-btn
                            :loading="loadingAddCart"
                            color="primary"
                            class="px-4"
                            @click="addTocart(product)"
                        >
                            Add to Cart
                        </v-btn>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loadingAddCart: false,
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
            this.loadingAddCart = true;
            try {
                await this.$store.dispatch("addToCart", product);
            } catch (err) {
                console.error("Error add To cart:", err);
            } finally {
                this.loadingAddCart = false;
            }
        },
        getImageUrl(image) {
            let path = import.meta.env.VITE_API_URL || "https://cart-project.test";
            return path + "/" + image;
        },
    },
    computed: {
        products() {
            return this.$store.state.products;
        },
        product() {
            return this.products.find(
                (product) => product.slug === this.$route.params.slug
            );
        },
    },
};
</script>

<style scoped>
.product-image {
    max-width: 100%;
    height: auto;
    object-fit: cover;
}

.text-justify {
    text-align: justify;
}

.product-info {
    background: #fff;
    border-radius: 12px;
}

/* Smaller screen adjustments */
@media (max-width: 768px) {
    .product-info {
        text-align: center;
    }

    .product-info .badge {
        display: inline-block;
        margin-bottom: 5px;
    }

    .product-info hr {
        width: 80%;
        margin: 1rem auto;
    }

    .product-info .text-justify {
        text-align: left;
        padding: 0 10px;
    }
}
</style>
