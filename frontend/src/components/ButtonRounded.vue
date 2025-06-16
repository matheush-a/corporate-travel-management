<template>
  <button :class="classes">
    {{ text }}
  </button>
</template>

<script>
export default {
  name: 'ButtonRounded',
  props: {
    text: {
      type: String,
      required: true,
    },
    classes: {
      type: {
        type: Array,
        required: false,
      },
    }
  }
};
</script>

<style lang="scss" scoped>
button {
  width: 100%;
  padding: 1rem;
  cursor: pointer;
  font-weight: 600;
  border-radius: 8px;
  background: var(--cream-200);
  color: var(--text-color);
  transition: background 0.3s ease, color 0.3s ease;
  border: 3px solid #00000000;

  &:hover {
    background: var(--cream-400);
  }

  @media (prefers-color-scheme: light) {
    background: var(--gray-700);
    color: var(--white);

    &:hover {
      background: var(--gray-900);
    }
  }
}

button.primary {
  background: linear-gradient(90deg, var(--primary), var(--secondary));
  color: var(--white);
  transition: border 0.3s ease, color 0.3s ease;

  &:hover {
    border: 3px solid var(--secondary-700);
  }
}
</style>

