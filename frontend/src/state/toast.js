import { reactive, watch } from 'vue'

const toastState = reactive({
  message: '',
  visible: false,
  type: 'info',

  show(message, type = 'info') {
    this.message = message
    this.type = type
    this.visible = true

    setTimeout(() => {
      this.visible = false
    }, 4500)
  }
})

watch(
  () => toastState.message,
  (newMessage) => {
    if (newMessage?.includes("Token inválido.")) {
      localStorage.removeItem('token')
      window.location.reload()
    }
  }
)

export default toastState
