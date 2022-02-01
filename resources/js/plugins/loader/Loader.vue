<template>
  <v-overlay
    v-if="$store.getters['Dashboard/loading']"
    z-index="10"
    color="#000000"
    opacity=".6"
  >
    <spinner :animation-duration="2500" :size="65" />
  </v-overlay>
</template>

<script>
import { HalfCircleSpinner as spinner } from "epic-spinners";
export default {
  name: "Loader",
  components: {
    spinner,
  },
};
</script>

<style scoped></style>
