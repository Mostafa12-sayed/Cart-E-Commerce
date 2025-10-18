<template>
    <div class="container">
        <Navbar/>
        <router-view> </router-view>
    </div>
</template>

<script>
import Navbar from './Navbar.vue'

export default {
    name: 'App',
    components: {
        Navbar
    }
}
</script>
