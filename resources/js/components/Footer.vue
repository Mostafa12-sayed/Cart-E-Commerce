<template>
    <footer class="footer mt-10 py-8">
        <v-container>
            <v-row>
                <v-col cols="12" md="4" class="mb-4 mb-md-0">
                    <h5 class="font-weight-bold mb-3">Online Shop</h5>
                    <p class="text-muted">Your favorite online store for amazing deals and products.</p>
                </v-col>

                <v-col cols="6" md="2">
                    <h6 class="font-weight-bold mb-2">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><router-link to="/" class="footer-link">Home</router-link></li>
                        <li><router-link to="/shop" class="footer-link">Shop</router-link></li>
                        <li><router-link to="/contact" class="footer-link">Contact</router-link></li>
                    </ul>
                </v-col>

                <v-col cols="6" md="2">
                    <h6 class="font-weight-bold mb-2">Support</h6>
                    <ul class="list-unstyled">
                        <li><router-link to="/faq" class="footer-link">FAQ</router-link></li>
                        <li><router-link to="/returns" class="footer-link">Returns</router-link></li>
                        <li><router-link to="/privacy" class="footer-link">Privacy Policy</router-link></li>
                    </ul>
                </v-col>

                <v-col cols="12" md="4" class="text-md-start">
                    <h6 class="font-weight-bold mb-3">Follow Us</h6>
                    <v-btn icon="mdi-facebook" variant="text"></v-btn>
                    <v-btn icon="mdi-twitter" variant="text"></v-btn>
                    <v-btn icon="mdi-instagram" variant="text"></v-btn>
                    <v-btn icon="mdi-youtube" variant="text"></v-btn>
                </v-col>
            </v-row>

            <v-divider class="my-4"></v-divider>

            <p class="text-center text-grey mb-0">
                © {{ new Date().getFullYear() }} Online Shop. All rights reserved.
            </p>
        </v-container>
    </footer>

</template>
<script>
export default {
    name: "Footer"
}
</script>



<style scoped>
.footer {
    background: #111;
    color: #ddd;
}
.footer-link {
    color: #ccc;
    text-decoration: none;
}
.footer-link:hover {
    color: white;
}
</style>
