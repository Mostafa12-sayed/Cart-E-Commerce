<template>
    <div class="landing-page">
        <!-- 🖼️ Hero Slider -->
        <v-carousel
            height="500"
            cycle
            hide-delimiter-background
            show-arrows-on-hover
            class="rounded-lg overflow-hidden"
        >
            <v-carousel-item
                v-for="(slide, i) in slides"
                :key="i"
                :src="slide.image"
                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
            >
                <div class="carousel-content">
                    <h1 class="text-white font-weight-bold mb-2">{{ slide.title }}</h1>
                    <p class="text-white text-body-1 mb-4">{{ slide.subtitle }}</p>
                    <v-btn color="primary" size="large" @click="$router.push('/shop')">
                        Shop Now
                    </v-btn>
                </div>
            </v-carousel-item>
        </v-carousel>

        <!-- 💎 Featured Products -->
        <v-container class="py-10">
            <h2 class="text-center mb-8 font-weight-bold">Featured Products</h2>

            <div v-if="products.length" class="product-grid">
                <ProductCard v-for="product in products.slice(0, 8)"
                             :key="product.id" :product="product" />
            </div>

            <div v-else class="text-center py-5 text-grey">Loading products...</div>

            <div class="text-center mt-8">
                <v-btn color="primary" variant="flat" size="large" @click="$router.push('/shop')">
                    View All Products
                </v-btn>
            </div>
        </v-container>

        <!-- 🛍️ CTA Banner -->
<!--        <v-parallax-->
<!--            src="https://images.unsplash.com/photo-1607083206968-13611e3b7d4c?auto=format&fit=crop&w=1350&q=80"-->
<!--            height="300"-->
<!--            class="cta-banner d-flex align-center justify-center text-center"-->
<!--        >-->
<!--            <div>-->
<!--                <h2 class="text-white font-weight-bold mb-2">Big Sale 50% Off!</h2>-->
<!--                <p class="text-white mb-4">Get the best deals on top brands now.</p>-->
<!--                <v-btn color="white" variant="outlined" size="large" @click="$router.push('/shop')">-->
<!--                    Start Shopping-->
<!--                </v-btn>-->
<!--            </div>-->
<!--        </v-parallax>-->
        <Contact />
        <!-- ⚙️ Footer -->
    </div>
</template>

<script>
import ProductCard from "@/components/products/ProductCard.vue";
import Contact from "@/components/views/Contact.vue";
export default {
    components: {Contact, ProductCard},
    data() {
        return {
            slides: [
                {
                    image: "https://images.unsplash.com/photo-1607082349566-1873421250c9?auto=format&fit=crop&w=1350&q=80",
                    title: "New Season Arrivals",
                    subtitle: "Check out all the latest trends",
                },
                {
                    image: "https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?auto=format&fit=crop&w=1350&q=80",
                    title: "Exclusive Deals",
                    subtitle: "Save big on our top-selling products",
                },
                {
                    image: "https://images.unsplash.com/photo-1618354691417-5ad20f2903af?auto=format&fit=crop&w=1350&q=80",
                    title: "Shop with Confidence",
                    subtitle: "High-quality items at unbeatable prices",
                },
            ],
        };
    },
    computed: {
        products() {
            return this.$store.state.products;
        },
    },
    methods: {
        formatCurrency(amount) {
            amount = amount / 100;
            return amount.toLocaleString("en-US", {
                style: "currency",
                currency: "USD",
            });
        },
    },
};
</script>

<style scoped>
.carousel-content {
    position: absolute;
    bottom: 15%;
    left: 10%;
    color: white;
}

</style>
