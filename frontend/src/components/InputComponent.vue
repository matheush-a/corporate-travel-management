<template>
  <div class="input-wrapper">
    <label :for="id" v-if="label">
      {{ label }}
    </label>
    <input
      :type="type"
      :autocomplete="autoComplete"
      :id="id"
      :value="modelValue"
      @input="updateValue"
    />
  </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'InputComponent',
  props: {
    id: {
      type: String,
      required: false,
    },
    label: {
      type: String,
      required: false,
    },
    type: {
      type: String,
      required: false,
      default: 'text',
    },
    autoComplete: {
      type: String,
      required: false,
      default: 'on',
    },
    modelValue: {
      type: String,
      required: false,
    }
  },
  emits: ['update:modelValue'],
  methods: {
    updateValue(event) {
      this.$emit('update:modelValue', event.target.value)
    }
  }
})
</script>

<style lang="scss" scoped>
.input-wrapper {
  display: flex;
  flex-direction: column;
  gap: .25rem;
  flex-wrap: nowrap;
  width: 100%;

  &:focus-within {
    label {
      color: var(--primary);
      font-weight: 600;
    }
  }

  label {
    font-weight: 400;
    text-align: left;
  }

  input {
    padding: .75rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    transition: border 0.3s ease, border 0.3s ease;
    outline: 1px solid rgba(0, 0, 0, 0);
    background-color: var(--gray-900);

    &:focus, &:active {
      outline: none;
      border: 2px solid var(--primary) !important;
    }

    &:-webkit-autofill,
    &:-webkit-autofill:hover, 
    &:-webkit-autofill:focus, 
    &:-webkit-autofill:active {
      -webkit-background-clip: text;
      -webkit-text-fill-color: var(--text-color);
      transition: background-color 5000s ease-in-out 0s;
      box-shadow: inset 0 0 20px 20px var(--gray-100);
      
      @media (prefers-color-scheme: light) {
        box-shadow: inset 0 0 20px 20px var(--gray-50);
      }
    }

    @media (prefers-color-scheme: light) {
      background-color: var(--gray-50);
    }
  }
}
</style>
