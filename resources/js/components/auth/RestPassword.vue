<template>
        <card-component
            :title="'Reset Password'"
            :subtitle="'Enter your email to recover your password.'"
            class="content"
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
                                to="/"
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
import {email, required} from "@vuelidate/validators";
import {useVuelidate} from "@vuelidate/core";
import CardComponent from "@/components/CardComponent.vue";
import api from "@/axios";
export default {
    name: "RecoverPassword",
    components: { CardComponent },

    data() {
        return {
            state: {
                email: "",
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
            this.error = null;
        },
        async submit() {
            await this.v$.$validate();
            if (this.v$.$invalid) return;
            this.loading = true;

            try {
                const user = await api.post('/api/recover-password', {
                    email: this.state.email,
                });
                console.log(user)

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
