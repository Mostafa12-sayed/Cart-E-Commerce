<template>
    <v-container>
        <v-row justify="space-around">

            <v-col cols="12" md="6">
                <v-dialog
                    transition="dialog-top-transition"
                    width="auto"
                >
<!--                    <template v-slot:activator="{ props: activatorProps }">-->
<!--                        <v-btn-->
<!--                            v-bind="activatorProps"-->
<!--                            text="Transition from Top"-->
<!--                            block-->
<!--                        ></v-btn>-->
<!--                    </template>-->
                    <template v-slot:activator="{ props: activatorProps }">

<!--                                <Login />-->
                        <slot name="activator" v-bind="activatorProps"></slot>

                    </template>
                </v-dialog>
            </v-col>
        </v-row>
    </v-container>
</template>


<script>
import { ref } from 'vue'
import Login from "@/components/auth/Login.vue";
export default {
    name: "Dialog.vue",
    components:{Login},
    setup(){

        const dialog = ref(false)
    }
}
</script>



<style scoped>

</style>
