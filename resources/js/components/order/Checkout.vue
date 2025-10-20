<template>
    <div class="content checkout container-fluid py-5">
        <div class="row justify-content-center">
            <!-- CART DETAILS -->
            <div class="col-lg-7 col-md-10 col-sm-12 mb-5">
                <div class="text-center mb-4">
                    <h2 class="text-muted fw-bold">Cart Details</h2>
                </div>

                <!-- Make table responsive -->
                <div class="table-responsive shadow-sm rounded">
                    <table class="table align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in cart" :key="item.id">
                                <td class="d-flex flex-row align-items-center p-3">
                                    <img
                                        class="card-img"
                                        :src="item?.image || 'https://dummyimage.com/20x10/fff/aaa'"
                                        alt="Vans"
                                    />
                                    <span>{{ item.name }}</span>
                                </td>
                                <td class="p-3 text-center">
                                    <v-btn
                                        size="x-small"
                                        @click="decrement(item.id)"
                                        icon="mdi-minus"
                                        :disabled="item.quantity === 1"
                                    ></v-btn>
                                    <span class="mx-3 fw-semibold">{{ item.quantity }}</span>
                                    <v-btn
                                        size="x-small"
                                        @click="increment(item.id)"
                                        icon="mdi-plus"
                                    ></v-btn>
                                </td>
                                <td class="p-3 text-center">
                                    {{ cartLineTotal(item) }}
                                </td>
                                <td class="p-3 text-center">
                                    <v-btn

                                        rounded="xl"
                                        @click="removeFromCart(item.id)"
                                        :loading="loadingId === item.id"
                                    >
                                        <v-icon color="red">mdi-delete</v-icon>
                                    </v-btn>
                                </td>
                            </tr>

                            <tr v-if="cart.length">
                                <td class="fw-bold">Total Amount</td>
                                <td class="fw-bold text-center">
                                    {{ $store.state.cartTotalQuantity }}
                                </td>
                                <td class="fw-bold text-center">
                                    {{ cartTotal }}
                                </td>
                                <td></td>
                            </tr>

                            <tr v-else>
                                <td colspan="4" class="text-center py-5 fw-bold text-muted">
                                    No Products added
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- CHECKOUT DETAILS -->
            <div class="col-lg-5 col-md-10 col-sm-12 mb-5" v-if="cart.length">
                <v-card elevation="2" class="p-4 border rounded-3">
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
                                type="text"
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
                            class="px-5 mt-3"
                            @click="processPayment"
                            :loading="paymentProcessing"
                            :disabled="paymentProcessing"
                            color="primary"
                        >
                            Pay Now
                        </v-btn>
                    </div>
                </v-card>
            </div>
        </div>
    </div>
</template>


<script>
import { loadStripe } from "@stripe/stripe-js";
export default {
    data() {
        return {
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
</style>
