<!-- src/components/EmptyCart.vue -->
<template>
    <div class="empty-cart d-flex align-items-center justify-content-center">
        <div class="card shadow-sm text-center p-4">
            <div class="illustration mb-3" aria-hidden="true" >
                <img  src="../../public/images/empty-cart.jpg" alt="">
            </div>

            <h3 class="mb-2">Your cart is empty</h3>
            <p class="text-muted mb-4">
                Looks like you haven't added anything to your cart yet. Start browsing our products and add your favorites!
            </p>

            <div class="d-flex gap-2 justify-content-center">
                <router-link :to="{ name: 'products.index' }" class="btn btn-primary">
                    Continue shopping
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EmptyCart",
};
</script>

<style scoped>
.empty-cart {
    min-height: 40vh; /* adjust as needed */
    padding: 2rem;

}

/* card sizing */
.empty-cart .card {
    max-width: 600px;
    border-radius: 14px;
    background: #ffffff;

}

/* illustration sizing + subtle float */
.illustration {
    width: 250px;
    height: 250px;
    margin: 0 auto;
    display: block;
    transition: transform .6s ease;
}
.illustration img{
    width: 100%;
    height: 100%;
    object-fit: fill;
}
.illustration:hover { transform: translateY(-6px); }

/* responsive tweaks */
@media (max-width: 576px) {
    .empty-cart .card { padding: 1.5rem; }

}

/* small visual polish for buttons on narrow screens */
@media (max-width: 420px) {
    .empty-cart .d-flex { flex-direction: column; gap: 0.5rem; }
    .empty-cart .btn { width: 100%; }
    .illustration {width: 165px !important;}
}
</style>
