<template>
  <div class="wrapper">
    <div 
      :class="{
      'toast': true,
      '--success': toastState.type === 'success',
      '--error': toastState.type === 'error',
      '--warning': toastState.type === 'warning',
      }"
      v-if="toastState.visible"
    >
      <component :is="getIcon()" class="icon" />
      {{ toastState.message }}
      <closeIcon @click="close"/>
    </div>
  </div>
</template>

<script>
import closeIcon from '@/icons/close-icon.vue';
import checkIcon from '@/icons/check-icon.vue';
import warningIcon from '@/icons/warning-icon.vue';
import errorIcon from '@/icons/error-icon.vue';
import toastState from '@/state/toast';

export default {
  name: 'ToastDefault',
  data() {
    return {
      toastState,
    }
  },
  props: {
    success: {
      type: Boolean,
      default: false,
    },
    warning: {
      type: Boolean,
      default: false,
    },
    error: {
      type: Boolean,
      default: false,
    },
    message: {
      type: String,
      default: '',
    },
  },
  components: {
    closeIcon,
    checkIcon,
    warningIcon,
    errorIcon,
  },
  methods: {
    getIcon() {
      if (this.toastState.type === 'success') {
        return checkIcon;
      }
      else if (this.toastState.type === 'warning') {
        return warningIcon;
      }
      else if (this.toastState.type === 'error') {
        return errorIcon;
      }
    },
    close() {
      this.toastState.visible = false;
    }
  }
}
</script>

<style lang="scss" scoped>
.wrapper {
  width: 100%;
  display: flex;
  justify-content: center;
}

.toast {
  border-radius: 8px;
  padding: 0.9rem;
  display: flex;
  flex-wrap: no-wrap;
  gap: .60rem;
  border: 3px solid #00000000;
  max-width: 22rem;
  margin: 30px auto;
  justify-content: center;
  align-items: center;
  user-select: none;
  position: absolute;
  top: 0;
  color: var(--white);
}

.icon {
  align-items: center;
  display: flex;
  justify-content: center;
}

.--success {
  background-color: var(--primary-500);
}

.--warning {
  background-color: var(--orange-500);
}

.--error {
  background-color: var(--red-500);
}
</style>
