
<template>
    <div class="product-card">
        <div class="image-wrapper">
            <router-link
                :to="{ name: 'products.show', params: { slug: product.slug } }"
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

            <div class="actions d-flex justify-content-between align-items-center" >
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
</template>
<script>
export default {
    name: "ProductCard",
    data(){
        return { loadingCartId:null }
    },
    props:{
        product: Object,

    },
    methods: {
        formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            }).format(amount);
        },
        async addTocart(product) {
            this.loadingCartId = product.id;
            try {
                await this.$store.dispatch("addToCart", product);
            } catch (err) {
                console.error("Error adding to cart:", err);
            } finally {
                this.loadingCartId = null;
            }
        },
    },
}
</script>
<style scoped>
.image-wrapper {
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background-color: #f9f9f9;
    display: flex;
    justify-content: center;
    align-items: center;
}
.image-wrapper a{ display: flex; justify-content: center; align-items: center; width: 100%; height: 100%; }
.product-image {
    width: 85%;
    height: 85%;
    object-fit: contain;
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
</style>
