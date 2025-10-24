<template>
    <div class=" checkout">
        <div class="row d-flex flex-row justify-content-center">
            <div class="col-md-8">
                <div class="mt-5">
                    <h4
                        class="text-muted small"
                        v-text="'Transaction ID: ' + order.transaction_id"
                    ></h4>
                    <h2 class="text-muted mb-4">Thank you for your purchase</h2>
                    <table class="table">
                        <thead class="table-primary " >
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in order.products" :key="item.id">
                                <td class="p-4" v-text="item.name"></td>
                                <td
                                    class="p-4"
                                    v-text="item.pivot.quantity"
                                ></td>
                                <td
                                    class="p-4"
                                    v-text="cartLineTotal(item)"
                                ></td>
                            </tr>
                            <tr>
                                <td class="p-4 fw-bold">Total Amount</td>
                                <td
                                    class="p-4 fw-bold"
                                    v-text="orderQuantity"
                                ></td>
                                <td
                                    class="p-4 fw-bold"
                                    v-text="orderTotal"
                                ></td>
                                <td class="w-10 text-right"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    methods: {
        cartLineTotal(item) {
            let amount = item.price * item.pivot.quantity;
            amount = amount / 100;
            return amount.toLocaleString("en-US", {
                style: "currency",
                currency: "USD",
            });
        },
    },
    mounted() {
        if (!this.$store.state.order?.order) {
            this.$router.push({ name: "products.index" });
        }
    },
    computed: {
        order() {
            return this.$store.state.order?.order || {};
        },
        orderQuantity() {
            if (!this.order.products) return 0;
            return this.order.products.reduce(
                (acc, item) => acc + item.pivot.quantity,
                0
            );
        },
        orderTotal() {
            if (!this.order.products) return 0;
            let amount = this.order.products.reduce(
                (acc, item) => acc + item.price * item.pivot.quantity,
                0
            );
            amount = amount / 100;
            return amount.toLocaleString("en-US", {
                style: "currency",
                currency: "USD",
            });
        },
    },
};
</script>
