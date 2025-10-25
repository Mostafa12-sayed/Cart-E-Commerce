<template>
    <v-container class="fill-height d-flex align-center justify-center">
        <v-row justify="center" align="center">
            <v-col cols="12" md="8" class="text-center">
                <v-card elevation="6" class="pa-10 rounded-xl">
                    <v-card-title class="justify-center">
                        <v-icon size="80" color="error" class="mb-3">mdi-alert-circle-outline</v-icon>
                    </v-card-title>

                    <v-card-text>
                        <h1 class="text-h2 font-weight-bold mb-3">404</h1>
                        <p class="text-h6 text-medium-emphasis mb-6">
                            Oops! The page you’re looking for doesn’t exist or has been moved.
                        </p>
                        <v-btn
                            color="primary"
                            size="large"
                            rounded="xl"
                            to="/"
                        >
                            <v-icon start>mdi-home</v-icon>
                            Go Back Home
                        </v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
// No special logic needed
</script>

<style scoped>
.fill-height {
    min-height: 100vh;
    //background: linear-gradient(135deg, #E3F2FD, #E8EAF6);
}
</style>
