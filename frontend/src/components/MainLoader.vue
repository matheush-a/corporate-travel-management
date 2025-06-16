<template>
  <div class="wrapper">
    <div class="loader"></div>
  </div>
</template>

<script>
export default {
  name: 'MainLoader',
}
</script>

<style lang="scss" scoped>
@media (prefers-color-scheme: light) {
  .wrapper {
    background-color: var(--white);
  }
}

.wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  position: absolute;
  overflow: hidden;
  z-index: 999999;
  width: 100%;
  background-color: var(--black);
}

.loader {
  width: 70px;
  height: 70px;
  border: 8px solid rgba(255, 255, 255, 0.2);
  border-top-color: var(--white);
  border-radius: 50%;
  animation: spin 1s linear infinite;
  user-select: none;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
