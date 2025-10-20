<template>
    <card-component
        :title="'Register'"
        :subtitle="'Create a new account to start using our app.'"
        class="content register"
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
                v-model="state.name"
                :error-messages="v$.name.$errors.map((e) => e.$message)"
                label="Name"
                type="text"
                required
                @blur="v$.name.$touch"
                @input="v$.name.$touch"
                class="mx-auto mb-5"
                autocomplete="name"
            ></v-text-field>

            <v-text-field
                v-model="state.email"
                :error-messages="v$.email.$errors.map((e) => e.$message)"
                label="E-mail"
                required
                @blur="v$.email.$touch"
                @input="v$.email.$touch"
                type="email"
                class="mx-auto mb-5"
                autocomplete="email"
            ></v-text-field>

            <v-text-field
                v-model="state.password"
                :error-messages="v$.password.$errors.map((e) => e.$message)"
                label="Password"
                type="password"
                required
                @blur="v$.password.$touch"
                @input="v$.password.$touch"
                class="mx-auto mb-5"
                autocomplete="password"
            ></v-text-field>

            <v-text-field
                v-model="state.confirmPassword"
                :error-messages="v$.confirmPassword.$errors.map((e) => e.$message)"
                label="Confirm Password"
                type="password"
                required
                @blur="v$.confirmPassword.$touch"
                @input="v$.confirmPassword.$touch"
                class="mx-auto mb-5"
                autocomplete="current-password"
            ></v-text-field>

            <v-btn
                class="me-4"
                @click="v$.$validate()"
                color="primary"
                type="submit"
                :loading="loading"
            >
                submit
            </v-btn>

            <v-btn @click="clear" color="red"> clear </v-btn>

            <v-row class="justify-space-between">
                <v-col cols="12" class="pa-2">
                    <v-card-text class="text-center">
                        Have an account?
                        <router-link
                            :to="{ name: 'login' }"
                            class="text-primary text-decoration-none hover:underline text-right"
                        >
                            Sign in
                        </router-link>
                    </v-card-text>
                </v-col>
            </v-row>
        </form>
    </card-component>
</template>

<script>
import { reactive, computed } from "vue";
import useVuelidate from "@vuelidate/core";
import { email, required, sameAs, helpers } from "@vuelidate/validators";
import CardComponent from "@/components/CardComponent.vue";
// import { register } from "@/axios/authService";

export default {
    name: "RegisterView",
    components: { CardComponent },
    data() {
        return {
            loading: false,
            error: null,
        };
    },
    setup() {
        // setup() is still used for Vuelidate because Options API uses it internally
        const initialState = {
            password: "",
            email: "",
            name: "",
            confirmPassword: "",
        };

        const state = reactive({ ...initialState });
        const passwordRef = computed(() => state.password);

        const rules = {
            email: { required, email },
            password: { required },
            confirmPassword: {
                required,
                sameAsPassword: helpers.withMessage(
                    "Passwords do not match",
                    sameAs(passwordRef)
                ),
            },
            name: { required },
        };

        const v$ = useVuelidate(rules, state);
        return { state, v$, initialState };
    },

    methods: {
        clear() {
            this.v$.$reset();
            for (const key in this.initialState) {
                this.state[key] = this.initialState[key];
            }
        },

        async submit() {
            await this.v$.$validate();
            if (this.v$.$invalid) return;
            this.loading = true;
            this.error = null;
            try {
                // const user = await register({
                //     email: this.state.email,
                //     password: this.state.password,
                //     name: this.state.name,
                //     password_confirmation: this.state.confirmPassword,
                // });
                // if (user?.token) {
                //     localStorage.setItem("token", user.token);
                //     this.$router.push({ name: "home" });
                // } else {
                //     throw new Error("Invalid server response.");
                // }
            } catch (err) {
                console.error(err);
                if (err) {
                    const data = err?.response?.data || err;

                    if (data?.email) this.error = data.email;
                    else if (data?.password) this.error = data.password;
                    else if (typeof data?.message === "string") this.error = data.message;
                    else this.error = "Registration failed. Please try again.";
                }
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

