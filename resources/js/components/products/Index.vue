<template>
    <v-container >
        <v-row>
            <!-- 🧭 Sidebar -->
            <v-col cols="12" md="3" class="mb-6">
                <v-card class="pa-4 rounded-xl" elevation="3">
                    <v-card-title class="text-h6 font-weight-bold mb-2">🔍 Filters</v-card-title>
                    <v-divider class="mb-4"></v-divider>

                    <!-- Search -->
                    <v-text-field
                        v-model="search"
                        label="Search products"
                        prepend-inner-icon="mdi-magnify"
                        dense
                        hide-details
                        clearable
                        @input="applyFilters"
                    ></v-text-field>

                    <!-- Category Filter -->
                    <v-select
                        v-model="selectedCategory"
                        :items="categories"
                        item-title="name"
                        item-value="name"
                        label="Category"
                        prepend-inner-icon="mdi-tag-outline"
                        dense
                        hide-details
                        clearable
                        class="mt-3"
                        @change="applyFilters"
                    ></v-select>


                    <!-- Price Filter -->
                    <div class="mt-5">
                        <label class="text-caption font-weight-bold text-muted">Price Range</label>
                        <v-range-slider
                            v-model="priceRange"
                            :max="maxPrice"
                            :min="minPrice"
                            step="10"
                            class="mt-2"
                            thumb-label
                            @end="applyFilters"
                        ></v-range-slider>
                        <div class="d-flex justify-space-between text-caption">
                            <span>${{ priceRange[0] }}</span>
                            <span>${{ priceRange[1] }}</span>
                        </div>
                    </div>

                    <v-btn
                        block
                        class="mt-5"
                        color="primary"
                        variant="flat"
                        @click="resetFilters"
                    >
                        Reset Filters
                    </v-btn>
                </v-card>
            </v-col>

            <!-- 🛍️ Products Grid -->
            <v-col cols="12" md="9">
                <div v-if="filteredProducts.length" class="product-grid">
                    <ProductCard v-for="product in filteredProducts"
                                 :key="product.id" :product="product" />
                </div>

                <!-- No products found -->
                <div v-else class="text-center py-10">
                    <v-icon color="grey" size="60">mdi-package-variant</v-icon>
                    <h4 class="text-grey-darken-1 mt-2">No Products Found</h4>
                    <p class="text-grey">Try adjusting your filters.</p>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import ProductCard from "@/components/products/ProductCard.vue";
import api from "@/axios.js";

export default {
    components: {ProductCard},
    data() {
        return {
            search: "",
            selectedCategory: null,
            priceRange: [0, 1000],
            minPrice: 0,
            maxPrice: 1000,
            loadingCartId: null,
            categories: []
        };
    },
    async mounted() {
        try {
            const res = await api.get("/api/categories");
            this.categories = res.data.data;
        } catch (err) {
            console.error("Failed to load categories", err);
        }
    },
    computed: {
        products() {
            return this.$store.state.products;
        },

        filteredProducts() {
            return this.products.filter((p) => {
                const matchSearch = p.name
                    .toLowerCase()
                    .includes(this.search.toLowerCase());
                const matchCategory =
                    !this.selectedCategory ||
                    p.categories.some(
                        (c) => c.name.toLowerCase() === this.selectedCategory.toLowerCase()
                    );
                const matchPrice =
                    p.price / 100 >= this.priceRange[0] &&
                    p.price / 100 <= this.priceRange[1];
                return matchSearch && matchCategory && matchPrice;
            });
        },
    },
    methods: {


        applyFilters() {
            // Trigger reactivity (computed handles the rest)
        },
        resetFilters() {
            this.search = "";
            this.selectedCategory = null;
            this.priceRange = [this.minPrice, this.maxPrice];
        },
    },
};
</script>

<style scoped>



</style>
