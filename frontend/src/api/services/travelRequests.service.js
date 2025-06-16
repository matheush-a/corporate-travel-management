import server from '@/api/server';

const usersService = {
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