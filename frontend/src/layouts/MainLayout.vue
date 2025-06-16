<template>
  <ToastDefault />
  <MainLoader v-if="isLoading" />

  <header v-if="showHeader">
    <div class="logo-wrapper">
      <img src="../../public/favicon.svg" alt="Logo" class="logo">
      CTM
    </div>
    <button @click="logout">Logout</button>
  </header>

  <section class="main-wrapper">
    <slot name="content"></slot>
  </section>
</template>

<script>
import MainLoader from '@/components/MainLoader.vue';
import loaderState from '@/state/loader.js';
import { ref, watch } from 'vue';
import ToastDefault from '@/components/ToastDefault.vue';

export default {
  name: 'MainLayout',
  components: {
    MainLoader,
    ToastDefault,
  },
  props: {
    showHeader: {
      type: Boolean,
      default: false,
    }
  },
  methods: {
    logout() {
      localStorage.removeItem('token');
      this.$router.push({ name: 'LoginView' });
    }
  },
  setup() {
    const isLoading = ref(loaderState.isLoading);

    watch(
      () => loaderState.isLoading,
      (newValue) => {
        isLoading.value = newValue;
      },
      {
        immediate: true,
        deep: true,
      }
    );

    return {
      isLoading,
    }
  },
}
</script>

<style lang="scss" scoped>
main {
  height: 100vh;
  width: 100%;
}

header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem;

  .logo-wrapper {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
    gap: .5rem;
    font-size: 1.25rem;
    font-weight: 600;
    user-select: none;

    .logo {
      max-width: 40px;
    }
  }
}

.main-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 1.25rem;
  height: 100vh;
}
</style>
