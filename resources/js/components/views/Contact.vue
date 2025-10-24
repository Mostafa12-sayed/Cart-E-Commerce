<template>
    <v-container class="py-10 contact-page">
        <h1 class="text-center mb-8 font-weight-bold">Contact Us</h1>

        <v-row align="center" justify="center">
            <!-- الصورة -->
            <v-col cols="12" md="5" class="d-flex justify-center mb-6 mb-md-0">
                <v-img
                    src="./assets/images/contact_us.png"
                    alt="Contact Illustration"
                    max-width="400"
                ></v-img>
            </v-col>

            <!-- نموذج التواصل -->
            <v-col cols="12" md="6">
                <v-card class="pa-6" elevation="8">
                    <v-form @submit.prevent="submitForm" v-model="valid">
                        <v-text-field
                            v-model="form.name"
                            label="Full Name"
                            prepend-icon="mdi-account"
                            :rules="[v => !!v || 'Name is required']"
                            required
                            variant="underlined"
                        ></v-text-field>

                        <v-text-field
                            v-model="form.email"
                            label="Email"
                            prepend-icon="mdi-email"
                            :rules="[v => /.+@.+\..+/.test(v) || 'Valid email required']"
                            required
                            variant="underlined"
                        ></v-text-field>

                        <v-textarea
                            v-model="form.message"
                            label="Message"
                            prepend-icon="mdi-message"
                            :rules="[v => !!v || 'Message is required']"
                            rows="4"
                            required
                            variant="underlined"
                        ></v-textarea>

                        <v-btn
                            type="submit"
                            color="primary"
                            class="mt-4 px-6"
                            :loading="loading"
                        >
                            Send Message
                        </v-btn>
                    </v-form>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import api from "@/axios";
import {useToast} from "vue-toastification";
export default {
    name: "Contact",
    data() {
        return {
            valid: false,
            loading: false,
            form: {
                name: "",
                email: "",
                message: "",
            },
        };
    },
    setup(){
        const toast = useToast()

        return {toast};
    },
    methods: {
        async submitForm() {
            if (!this.valid) return;
            this.loading = true;

            try {
                const res = await api.post("/api/contact", this.form);
                if(res.data.success){
                    this.toast.success("Message sent successfully");
                    this.form = { name: "", email: "", message: "" };
                }
                else {
                    this.toast.error(res.data.message);
                }
            } catch (err) {
                console.error(err);
                this.toast.error(res.data.message);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.contact-page {
    background-color: #f9fafb;
}

.v-card {
    border-radius: 16px;
}

h1 {
    color: #1867c0;
    font-weight: 700;
}

/* Responsiveness */
@media (max-width: 768px) {
    .contact-page h1 {
        font-size: 1.8rem;
    }
}
</style>
