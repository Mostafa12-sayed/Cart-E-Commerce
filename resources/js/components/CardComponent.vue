<template>
  <v-container class="mx-auto h-100">
    <v-card class="mx-auto pa-8" elevation-24 max-width="500" hover>
      <v-card-item>
        <v-card-title class="text-h4 font-weight-bold">{{
          title
        }}</v-card-title>
        <v-card-subtitle>{{ subtitle }} </v-card-subtitle>
      </v-card-item>

      <slot></slot>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: "CardComponent",
  props: {
    title: {
      type: String,
      required: true,
    },
    subtitle: {
      type: String,
      required: true,
    },
  },
};
</script>
