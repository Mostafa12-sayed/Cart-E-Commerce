

<template>
    <v-container >
         <div class="orders-page" >
               <div class="orders-container">
                        <!-- Order Card -->
                        <div class="order-card" v-if="orders.length" v-for="order in orders" :key="order.id">
                            <div class="order-header">
                                <h3>Order #{{ order.order_num }}</h3>

                                <v-chip
                                    :color="statusColor(order.status)"
                                    variant="flat"
                                    class="text-uppercase"
                                    size="small"
                                >
                                    {{ order.status }}
                                </v-chip>
                            </div>
                            <div class="order-body">
                                <p><strong>Date:</strong> {{ order.created_at }}</p>
                                <p><strong>Total:</strong> ${{ order.total }}</p>
                                <p><strong>Payment Transaction ID:</strong> {{ order.transaction_id }}</p>
                            </div>
                            <div class="order-footer">
                                <button class="btn-view" @click="viewOrder(order.order_num)">View Details</button>
                            </div>
                        </div>
                        <div v-else>
                            <v-container class="d-flex justify-center align-center" style="height:70vh;">
                                <div class="text-center">
                                    <v-icon color="grey" size="64">mdi-package-variant</v-icon>
                                    <h3 class="text-grey-darken-1 mt-3">No Orders Found</h3>
                                    <p class="text-grey">You haven’t placed any orders yet.</p>
                                </div>
                            </v-container>
                        </div>
               </div>
         </div>
    </v-container>
</template>
<script>
export default {
    name: "MyOrder",

    computed: {
        orders() {
            return this.$store.getters["orders/orders"];
        },
    },
    created() {
        this.$store.dispatch("orders/getOrders");
    },
    methods:{
        viewOrder($id){
            this.$router.push({name: 'order.show', params: {id: $id}})
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

}
</script>
<style scoped>
/* Reset and base styles */
body {
    margin: 0;
    font-family: "Poppins", sans-serif;
    background-color: #f7f8fa;
    color: #333;
}

/* Fixed navbar */


/* Main container below navbar */
.orders-page {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: calc(100vh - 80px);
}

.orders-container {
    width: 90%;
    max-width: 800px;
}

/* Order card */
.order-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    padding: 20px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.order-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Header (title + status) */
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
}

.status {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.9rem;
}

.delivered {
    background-color: #4caf50;
    color: #fff;
}

.pending {
    background-color: #ff9800;
    color: #fff;
}

/* Body (order details) */
.order-body {
    margin: 15px 0;
}

/* Footer (action buttons) */
.order-footer {
    display: flex;
    justify-content: flex-end;
}

.btn-view {
    background-color: #3f51b5;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.btn-view:hover {
    background-color: #303f9f;
}

</style>
