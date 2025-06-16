import server from '@/api/server';

const usersService = {
  create: async (formData) => {
    const response = await server.post(
      `/travel-requests`,
      formData,
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        }
      }
    )
  
    return response
  },
  index: async (query) => {
    const response = server.get(`/travel-requests${query ? `?${query.toLowerCase()}` : ''}`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      }
    });
    
    return response;
  },
  update: async (id, status) => {
    const response = await server.put(
      `/travel-requests/${id}`,
      {
        status
      }, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        }
      }
    )
  
    return response
  }
}

export default usersService;