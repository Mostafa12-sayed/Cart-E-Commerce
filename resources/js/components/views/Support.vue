<template>
    <v-container class="py-10">
        <h1 class="text-center mb-6 font-weight-bold">Support Center</h1>
        <p class="text-center text-grey mb-8">
            Need help? Find answers to common questions or reach out to our team.
        </p>

        <v-row class="justify-center">
            <v-col cols="12" md="8">
                <v-card class="pa-6 mb-6">
                    <v-card-title>Quick Help Links</v-card-title>
                    <v-divider></v-divider>
                    <v-list>
                        <v-list-item to="/faq" title="Frequently Asked Questions"></v-list-item>
                        <v-list-item to="/returns" title="Return & Refund Policy"></v-list-item>
                        <v-list-item to="/privacy" title="Privacy Policy"></v-list-item>
                        <v-list-item to="/contact" title="Contact Us"></v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "Support",
};
</script>
