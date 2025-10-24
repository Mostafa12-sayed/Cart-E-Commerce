<template>
    <v-container class="py-10">
        <h1 class="text-center mb-8 font-weight-bold">Frequently Asked Questions</h1>

        <v-expansion-panels>
            <v-expansion-panel v-for="(item, i) in faqs" :key="i">
                <v-expansion-panel-title>{{ item.question }}</v-expansion-panel-title>
                <v-expansion-panel-text>{{ item.answer }}</v-expansion-panel-text>
            </v-expansion-panel>
        </v-expansion-panels>
    </v-container>
</template>

<script>
export default {
    name: "Faq",
    data() {
        return {
            faqs: [
                {
                    question: "How long does shipping take?",
                    answer:
                        "Orders are typically processed within 1–2 business days and delivered within 5–7 days depending on your location.",
                },
                {
                    question: "Can I return an item?",
                    answer:
                        "Yes, you can return most items within 14 days of delivery as long as they are in original condition.",
                },
                {
                    question: "Do you offer international shipping?",
                    answer: "Currently, we only ship within select countries. Please check during checkout.",
                },
            ],
        };
    },
};
</script>
