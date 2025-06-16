import { reactive } from 'vue';

const loaderState = reactive({
  isLoading: false,
  setIsLoading(value) {
    if (!value) {
      setTimeout(() => {
        this.isLoading = value;
      }, 2500);

      return;
    }

    this.isLoading = value;
  }
});

export default loaderState;
