<template>
  <MainLayout :show-header="true">
    <template v-slot:content>
      <div class="dashboard-container">
        <div class="filters">
          <label for="statusFilter">Filtrar por status:</label>
          <select id="statusFilter" v-model="selectedStatus" @change="onStatusChange">
            <option value="">Todos</option>
            <option v-for="status in statuses" :key="status" :value="status">
              {{ status }}
            </option>
          </select>
        </div>

        <h2>Solicitações de viagem</h2>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Solicitante</th>
              <th>Destino</th>
              <th>Data de ida</th>
              <th>Data de volta</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item, index in travelRequests" :key="index">
              <td>{{ item.id }}</td>
              <td>{{ item.requester_name }}</td>
              <td>{{ item.destination }}</td>
              <td>{{ new Date(item.departure_date).toLocaleDateString() }}</td>
              <td>{{ new Date(item.return_date).toLocaleDateString() }}</td>
              <td>{{ item.status }}</td>
              <td class="actions">
                <button v-if="item.status !== 'aprovado'" @click="updateTravelRequest(item.id, 'aprovado')">Aprovar</button>
                <button v-if="item.status !== 'cancelado'" @click="updateTravelRequest(item.id, 'cancelado')">Cancelar</button>
              </td>
            </tr>
            <tr v-if="travelRequests.length === 0">
              <td colspan="7" class="text-center">Nenhuma solicitação encontrada.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
  </MainLayout>
</template>

<script>
import { defineComponent } from 'vue'
import MainLayout from '@/layouts/MainLayout.vue'
import travelRequestsService from '@/api/services/travelRequests.service'
import toastState from '@/state/toast'
import loaderState from '@/state/loader'

export default defineComponent({
  name: 'DashboardView',
  components: {
    MainLayout,
  },
  data() {
    return {
      travelRequests: [],
      selectedStatus: '',
      statuses: ['Solicitado', 'Cancelado', 'Aprovado'],
    }
  },
  methods: {
    async getTravelRequests() {
      try {
        loaderState.setIsLoading(true)

        const query = this.selectedStatus
          ? `?status=${encodeURIComponent(this.selectedStatus)}`
          : ''

        const { data } = await travelRequestsService.index(query)
        
        this.travelRequests = data
        loaderState.setIsLoading(false)
      } catch (error) {
        const message = error.response?.data?.error
        toastState.show(message, 'error')
      }
    },
    async updateTravelRequest(id, status) {
      try {
        await travelRequestsService.update(id, status)
        await this.getTravelRequests()
        toastState.show('Solicitação atualizada com sucesso.', 'success')
      } catch (error) {
        const message = error.response?.data?.error
        toastState.show(message, 'error')
      }
    },
    async onStatusChange() {
      await this.getTravelRequests()
    }
  },
  async mounted() {
    const token = localStorage.getItem('token')
    console.log('Token:', token)

    await this.getTravelRequests()
  },
})
</script>

<style scoped lang="scss">
.dashboard-container {
  padding: 2rem;
  width: 100%;
  overflow-x: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.filters {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 1.5rem;
  font-size: 0.95rem;
  color: #111827;

  select {
    padding: 0.4rem 0.75rem;
    border-radius: 0.375rem;
    border: 1px solid #d1d5db;
    background-color: #ffffff;
    color: #111827;
    font-size: 0.95rem;
  }

  @media (prefers-color-scheme: dark) {
    color: #f9fafb;

    select {
      background-color: #374151;
      border-color: #4b5563;
      color: #f9fafb;
    }
  }
}

.table {
  width: 100%;
  max-width: 960px;
  border-collapse: collapse;
  border-radius: 0.75rem;
  font-size: 0.95rem;
  line-height: 1.5;
  background-color: #ffffff;
  color: #111827;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.table thead {
  background-color: #f3f4f6;
}

.table th,
.table td {
  padding: 1rem 1.25rem;
  text-align: left;
  border-bottom: 1px solid #e5e7eb;
  white-space: nowrap;
  text-transform: capitalize;

  &.text-center {
    text-align: center;
  }
}

.table tbody tr:hover {
  background-color: #f9fafb;
}

.table td.actions {
  display: flex;
  gap: 0.5rem;
}

@media (prefers-color-scheme: dark) {
  .table {
    background-color: #1f2937;
    color: #f9fafb;
    box-shadow: 0 2px 8px rgba(255, 255, 255, 0.05);
  }

  .table thead {
    background-color: #374151;
  }

  .table th,
  .table td {
    border-bottom: 1px solid #4b5563;
  }

  .table tbody tr:hover {
    background-color: #2d3748;
  }
}
</style>
