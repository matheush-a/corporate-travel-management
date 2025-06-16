<template>
  <MainLayout>
    <template v-slot:content>
      <div class="login-container">
        <h2>Login</h2>
        <input-component
          :id="'email'"
          :label="'E-mail'"
          v-model="formData.email"
        />
        <input-component
          :id="'password'"
          :label="'Senha'"
          :type="'password'"
          v-model="formData.password"
        />

        <button-rounded
          :classes="['primary']"
          :text="'Entrar'"
          @click="login"
        />
      </div>
    </template>
  </MainLayout>
</template>

<script>
import { defineComponent } from 'vue'
import MainLayout from '@/layouts/MainLayout.vue'
import authService from '@/api/services/auth.service'
import InputComponent from '@/components/InputComponent.vue'
import toastState from '@/state/toast'
import ButtonRounded from '@/components/ButtonRounded.vue'

export default defineComponent({
  name: 'LoginView',
  components: {
    MainLayout,
    InputComponent,
    ButtonRounded,
  },
  data() {
    return {
      formData: {
        email: '',
        password: '',
      }
    }
  },
  methods: {
    async login() {
      try {
        const { data } = await authService.login(this.formData)
        localStorage.setItem('token', data.token)
        this.$router.push({ name: 'DashboardView' });
      } catch (error) {
        const message = error.response?.data?.error || 'Erro ao fazer login. Verifique suas credenciais.'
        toastState.show(message, 'error')
        return;
      }
    }
  },
})
</script>

<style scoped lang="scss">
.login-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  gap: 1rem;

  @media screen and (min-width: 768px) {
    width: 400px;
    margin: auto;
  }
}
</style>
