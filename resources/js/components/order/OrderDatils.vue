<template>
    <v-container class="py-10 d-flex justify-center align-center ">
        <v-row class="justify-center" style="max-width: 800px; width: 100%">
            <v-col cols="12">
                <v-card elevation="4" class="rounded-xl pa-4">
                    <v-card-title class="text-h5 font-weight-bold mb-2 text-primary">
                        🧾 Order Details
                    </v-card-title>

                    <v-divider class="mb-4"></v-divider>

                    <v-card-text v-if="!loading">
                        <v-row>
                            <v-col cols="12" md="6">
                                <strong>Order Number:</strong> {{ order.order_num }}
                            </v-col>
                            <v-col cols="12" md="6">
                                <strong>Date:</strong> {{ order.created_at }}
                            </v-col>
                            <v-col cols="12" md="6">
                                <strong>Status:</strong>
                                <v-chip
                                    :color="statusColor(order.status)"
                                    variant="flat"
                                    class="text-uppercase"
                                    size="small"
                                >
                                    {{ order.status }}
                                </v-chip>
                            </v-col>
                            <v-col cols="12" md="6">
                                <strong>Total:</strong>
                                <span class="text-success fw-bold">
                                  {{ order.total }} EGP
                                </span>
                            </v-col>
                            <v-col cols="12">
                                <strong>Transaction ID:</strong> {{ order.transaction_id }}
                            </v-col>
                        </v-row>

                        <v-divider class="my-5"></v-divider>

                        <h3 class="text-h6 mb-3 font-weight-bold">🛒 Products</h3>

                        <v-table density="compact" class="rounded-lg">
                            <thead>
                            <tr>
                                <th class="text-left">#</th>
                                <th class="text-left">Name</th>
                                <th class="text-left">Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(product, index) in order.products" :key="product.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.pivot.quantity }}</td>
                            </tr>
                            </tbody>
                        </v-table>
                    </v-card-text>

                    <v-skeleton-loader v-else type="card"></v-skeleton-loader>

                    <v-card-actions class="d-flex justify-end mt-3">
                        <v-btn color="primary" variant="flat" @click="printOrder(order.order_num)">
                            <v-icon start>mdi-printer</v-icon>
                            Print
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "OrderDetails",
    data() {
        return {
            loading: false,
            id: null,
        };
    },
    computed: {
        order() {
            return this.$store.getters["orders/order"];
        },
    },
    mounted() {
        this.id = this.$route.params.id;
        this.loading = true;
        this.$store.dispatch("orders/getOrder", this.id).finally(() => {
            this.loading = false;
        });
    },
    methods: {
        printOrder(orderNum) {
            window.print();
        },
        statusColor(status) {
            switch (status) {
                case "pending":
                    return "warning";
                case "completed":
                    return "success";
                case "cancelled":
                    return "error";
                default:
                    return "grey";
            }
        },
    },
};
</script>

<style scoped>


.fw-bold {
    font-weight: bold;
}
</style>
