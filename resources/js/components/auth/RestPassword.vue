<template>
        <card-component
            :title="'Reset Password'"
            :subtitle="'Enter your email to recover your password.'"
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
                    @click="v$.$validate"
                    color="primary"
                    type="submit"
                    :loading="loading"
                >
                    Submit
                </v-btn>


            </form>
        </card-component>

</template>


<script>
import {email, helpers, required, sameAs} from "@vuelidate/validators";
import {useVuelidate} from "@vuelidate/core";
import CardComponent from "@/components/CardComponent.vue";
import api from "@/axios";
import {computed, reactive} from "vue";
import { useRoute, useRouter } from "vue-router";
import {useToast} from "vue-toastification";

export default {

    name: "RecoverPassword",
    components: { CardComponent },

    data() {
        return {

            error: null,
            loading: false,
        };
    },
    setup() {
        const route = useRoute();
        const router = useRouter();
        // setup() is still used for Vuelidate because Options API uses it internally
        const initialState = {
            password: "",
            email: route.query.email || "",
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
        };

            const toast = useToast()



        const v$ = useVuelidate(rules, state);
        return { state, v$, route, router ,toast };
    },

    methods: {
        clear() {
            this.v$.$reset();
            this.state.email = "";
            this.error = null;
        },
        async submit() {
            await this.v$.$validate();
            if (this.v$.$invalid) return;
            this.loading = true;
            try {
                const user = await api.post('/api/reset-password', {
                    email: this.state.email,
                    token: this.$route.query.token,
                    password: this.state.password,
                    password_confirmation: this.state.confirmPassword,
                });

                if(user.data.success)
                {
                    this.$router.push({name :'login'})
                    this.toast.success(user.data.message);
                }

            } catch (err) {
                console.log(err)
            } finally {
                this.loading = false;
            }
        }

    },
}
</script>



<style scoped>

</style>
