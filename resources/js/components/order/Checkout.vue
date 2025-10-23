<template>
    <!-- 🛒 لو الكارت فاضي -->
    <div v-if="!cart.length" class="content checkout container-fluid py-5">
        <EmptyCart />
    </div>

    <!-- 🛍️ لو فيه منتجات -->
    <div v-else class="content checkout container py-5 rounded cart">
        <div class="row">
            <!-- 🧾 Cart Items -->
            <div   :class="user ? 'col-md-8' : 'col-md-12'">
                <div class="product-details">
                    <div class="d-flex align-items-center mb-3">
                        <a

                            @click="this.$router.push({name:'products.index'})"
                        >
                            <v-icon>mdi-arrow-left</v-icon>
                            <span class="ms-2">Continue Shopping</span>
                        </a>

                    </div>

                    <hr />
                    <h5 class="fw-bold">Shopping Cart</h5>
                    <p class="text-muted">You have {{ cart.length }} items in your cart</p>

                    <!-- 🧾 Loop Items -->
                    <div
                        v-for="item in cart"
                        :key="item.id"
                        class="d-flex justify-content-between align-items-center mt-3 p-3 bg-light rounded"
                    >
                        <div class="d-flex align-items-center">
                            <img :src="item.image" width="60" class="rounded me-3" />
                            <div>
                                <h6 class="fw-bold mb-1">{{ item.name }}</h6>
                                <small class="text-muted">${{ item.price }}</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <v-btn
                                size="x-small"
                                icon="mdi-minus"
                                variant="tonal"
                                color="primary"
                                @click="decrement(item.id)"
                                :disabled="item.quantity === 1"
                            ></v-btn>

                            <span class="mx-3 fw-semibold">{{ item.quantity }}</span>

                            <v-btn
                                size="x-small"
                                icon="mdi-plus"
                                variant="tonal"
                                color="primary"
                                @click="increment(item.id)"
                            ></v-btn>

                            <span class="mx-4 fw-bold">{{ cartLineTotal(item) }}</span>

                            <v-btn
                                variant="text"
                                icon
                                color="red"
                                @click="removeFromCart(item.id)"
                                :loading="loadingId === item.id"
                            >
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 💳 Checkout & Payment -->
            <div class="col-md-4 mt-4 mt-md-0"  v-if="cart.length && user">
                <div class="payment-info bg-light p-4 rounded shadow-sm">

                        <v-card elevation="4" class="p-4 border rounded-3">
                            <v-card-title>Checkout Details</v-card-title>
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="customer.first_name"
                                        :disabled="paymentProcessing"
                                        :class="{ 'is-invalid': errorFor('customer.first_name') }"
                                    />
                                    <small class="form-error">{{ errorFor("customer.first_name") }}</small>
                                </div>

                                <div class="col-md-6">
                                    <label>Last Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="customer.last_name"
                                        :disabled="paymentProcessing"
                                        :class="{ 'is-invalid': errorFor('customer.last_name') }"
                                    />
                                    <small class="form-error">{{ errorFor("customer.last_name") }}</small>
                                </div>

                                <div class="col-md-12">
                                    <label>Email</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        v-model="customer.email"
                                        :disabled="paymentProcessing"
                                        :class="{ 'is-invalid': errorFor('customer.email') }"
                                    />
                                    <small class="form-error">{{ errorFor("customer.email") }}</small>
                                </div>

                                <div class="col-md-6">
                                    <label>Address</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="customer.address"
                                        :disabled="paymentProcessing"
                                        :class="{ 'is-invalid': errorFor('customer.address') }"
                                    />
                                    <small class="form-error">{{ errorFor("customer.address") }}</small>
                                </div>

                                <div class="col-md-6">
                                    <label>City</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="customer.city"
                                        :disabled="paymentProcessing"
                                        :class="{ 'is-invalid': errorFor('customer.city') }"
                                    />
                                    <small class="form-error">{{ errorFor("customer.city") }}</small>
                                </div>

                                <div class="col-md-6">
                                    <label>State</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="customer.state"
                                        :disabled="paymentProcessing"
                                        :class="{ 'is-invalid': errorFor('customer.state') }"
                                    />
                                    <small class="form-error">{{ errorFor("customer.state") }}</small>
                                </div>

                                <div class="col-md-6">
                                    <label>Zip</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="customer.zip_code"
                                        :disabled="paymentProcessing"
                                        :class="{ 'is-invalid': errorFor('customer.zip_code') }"
                                    />
                                    <small class="form-error">{{ errorFor("customer.zip_code") }}</small>
                                </div>

                                <div class="col-md-12">
                                    <label>Credit Card Info</label>
                                    <div id="card-element"></div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <v-btn
                                    class="mt-4 w-100"
                                    color="primary"
                                    rounded="xl"
                                    size="large"
                                    @click="processPayment"
                                    :loading="paymentProcessing"
                                    :disabled="paymentProcessing"
                                >
                                    <div class="w-100 d-flex justify-content-between align-items-center">
                                        <span>{{ cartTotal }}</span>
                                        <span class="mx-2"> Checkout <v-icon class="ms-1">mdi-arrow-right</v-icon></span>
                                    </div>
                                </v-btn>

                            </div>
                        </v-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { loadStripe } from "@stripe/stripe-js";
import EmptyCart from "@/components/order/EmptyCart.vue";
import Dialog from "@/components/auth/Dialog.vue";
import Login from "@/components/auth/Login.vue";
export default {
    components: {EmptyCart ,Dialog ,Login},
    data() {
        return {
            Login,
            stripe: {},
            cardElement: {},
            customer: {
                first_name: "",
                last_name: "",
                email: "",
                address: "",
                city: "",
                state: "",
                zip_code: "",
            },
            paymentProcessing: false,
            errors: null,
            loadingId: null,
            loading: true,
        };
    },
    async mounted() {
        if (this.user) {

            this.stripe = await loadStripe(
                "pk_test_51Q4An8JxKanq2TbilPjmldmgemSmUwkqwtAmcaepsVpfE2jjMshS0JnpTSFurAtZvgANuWNxhb0KjOXi4ghPkN5P001Qea9jJL"
            );
            const elements = this.stripe.elements();
            this.cardElement = elements.create("card", {
                classes: {
                    base: "form-control",
                },
            });
            this.cardElement.mount("#card-element");
        }

    },
    methods: {
        cartLineTotal(item) {
            let amount = item.price * item.quantity;
            amount = amount / 100;
            return amount.toLocaleString("en-US", {
                style: "currency",
                currency: "USD",
            });
        },
        async processPayment() {
            this.paymentProcessing = true;

            const { paymentMethod, error } =
                await this.stripe.createPaymentMethod(
                    "card",
                    this.cardElement,
                    {
                        billing_details: {
                            name:
                                this.customer.first_name +
                                " " +
                                this.customer.last_name,
                            email: this.customer.email,
                            address: {
                                line1: this.customer.address,
                                city: this.customer.city,
                                state: this.customer.state,
                                postal_code: this.customer.zip_code,
                            },
                        },
                    }
                );

            if (error) {
                this.paymentProcessing = false;
                console.error(error);
            } else {
                console.log(paymentMethod);
                this.customer.payment_method_id = paymentMethod.id;
                this.customer.amount = this.$store.state.cart.reduce(
                    (acc, item) => acc + item.price * item.quantity,
                    0
                );
                this.customer.cart = JSON.stringify(this.$store.state.cart);

                axios
                    .post("/api/purchase", this.customer)
                    .then((response) => {
                        this.paymentProcessing = false;
                        console.log(response);

                        this.$store.commit("setOrder", response.data);
                        this.$store.dispatch("clearCart");

                        this.$router.push({ name: "order.summary" });
                    })
                    .catch((error) => {
                        this.paymentProcessing = false;
                        console.error(error);
                    });
            }
        },
        errorFor(field) {
            return this.errors != null && this.errors[field]
                ? this.errors[field][0]
                : null;
        },
        removeFromCart(index) {
            console.log(index);
            this.loadingId = index;
            this.$store.dispatch("removeFromCart", index).then(() => {
                this.loadingId = null;
            });
            this.loadingRemove = true;
        },
        increment(id) {
            this.$store.dispatch("increment", id);
        },
        decrement(id) {
            this.$store.dispatch("decrement", id);
        },

    },

    computed: {
        cart() {
            return this.$store.state.cart;
        },
        cartQuantity() {
            var items = this.$store.state.cart;
            var acc = 0;
            for (let i = 0; i < items.length; i++) {
                acc += items[i].quantity;
            }
            return acc;
        },

        cartTotal() {
            let amount = this.$store.state.cartTotal;
            // amount = amount / 100;
            return amount.toLocaleString("en-US", {
                style: "currency",
                currency: "USD",
            });
        },
        user() {
            return this.$store.getters.authenticated;
        },
    },
};
</script>
<style scoped>
input {
    border: 1px solid #b6b6b6 !important;
}

label {
    color: #000 !important;
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: 5px;
}

#card-element {
    padding: 10px;
    border: 1px solid #b6b6b6;
    border-radius: 6px;
}

/* Table responsiveness */
.table-responsive {
    overflow-x: auto;
}

.table th,
.table td {
    vertical-align: middle !important;
    white-space: nowrap;
}

/* Mobile adjustments */
@media (max-width: 768px) {
    h2 {
        font-size: 1.4rem;
    }

    .table th,
    .table td {
        font-size: 0.85rem;
        padding: 0.6rem;
    }

    .v-btn {
        transform: scale(0.9);
    }

    .form-control {
        font-size: 0.9rem;
    }
}

/* Extra small screens */
@media (max-width: 576px) {
    .checkout {
        padding: 0 1rem;
    }

    .v-btn {
        min-width: 35px !important;
    }
}
.card-img{
    width:40px;
    height:40px;
    margin-right: 10px;
}
.btn{
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    margin: 20px auto;
}



.payment-info {
    background: blue;
    padding: 10px;
    border-radius: 6px;
    color: #fff;
    font-weight: bold;
}

.product-details {
    padding: 10px;
}

body {
    background: #eee;
}

.cart {
    background: #fff;
}

.p-about {
    font-size: 12px;
}

.table-shadow {
    -webkit-box-shadow: 5px 5px 15px -2px rgba(0,0,0,0.42);
    box-shadow: 5px 5px 15px -2px rgba(0,0,0,0.42);
}

.type {
    font-weight: 400;
    font-size: 10px;
}

label.radio {
    cursor: pointer;
}

label.radio input {
    position: absolute;
    top: 0;
    left: 0;
    visibility: hidden;
    pointer-events: none;
}

label.radio span {
    padding: 1px 12px;
    border: 2px solid #ada9a9;
    display: inline-block;
    color: #8f37aa;
    border-radius: 3px;
    text-transform: uppercase;
    font-size: 11px;
    font-weight: 300;
}

label.radio input:checked + span {
    border-color: #fff;
    background-color: blue;
    color: #fff;
}

.credit-inputs {
    background: rgb(102,102,221);
    color: #fff !important;
    border-color: rgb(102,102,221);
}

.credit-inputs::placeholder {
    color: #fff;
    font-size: 13px;
}

.credit-card-label {
    font-size: 9px;
    font-weight: 300;
}

.form-control.credit-inputs:focus {
    background: rgb(102,102,221);
    border: rgb(102,102,221);
}

.line {
    border-bottom: 1px solid rgb(102,102,221);
}

.information span {
    font-size: 12px;
    font-weight: 500;
}

.information {
    margin-bottom: 5px;
}

.items {
    -webkit-box-shadow: 5px 5px 4px -1px rgba(0,0,0,0.25);
    box-shadow: 5px 5px 4px -1px rgba(0, 0, 0, 0.08);
}

.spec {
    font-size: 11px;
}





</style>
