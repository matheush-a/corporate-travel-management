<template>
  <svg
      :height="size" 
      :width="size" 
      viewBox="0 -960 960 960" 
      fill="none"
      xmlns="http://www.w3.org/2000/svg">
      <path d="m40-120 440-760 440 760H40Zm138-80h604L480-720 178-200Zm302-40q17 0 28.5-11.5T520-280q0-17-11.5-28.5T480-320q-17 0-28.5 11.5T440-280q0 17 11.5 28.5T480-240Zm-40-120h80v-200h-80v200Zm40-100Z"
      :fill=color
    />
  </svg>
</template>

<script>
export default {
  props: {
    color: {
      type: String,
      default: "white",
    },
    size: {
      type: String,
      default: "24px",
    },
  },
};
</script>

<style scoped>
svg {
  cursor: default;
}
</style>
