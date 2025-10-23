<template>
        <card-component
            :title="'Recover Password'"
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
            <p v-if="message">{{ message }}</p>

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

            </form>
        </card-component>

</template>


<script>
import {email, required} from "@vuelidate/validators";
import {useVuelidate} from "@vuelidate/core";
import CardComponent from "@/components/CardComponent.vue";
import api from "@/axios";
import { useToast } from 'vue-toastification'

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
            message: null,
        };
    },
    setup(){
        const toast = useToast()

        return {toast};
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
        async submit() {
            await this.v$.$validate();
            if (this.v$.$invalid) return;
            this.loading = true;

            try {
                const res = await api.post("/api/forgot-password", { email: this.state.email });
                this.error = null;
                this.$router.push({name: 'login'})
                this.toast.success(res.data.message);
            } catch (err) {
                this.error = err.response?.data?.error || "Something went wrong";
            }
            finally {
                this.loading = false;
            }
        }

    },
}
</script>



<style scoped>

</style>
