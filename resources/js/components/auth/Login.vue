<template>
    <card-component
        :title="'Login'"
        :subtitle="'Enter your email and password to login.'"
        class="center-container"
    >
        <v-alert
            v-if="error"
            type="error"
            class="mt-4 mb-4 text-left"
            border="start"
            variant="tonal"
            closable
        >
            {{ error }}
        </v-alert>
        <form @submit.prevent="submit">
            <v-text-field
                v-model="state.email"
                :error-messages="v$?.state.email.$errors.map((e) => e.$message)"
                label="E-mail"
                required
                @blur="v$.state.email.$touch"
                @input="v$.state.email.$touch"
                type="email"
                class="mx-auto mb-5"
                autocomplete="email"
            ></v-text-field>

            <v-text-field
                v-model="state.password"
                :error-messages="v$?.state.password.$errors.map((e) => e.$message)"
                label="Password"
                type="password"
                required
                @blur="v$.state.password.$touch"
                @input="v$.state.password.$touch"
                class="mx-auto mb-5"
                autocomplete="current-password"
            ></v-text-field>

            <v-btn
                class="me-4"
                @click="v$.$validate"
                color="primary"
                type="submit"
                :loading="loading"
            >
                Submit
            </v-btn>
            <v-btn @click="clear" color="red">Clear</v-btn>

            <v-row class="justify-space-between mt-3">
                <v-col cols="6" class="pa-2">
                    <v-card-text class="text-left">
                        Forgot password?
                        <router-link
                            :to="{ name: 'recover-password' }"
                            class="text-primary text-decoration-none hover:underline"
                        >
                            Recover
                        </router-link>
                    </v-card-text>
                </v-col>

                <v-col cols="6" class="pa-2">
                    <v-card-text class="text-right">
                        Not registered?
                        <router-link
                            :to="{ name: 'register' }"
                            class="text-primary text-decoration-none hover:underline text-right"
                        >Sign up</router-link
                        >
                    </v-card-text>
                </v-col>

            </v-row>
        </form>
    </card-component>
</template>

<script>
import { useVuelidate } from "@vuelidate/core";
import { email, required } from "@vuelidate/validators";
import CardComponent from "@/components/CardComponent.vue";
// import { login } from "@/axios/authService";
import api from "@/axios";

export default {
    name: "LoginView",
    components: { CardComponent },

    data() {
        return {
            state: {
                email: "",
                password: "",
            },
            error: null,
            v$: null,
            loading: false,
        };
    },

    validations() {
        return {
            state: {
                email: { required, email },
                password: { required },
            },
        };
    },
    created() {
        this.v$ = useVuelidate(this.$options.validations.call(this), this);
    },
    methods: {
        clear() {
            this.v$.$reset();
            this.state.email = "";
            this.state.password = "";
            this.error = null;
        },
        async submit() {
            await this.v$.$validate();
            if (this.v$.$invalid) return;
            this.loading = true;

            try {
                await this.$store.dispatch("login", {
                    email: this.state.email,
                    password: this.state.password,
                });

                if (this.$store.getters["authenticated"]) {
                    // 🔙 رجع المستخدم للصفحة السابقة إن وُجدت
                    const previous = localStorage.getItem("previous_url") || "/";
                    localStorage.removeItem("previous_url");
                    this.$router.push(previous);
                }
            } catch (err) {
                this.error = err.response?.data?.message || "Login failed";
            } finally {
                this.loading = false;
            }
        }

    },

};
</script>

<style lang="scss" scoped>
#app {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    min-height: 100vh !important;
    justify-content: center !important;
}
</style>
