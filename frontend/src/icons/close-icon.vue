<template>
  <svg 
    :width="size"
    :height="size"
    viewBox="0 -960 960 960"
    fill="none"
    xmlns="http://www.w3.org/2000/svg">
    <path 
    d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"
    :fill="color"
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
  cursor: pointer;
}
</style>
